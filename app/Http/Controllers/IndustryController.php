<?php

namespace App\Http\Controllers;

use App\Models\Industry;
use App\Traits\ApiResponse;
use App\Support\FileUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IndustryController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the industries.
     */
    public function index(): JsonResponse
    {
        if (Industry::whereNotNull('short')->count() === 0) {
            Industry::truncate();

            $defaultIndustries = [
                [
                    'name' => "Fashion &\nApparel",
                    'short' => 'Fashion',
                    'description' => 'End-to-end logistics for fashion brands — from factory to retail floor. Time-sensitive deliveries, seasonal planning and global sourcing support.',
                    'color' => '#e11d48',
                    'bg_color' => '#1a0a0d',
                    'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800&q=80',
                    'stats' => '48hr Turnaround',
                    'services' => ['Air Freight', 'Express Delivery', 'Warehousing'],
                    'icon_name' => 'fashion',
                    'sort_order' => 1,
                    'is_active' => true,
                    'link' => '/contact',
                ],
                [
                    'name' => "Medical &\nPharma",
                    'short' => 'Medical',
                    'description' => 'GDP-compliant cold chain logistics for pharmaceuticals, medical devices and healthcare products. Zero-compromise quality and regulatory adherence.',
                    'color' => '#2563eb',
                    'bg_color' => '#040e1f',
                    'image' => 'https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?w=800&q=80',
                    'stats' => 'GDP Certified',
                    'services' => ['Cold Chain', 'Logipharma', 'Customs Clearance'],
                    'icon_name' => 'medical',
                    'sort_order' => 2,
                    'is_active' => true,
                    'link' => '/contact',
                ],
                [
                    'name' => "FMCG &\nRetail",
                    'short' => 'FMCG',
                    'description' => 'High-volume, high-velocity logistics for consumer goods. We keep your supply chain moving so your shelves are never empty.',
                    'color' => '#f97316',
                    'bg_color' => '#1a0c03',
                    'image' => 'https://images.unsplash.com/photo-1578575437130-527eed3abbec?w=800&q=80',
                    'stats' => '300+ Clients',
                    'services' => ['Ocean Freight', 'LCL / FCL', 'Distribution'],
                    'icon_name' => 'fmcg',
                    'sort_order' => 3,
                    'is_active' => true,
                    'link' => '/contact',
                ],
                [
                    'name' => "Chemical &\nIndustrial",
                    'short' => 'Chemical',
                    'description' => 'Safe, compliant handling of hazardous and non-hazardous chemicals. IMDG-certified teams managing documentation, storage and cross-border movement.',
                    'color' => '#0f6e56',
                    'bg_color' => '#03120f',
                    'image' => 'https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?w=800&q=80',
                    'stats' => 'IMDG Certified',
                    'services' => ['Hazmat Handling', 'Specialized Freight', 'Compliance'],
                    'icon_name' => 'chemical',
                    'sort_order' => 4,
                    'is_active' => true,
                    'link' => '/contact',
                ],
                [
                    'name' => "Automotive &\nMachinery",
                    'short' => 'Automotive',
                    'description' => 'Heavy cargo, oversized equipment and automotive parts — handled with precision. RO/RO, breakbulk and project cargo specialists at your service.',
                    'color' => '#7c3aed',
                    'bg_color' => '#0f0820',
                    'image' => 'https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?w=800&q=80',
                    'stats' => 'RO/RO Specialists',
                    'services' => ['RO/RO', 'Project Cargo', 'Breakbulk'],
                    'icon_name' => 'auto',
                    'sort_order' => 5,
                    'is_active' => true,
                    'link' => '/contact',
                ],
            ];

            foreach ($defaultIndustries as $item) {
                Industry::create($item);
            }
        }

        $industries = Industry::orderBy('sort_order', 'asc')->orderBy('id', 'asc')->get();
        return $this->successResponse($industries);
    }

    /**
     * Store a newly created industry in database.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'short' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string'],
            'image' => ['nullable', 'string'],
            'icon_name' => ['nullable', 'string', 'max:255'],
            'stats' => ['nullable', 'string', 'max:100'],
            'color' => ['nullable', 'string', 'max:50'],
            'bg_color' => ['nullable', 'string', 'max:50'],
            'services' => ['nullable'],
            'sort_order' => ['nullable', 'integer'],
            'is_active' => ['nullable', 'boolean'],
            'link' => ['nullable', 'string', 'max:255'],
        ]);

        if (isset($validated['services']) && is_string($validated['services'])) {
            $validated['services'] = array_values(array_filter(array_map('trim', preg_split('/[\r\n,]+/', $validated['services']))));
        }

        $validated['color'] = $validated['color'] ?? '#2563eb';
        $validated['bg_color'] = $validated['bg_color'] ?? '#040e1f';
        $validated['icon_name'] = $validated['icon_name'] ?? 'fashion';
        $validated['sort_order'] = $validated['sort_order'] ?? (Industry::max('sort_order') + 1);
        $validated['is_active'] = array_key_exists('is_active', $validated) ? (bool) $validated['is_active'] : true;
        $validated['link'] = $validated['link'] ?? '/contact';

        $industry = Industry::create($validated);

        return $this->successResponse($industry, 'Industry created successfully.', 201);
    }

    /**
     * Update the specified industry in database.
     */
    public function update(Request $request, $id): JsonResponse
    {
        $industry = Industry::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'short' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string'],
            'image' => ['nullable', 'string'],
            'icon_name' => ['nullable', 'string', 'max:255'],
            'stats' => ['nullable', 'string', 'max:100'],
            'color' => ['nullable', 'string', 'max:50'],
            'bg_color' => ['nullable', 'string', 'max:50'],
            'services' => ['nullable'],
            'sort_order' => ['nullable', 'integer'],
            'is_active' => ['nullable', 'boolean'],
            'link' => ['nullable', 'string', 'max:255'],
        ]);

        if (isset($validated['services']) && is_string($validated['services'])) {
            $validated['services'] = array_values(array_filter(array_map('trim', preg_split('/[\r\n,]+/', $validated['services']))));
        }

        $oldImage = $industry->image;

        if (array_key_exists('is_active', $validated)) {
            $validated['is_active'] = (bool) $validated['is_active'];
        }

        $industry->update($validated);

        if ($oldImage && array_key_exists('image', $validated) && $oldImage !== $validated['image']) {
            FileUploadService::deleteUploadFile($oldImage);
        }

        return $this->successResponse($industry, 'Industry updated successfully.');
    }

    /**
     * Remove the specified industry from database.
     */
    public function destroy($id): JsonResponse
    {
        $industry = Industry::findOrFail($id);
        
        if ($industry->image) {
            FileUploadService::deleteUploadFile($industry->image);
        }

        $industry->delete();

        return $this->successResponse(null, 'Industry deleted successfully.');
    }
}
