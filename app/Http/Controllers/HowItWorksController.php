<?php

namespace App\Http\Controllers;

use App\Models\HowItWorksStep;
use App\Traits\ApiResponse;
use App\Support\FileUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HowItWorksController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the steps.
     */
    public function index(): JsonResponse
    {
        if (HowItWorksStep::count() === 0) {
            $defaultSteps = [
                [
                    'step' => '01',
                    'title' => 'Receive packages',
                    'description' => 'Sed ut perspiciatis unde omnis iste natus ut perspic iatis unde omnis iste perspiciatis ut perspiciatis unde omnis iste natus.',
                    'image' => 'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?w=800&q=80',
                    'image_only' => false,
                    'text_only' => false,
                    'sort_order' => 1,
                    'is_active' => true,
                ],
                [
                    'step' => '02',
                    'title' => 'Deliver packages',
                    'description' => 'Sed ut perspiciatis unde omnis iste natus ut perspic iatis unde omnis iste perspiciatis ut perspiciatis unde omnis iste natus.',
                    'image' => 'https://images.unsplash.com/photo-1601584115197-04ecc0da31d7?w=800&q=80',
                    'image_only' => false,
                    'text_only' => false,
                    'sort_order' => 2,
                    'is_active' => true,
                ],
                [
                    'step' => '03',
                    'title' => 'Transport packages',
                    'description' => 'Sovereign ocean cargo routes and carrier telemetries connecting multi-port international trade channels seamlessly.',
                    'image' => 'https://images.unsplash.com/photo-1605745341112-85968b19335b?w=900&q=80',
                    'image_only' => false,
                    'text_only' => false,
                    'sort_order' => 3,
                    'is_active' => true,
                ],
                [
                    'step' => '04',
                    'title' => 'Warehousing Operation',
                    'description' => 'Sed ut perspiciatis unde omnis iste natus ut perspic iatis unde omnis iste perspiciatis ut perspiciatis unde omnis iste natus. sed do euism od tempor...',
                    'image' => 'https://images.unsplash.com/photo-1553413077-190dd305871c?w=800&q=80',
                    'image_only' => false,
                    'text_only' => false,
                    'sort_order' => 4,
                    'is_active' => true,
                ],
            ];

            foreach ($defaultSteps as $step) {
                HowItWorksStep::create($step);
            }
        }

        $steps = HowItWorksStep::orderBy('sort_order', 'asc')->orderBy('id', 'asc')->get();
        return $this->successResponse($steps);
    }

    /**
     * Store a newly created step in database.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'step' => ['required', 'string', 'max:20'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'string'],
            'image_only' => ['nullable', 'boolean'],
            'text_only' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['image_only'] = !empty($validated['image_only']);
        $validated['text_only'] = !empty($validated['text_only']);
        $validated['sort_order'] = $validated['sort_order'] ?? (HowItWorksStep::max('sort_order') + 1);
        $validated['is_active'] = array_key_exists('is_active', $validated) ? (bool) $validated['is_active'] : true;

        $step = HowItWorksStep::create($validated);

        return $this->successResponse($step, 'Step created successfully.', 201);
    }

    /**
     * Update the specified step in database.
     */
    public function update(Request $request, $id): JsonResponse
    {
        $step = HowItWorksStep::findOrFail($id);

        $validated = $request->validate([
            'step' => ['required', 'string', 'max:20'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'string'],
            'image_only' => ['nullable', 'boolean'],
            'text_only' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $oldImage = $step->image;

        if (array_key_exists('image_only', $validated)) {
            $validated['image_only'] = (bool) $validated['image_only'];
        }
        if (array_key_exists('text_only', $validated)) {
            $validated['text_only'] = (bool) $validated['text_only'];
        }
        if (array_key_exists('is_active', $validated)) {
            $validated['is_active'] = (bool) $validated['is_active'];
        }

        $step->update($validated);

        if ($oldImage && array_key_exists('image', $validated) && $oldImage !== $validated['image']) {
            FileUploadService::deleteUploadFile($oldImage);
        }

        return $this->successResponse($step, 'Step updated successfully.');
    }

    /**
     * Remove the specified step from database.
     */
    public function destroy($id): JsonResponse
    {
        $step = HowItWorksStep::findOrFail($id);

        if ($step->image) {
            FileUploadService::deleteUploadFile($step->image);
        }

        $step->delete();

        return $this->successResponse(null, 'Step deleted successfully.');
    }
}

