<?php

namespace Modules\FacebookFeed\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Modules\FacebookFeed\Models\FacebookFeedItem;

class FacebookFeedController extends Controller
{
    use ApiResponse;

    /**
     * Get all synced Facebook feed items (Admin only).
     */
    public function index(): JsonResponse
    {
        $feed = FacebookFeedItem::orderBy('posted_at', 'desc')->get();
        return $this->successResponse($feed);
    }

    /**
     * Get only approved Facebook feed items (Public).
     */
    public function approved(): JsonResponse
    {
        $feed = FacebookFeedItem::where('status', 'approved')
            ->orderBy('posted_at', 'desc')
            ->get();
        return $this->successResponse($feed);
    }

    /**
     * Update the moderation status of a Facebook feed photo.
     */
    public function update(Request $request, $id): JsonResponse
    {
        $item = FacebookFeedItem::findOrFail($id);

        $validated = $request->validate([
            'status' => ['required', 'string', 'in:pending,approved,declined'],
        ]);

        $item->update($validated);

        return $this->successResponse($item, 'Facebook photo status updated.');
    }

    /**
     * Sync/Fetch photos from Facebook Graph API (or load fallback mock data on failure).
     */
    public function sync(Request $request): JsonResponse
    {
        $settings = \Modules\Settings\Models\SettingsModel::first();
        $pageId = $settings ? $settings->facebook_page_id : null;
        $token = $settings ? $settings->facebook_access_token : null;

        if (!$pageId) {
            $pageId = config('services.facebook.page_id');
        }
        if (!$token) {
            $token = config('services.facebook.access_token');
        }

        $syncedCount = 0;

        $hasDatabaseCredentials = (!empty($settings->facebook_page_id) && !empty($settings->facebook_access_token));

        if ($pageId && $token) {
            try {
                // Call FB Graph API (bypass SSL check for local development certificate issues)
                $response = Http::withoutVerifying()->get("https://graph.facebook.com/v18.0/{$pageId}/photos", [
                    'fields' => 'id,name,images,created_time',
                    'type' => 'uploaded',
                    'access_token' => $token,
                ]);

                if ($response->successful()) {
                    // Delete previous mock data if real sync succeeds
                    FacebookFeedItem::where('id', 'like', 'fb_photo_%')->delete();

                    $data = $response->json('data') ?? [];
                    foreach ($data as $photo) {
                        $id = $photo['id'] ?? null;
                        if (!$id) continue;

                        $caption = $photo['name'] ?? '';
                        $images = $photo['images'] ?? [];
                        // Get highest resolution image
                        $imageUrl = !empty($images) ? $images[0]['source'] : '';
                        $postedAt = isset($photo['created_time']) 
                            ? str_replace(['T', '+0000'], [' ', ''], $photo['created_time']) 
                            : now()->format('Y-m-d H:i');

                        // Save or update locally, keep current status if already synced
                        FacebookFeedItem::firstOrCreate(
                            ['id' => $id],
                            [
                                'caption' => $caption,
                                'fb_image_url' => $imageUrl,
                                'status' => 'pending',
                                'posted_at' => $postedAt,
                            ]
                        );
                        $syncedCount++;
                    }

                    return $this->successResponse(
                        FacebookFeedItem::orderBy('posted_at', 'desc')->get(),
                        "Successfully synced {$syncedCount} photos from Facebook page."
                    );
                } else {
                    if ($hasDatabaseCredentials) {
                        $errorMsg = $response->json('error.message') ?? 'Unknown Facebook Graph API error.';
                        return $this->errorResponse("Facebook API Error: {$errorMsg}", $response->status());
                    }
                }
            } catch (\Exception $e) {
                if ($hasDatabaseCredentials) {
                    return $this->errorResponse("Facebook Connection Exception: " . $e->getMessage(), 400);
                }
            }
        }

        // Fallback mock sync for local development / testing / token not configured
        $mockPhotos = [
            [
                'id' => 'fb_photo_101',
                'caption' => 'Cargo flight loading operations at Colombo Airport hangar.',
                'fb_image_url' => 'https://images.unsplash.com/photo-1542296332-2e4473faf563?auto=format&fit=crop&q=80&w=1200',
                'posted_at' => now()->subDays(1)->format('Y-m-d H:i'),
            ],
            [
                'id' => 'fb_photo_102',
                'caption' => 'Heavy container liner vessel docked at port terminal gate 04.',
                'fb_image_url' => 'https://images.unsplash.com/photo-1518241353330-0f7941c2d9b5?auto=format&fit=crop&q=80&w=1200',
                'posted_at' => now()->subDays(2)->format('Y-m-d H:i'),
            ],
            [
                'id' => 'fb_photo_103',
                'caption' => 'Fleet of long haulage intermodal transit trucks line up.',
                'fb_image_url' => 'https://images.unsplash.com/photo-1601584115197-04ecc0da31d7?auto=format&fit=crop&q=80&w=1200',
                'posted_at' => now()->subDays(3)->format('Y-m-d H:i'),
            ],
            [
                'id' => 'fb_photo_104',
                'caption' => 'Smart temperature controlled cold chain pharmaceutical storage warehouse.',
                'fb_image_url' => 'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&q=80&w=1200',
                'posted_at' => now()->subDays(4)->format('Y-m-d H:i'),
            ]
        ];

        foreach ($mockPhotos as $photo) {
            FacebookFeedItem::firstOrCreate(
                ['id' => $photo['id']],
                [
                    'caption' => $photo['caption'],
                    'fb_image_url' => $photo['fb_image_url'],
                    'status' => 'pending',
                    'posted_at' => $photo['posted_at'],
                ]
            );
            $syncedCount++;
        }

        return $this->successResponse(
            FacebookFeedItem::orderBy('posted_at', 'desc')->get(),
            "Successfully synced {$syncedCount} mock photos (Facebook API mock mode)."
        );
    }
}
