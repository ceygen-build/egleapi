<?php

namespace Modules\Service\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use App\Support\FileUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Service\Models\ServiceItem;
use Modules\Service\Models\ServiceFeature;
use Modules\Service\Models\ServicePage;

class ServiceController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the service items.
     */
    public function index(): JsonResponse
    {
        $services = ServiceItem::orderBy('id', 'desc')->get();
        return $this->successResponse($services);
    }

    /**
     * Store a newly created service item in database.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'slug' => ['required', 'string', 'unique:services,slug'],
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'icon_name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'string'],
            'overview' => ['nullable', 'string'],
            'key_benefits' => ['nullable', 'array'],
            'capabilities' => ['nullable', 'array'],
            'process' => ['nullable', 'array'],
            'specifications' => ['nullable', 'array'],
        ]);

        $service = ServiceItem::create($validated);

        return $this->successResponse($service, 'Service created successfully.', 201);
    }

    /**
     * Update the specified service item in database.
     */
    public function update(Request $request, $id): JsonResponse
    {
        $service = ServiceItem::findOrFail($id);

        $validated = $request->validate([
            'slug' => ['required', 'string', 'unique:services,slug,' . $service->id],
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'icon_name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'string'],
            'overview' => ['nullable', 'string'],
            'key_benefits' => ['nullable', 'array'],
            'capabilities' => ['nullable', 'array'],
            'process' => ['nullable', 'array'],
            'specifications' => ['nullable', 'array'],
        ]);

        $oldImage = $service->image;

        $service->update($validated);

        if ($oldImage && array_key_exists('image', $validated) && $oldImage !== $validated['image']) {
            FileUploadService::deleteUploadFile($oldImage);
        }

        return $this->successResponse($service, 'Service updated successfully.');
    }

    /**
     * Remove the specified service item from database.
     */
    public function destroy($id): JsonResponse
    {
        $service = ServiceItem::findOrFail($id);
        FileUploadService::deleteUploadFile($service->image);
        $service->delete();

        return $this->successResponse(null, 'Service deleted successfully.');
    }

    /**
     * Display a listing of the service features (home carousel cards).
     */
    public function indexFeatures(): JsonResponse
    {
        if (ServiceFeature::count() === 0) {
            $defaultFeatures = [
                [
                    'title' => 'Customs House Brokerage',
                    'description' => 'The Team at Eagle Logistics is adept at handling different commodities.....',
                    'image' => 'https://images.unsplash.com/photo-1578575437130-527eed3abbec?w=700&q=80',
                    'icon' => 'customs',
                    'featured' => false,
                    'sort_order' => 1,
                    'link' => '/services',
                    'is_active' => true,
                ],
                [
                    'title' => 'International Trade',
                    'description' => 'From its inception, Eagle Logistics Colombo has specialised in International....',
                    'image' => 'https://images.unsplash.com/photo-1601584115197-04ecc0da31d7?w=700&q=80',
                    'icon' => 'trade',
                    'featured' => true,
                    'sort_order' => 2,
                    'link' => '/services',
                    'is_active' => true,
                ],
                [
                    'title' => 'Logistics BPO',
                    'description' => 'Our optimized Logistics Business Process Outsourcing Services are designed to scale your business and its...',
                    'image' => 'https://images.unsplash.com/photo-1494412574643-ff11b0a5c1c3?w=700&q=80',
                    'icon' => 'bpo',
                    'featured' => false,
                    'sort_order' => 3,
                    'link' => '/services',
                    'is_active' => true,
                ],
                [
                    'title' => 'Trade Consultation',
                    'description' => 'Our Team has over 15 years of experience in Global Trade and optimized Logistics Services...',
                    'image' => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=700&q=80',
                    'icon' => 'consultation',
                    'featured' => false,
                    'sort_order' => 4,
                    'link' => '/services',
                    'is_active' => true,
                ],
            ];

            foreach ($defaultFeatures as $item) {
                ServiceFeature::create($item);
            }
        }

        $features = ServiceFeature::orderBy('sort_order', 'asc')->orderBy('id', 'asc')->get();
        return $this->successResponse($features);
    }

    /**
     * Store a newly created service feature.
     */
    public function storeFeature(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'image' => ['nullable', 'string'],
            'icon' => ['nullable', 'string', 'max:100'],
            'featured' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer'],
            'link' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['featured'] = !empty($validated['featured']);
        $validated['is_active'] = array_key_exists('is_active', $validated) ? (bool) $validated['is_active'] : true;
        $validated['sort_order'] = $validated['sort_order'] ?? (ServiceFeature::max('sort_order') + 1);
        $validated['icon'] = $validated['icon'] ?? 'customs';

        $feature = ServiceFeature::create($validated);

        return $this->successResponse($feature, 'Service feature created successfully.', 201);
    }

    /**
     * Update the specified service feature.
     */
    public function updateFeature(Request $request, $id): JsonResponse
    {
        $feature = ServiceFeature::findOrFail($id);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'image' => ['nullable', 'string'],
            'icon' => ['nullable', 'string', 'max:100'],
            'featured' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer'],
            'link' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $oldImage = $feature->image;

        if (array_key_exists('featured', $validated)) {
            $validated['featured'] = (bool) $validated['featured'];
        }
        if (array_key_exists('is_active', $validated)) {
            $validated['is_active'] = (bool) $validated['is_active'];
        }

        $feature->update($validated);

        if ($oldImage && array_key_exists('image', $validated) && $oldImage !== $validated['image']) {
            FileUploadService::deleteUploadFile($oldImage);
        }

        return $this->successResponse($feature, 'Service feature updated successfully.');
    }

    /**
     * Remove the specified service feature.
     */
    public function destroyFeature($id): JsonResponse
    {
        $feature = ServiceFeature::findOrFail($id);
        FileUploadService::deleteUploadFile($feature->image);
        $feature->delete();

        return $this->successResponse(null, 'Service feature deleted successfully.');
    }

    /**
     * Retrieve all custom service pages.
     */
    public function indexServicePages(): JsonResponse
    {
        $pages = ServicePage::all();
        return $this->successResponse($pages);
    }

    /**
     * Retrieve a single service page by slug.
     */
    public function showServicePage(string $slug): JsonResponse
    {
        $page = ServicePage::where('slug', $slug)->firstOrFail();
        return $this->successResponse($page);
    }

    /**
     * Update a single service page by slug.
     */
    public function updateServicePage(Request $request, string $slug): JsonResponse
    {
        $page = ServicePage::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'page_name' => ['nullable', 'string', 'max:255'],
            'hero_tag' => ['nullable', 'string', 'max:255'],
            'hero_title' => ['nullable', 'string'],
            'hero_subtitle' => ['nullable', 'string'],
            'hero_image' => ['nullable', 'string'],
            'intro_label' => ['nullable', 'string', 'max:255'],
            'intro_title' => ['nullable', 'string'],
            'intro_description' => ['nullable', 'string'],
            'intro_image' => ['nullable', 'string'],
            'stats' => ['nullable'],
            'sections_data' => ['nullable'],
            'cta_title' => ['nullable', 'string'],
            'cta_desc' => ['nullable', 'string'],
            'cta_btn_text' => ['nullable', 'string', 'max:255'],
            'cta_btn_url' => ['nullable', 'string', 'max:255'],
        ]);

        $oldHeroImage = $page->hero_image;
        $oldIntroImage = $page->intro_image;

        $page->update($validated);

        if ($oldHeroImage && array_key_exists('hero_image', $validated) && $oldHeroImage !== $validated['hero_image']) {
            FileUploadService::deleteUploadFile($oldHeroImage);
        }
        if ($oldIntroImage && array_key_exists('intro_image', $validated) && $oldIntroImage !== $validated['intro_image']) {
            FileUploadService::deleteUploadFile($oldIntroImage);
        }

        return $this->successResponse($page, 'Service page updated successfully.');
    }
}
