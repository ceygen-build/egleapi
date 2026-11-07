<?php

namespace Modules\Hero\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use App\Support\FileUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Hero\Models\HeroSlide;

class HeroController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the hero slides.
     */
    public function index(): JsonResponse
    {
        $slides = HeroSlide::orderBy('id', 'desc')->get();
        return $this->successResponse($slides);
    }

    /**
     * Store a newly created hero slide in database.
     */
    public function store(Request $request): JsonResponse
    {
        $input = $request->all();

        // Support aliases between frontend and backend conventions
        if (isset($input['bg_image']) && !isset($input['image'])) {
            $input['image'] = $input['bg_image'];
        }
        if (isset($input['tag']) && !isset($input['subtitle'])) {
            $input['subtitle'] = $input['tag'];
        }
        if (isset($input['cta']) && !isset($input['cta_label'])) {
            $input['cta_label'] = $input['cta'];
        }
        if (isset($input['cta_link']) && !isset($input['cta_href'])) {
            $input['cta_href'] = $input['cta_link'];
        }

        $validated = validator($input, [
            'is_active' => ['nullable', 'boolean'],
            'target_page' => ['nullable', 'string'],
            'is_multiple' => ['nullable', 'boolean'],
            'image' => ['nullable', 'string'],
            'title' => ['nullable', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'images' => ['nullable', 'array'],
            'cta_label' => ['nullable', 'string', 'max:255'],
            'cta_href' => ['nullable', 'string', 'max:255'],
            'stat_value' => ['nullable', 'string', 'max:255'],
            'stat_label' => ['nullable', 'string', 'max:255'],
            'category' => ['nullable', 'string'],
            'sub_slides' => ['nullable', 'array'],
        ])->validate();

        if (empty($validated['target_page'])) {
            $validated['target_page'] = '/';
        }
        if (!isset($validated['is_multiple'])) {
            $validated['is_multiple'] = !empty($validated['images']) && count($validated['images']) > 1;
        }
        if (!isset($validated['is_active'])) {
            $validated['is_active'] = true;
        }

        // If images array is empty but single image provided, populate images array
        if (empty($validated['images']) && !empty($validated['image'])) {
            $validated['images'] = [$validated['image']];
        }

        $slide = HeroSlide::create($validated);

        return $this->successResponse($slide, 'Hero slide created successfully.', 201);
    }

    /**
     * Update the specified hero slide in database.
     */
    public function update(Request $request, $id): JsonResponse
    {
        $slide = HeroSlide::findOrFail($id);
        $input = $request->all();

        // Support aliases between frontend and backend conventions
        if (isset($input['bg_image']) && !isset($input['image'])) {
            $input['image'] = $input['bg_image'];
        }
        if (isset($input['tag']) && !isset($input['subtitle'])) {
            $input['subtitle'] = $input['tag'];
        }
        if (isset($input['cta']) && !isset($input['cta_label'])) {
            $input['cta_label'] = $input['cta'];
        }
        if (isset($input['cta_link']) && !isset($input['cta_href'])) {
            $input['cta_href'] = $input['cta_link'];
        }

        $validated = validator($input, [
            'is_active' => ['nullable', 'boolean'],
            'target_page' => ['nullable', 'string'],
            'is_multiple' => ['nullable', 'boolean'],
            'image' => ['nullable', 'string'],
            'title' => ['nullable', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'images' => ['nullable', 'array'],
            'cta_label' => ['nullable', 'string', 'max:255'],
            'cta_href' => ['nullable', 'string', 'max:255'],
            'stat_value' => ['nullable', 'string', 'max:255'],
            'stat_label' => ['nullable', 'string', 'max:255'],
            'category' => ['nullable', 'string'],
            'sub_slides' => ['nullable', 'array'],
        ])->validate();

        if (array_key_exists('target_page', $validated) && empty($validated['target_page'])) {
            $validated['target_page'] = '/';
        }
        if (isset($validated['images']) && !isset($validated['is_multiple'])) {
            $validated['is_multiple'] = count($validated['images']) > 1;
        }

        $oldImage = $slide->image;
        $oldImages = is_array($slide->images) ? $slide->images : [];

        $slide->update($validated);

        // Delete replaced primary image if it changed
        if ($oldImage && array_key_exists('image', $validated) && $oldImage !== $validated['image']) {
            FileUploadService::deleteUploadFile($oldImage);
        }

        // Delete removed multi-images
        if (isset($validated['images']) && is_array($validated['images'])) {
            $removedImages = array_diff($oldImages, $validated['images']);
            FileUploadService::deleteUploadFiles($removedImages);
        }

        return $this->successResponse($slide, 'Hero slide updated successfully.');
    }

    /**
     * Remove the specified hero slide from database.
     */
    public function destroy($id): JsonResponse
    {
        $slide = HeroSlide::findOrFail($id);

        FileUploadService::deleteUploadFile($slide->image);
        if (is_array($slide->images)) {
            FileUploadService::deleteUploadFiles($slide->images);
        }

        $slide->delete();

        return $this->successResponse(null, 'Hero slide deleted successfully.');
    }
}
