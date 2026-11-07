<?php

namespace Modules\Gallery\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use App\Support\FileUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Gallery\Models\GalleryItem;

class GalleryController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the gallery albums.
     */
    public function index(): JsonResponse
    {
        $gallery = GalleryItem::orderBy('created_at', 'desc')->get();
        return $this->successResponse($gallery);
    }

    /**
     * Store a newly created gallery album in database.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['required', 'string', 'max:255'],
            'images' => ['required', 'array'],
        ]);

        $item = GalleryItem::create($validated);

        return $this->successResponse($item, 'Gallery album created successfully.', 201);
    }

    /**
     * Update the specified gallery album in database.
     */
    public function update(Request $request, $id): JsonResponse
    {
        $item = GalleryItem::findOrFail($id);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['required', 'string', 'max:255'],
            'images' => ['required', 'array'],
        ]);

        $oldImages = is_array($item->images) ? $item->images : [];

        $item->update($validated);

        if (isset($validated['images']) && is_array($validated['images'])) {
            $removed = array_diff($oldImages, $validated['images']);
            FileUploadService::deleteUploadFiles($removed);
        }

        return $this->successResponse($item, 'Gallery album updated successfully.');
    }

    /**
     * Remove the specified gallery album from database.
     */
    public function destroy($id): JsonResponse
    {
        $item = GalleryItem::findOrFail($id);
        if (is_array($item->images)) {
            FileUploadService::deleteUploadFiles($item->images);
        }
        $item->delete();

        return $this->successResponse(null, 'Gallery album deleted successfully.');
    }
}
