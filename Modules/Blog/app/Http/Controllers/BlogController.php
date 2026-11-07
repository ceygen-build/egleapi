<?php

namespace Modules\Blog\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use App\Support\FileUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Blog\Models\BlogPost;

class BlogController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the blog posts.
     */
    public function index(): JsonResponse
    {
        $blogs = BlogPost::orderBy('created_at', 'desc')->get();
        return $this->successResponse($blogs);
    }

    /**
     * Store a newly created blog post in database.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'id' => ['required', 'string', 'unique:blogs,id'],
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['required', 'string'],
            'category' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
            'author_role' => ['required', 'string', 'max:255'],
            'author_avatar' => ['nullable', 'string', 'max:255'],
            'date' => ['required', 'string', 'max:255'],
            'read_time' => ['required', 'string', 'max:255'],
            'image' => ['required', 'string'],
            'featured' => ['required', 'boolean'],
            'content' => ['nullable', 'array'],
            'key_takeaways' => ['nullable', 'array'],
            'tags' => ['nullable', 'array'],
        ]);

        $blog = BlogPost::create($validated);

        return $this->successResponse($blog, 'Blog post created successfully.', 201);
    }

    /**
     * Update the specified blog post in database.
     */
    public function update(Request $request, $id): JsonResponse
    {
        $blog = BlogPost::findOrFail($id);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['required', 'string'],
            'category' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
            'author_role' => ['required', 'string', 'max:255'],
            'author_avatar' => ['nullable', 'string', 'max:255'],
            'date' => ['required', 'string', 'max:255'],
            'read_time' => ['required', 'string', 'max:255'],
            'image' => ['required', 'string'],
            'featured' => ['required', 'boolean'],
            'content' => ['nullable', 'array'],
            'key_takeaways' => ['nullable', 'array'],
            'tags' => ['nullable', 'array'],
        ]);

        $oldImage = $blog->image;
        $oldAvatar = $blog->author_avatar;

        $blog->update($validated);

        if ($oldImage && array_key_exists('image', $validated) && $oldImage !== $validated['image']) {
            FileUploadService::deleteUploadFile($oldImage);
        }
        if ($oldAvatar && array_key_exists('author_avatar', $validated) && $oldAvatar !== $validated['author_avatar']) {
            FileUploadService::deleteUploadFile($oldAvatar);
        }

        return $this->successResponse($blog, 'Blog post updated successfully.');
    }

    /**
     * Remove the specified blog post from database.
     */
    public function destroy($id): JsonResponse
    {
        $blog = BlogPost::findOrFail($id);
        FileUploadService::deleteUploadFile($blog->image);
        FileUploadService::deleteUploadFile($blog->author_avatar);
        $blog->delete();

        return $this->successResponse(null, 'Blog post deleted successfully.');
    }
}
