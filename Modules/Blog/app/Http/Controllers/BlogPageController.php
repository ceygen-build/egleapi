<?php

namespace Modules\Blog\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use App\Support\FileUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Blog\Models\BlogPage;

class BlogPageController extends Controller
{
    use ApiResponse;

    /**
     * Retrieve all custom blog/media pages.
     */
    public function index(): JsonResponse
    {
        $pages = BlogPage::all();
        return $this->successResponse($pages);
    }

    /**
     * Retrieve a single blog page by slug.
     */
    public function show(string $slug): JsonResponse
    {
        $page = BlogPage::where('slug', $slug)->firstOrFail();
        return $this->successResponse($page);
    }

    /**
     * Update a single blog page by slug.
     */
    public function update(Request $request, string $slug): JsonResponse
    {
        $page = BlogPage::where('slug', $slug)->firstOrFail();

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

        return $this->successResponse($page, 'Blog page updated successfully.');
    }
}

