<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use App\Traits\ApiResponse;
use App\Support\FileUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the testimonials.
     */
    public function index(): JsonResponse
    {
        $testimonials = Testimonial::orderBy('id', 'desc')->get();
        return $this->successResponse($testimonials);
    }

    /**
     * Store a newly created testimonial (Admin).
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'avatar' => ['nullable', 'string'],
            'feedback' => ['nullable', 'string'],
            'content' => ['nullable', 'string'],
            'rating' => ['nullable', 'integer', 'min:1', 'max:5'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $feedbackText = $validated['feedback'] ?? $validated['content'] ?? $request->input('content') ?? 'Eagle Logistic provides exceptional freight forwarding and supply chain solutions.';

        $testimonial = Testimonial::create([
            'name' => $validated['name'],
            'role' => $validated['role'],
            'company' => !empty($validated['company']) ? $validated['company'] : 'Enterprise Client',
            'avatar' => $validated['avatar'] ?? null,
            'feedback' => $feedbackText,
            'rating' => $validated['rating'] ?? 5,
            'is_active' => $validated['is_active'] ?? true,
        ]);

        return $this->successResponse($testimonial, 'Testimonial created successfully.', 201);
    }

    /**
     * Update the specified testimonial (Admin).
     */
    public function update(Request $request, $id): JsonResponse
    {
        $testimonial = Testimonial::find($id);

        if (!$testimonial) {
            return $this->errorResponse('Testimonial not found.', 404);
        }

        $validated = $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'role' => ['nullable', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'avatar' => ['nullable', 'string'],
            'feedback' => ['nullable', 'string'],
            'content' => ['nullable', 'string'],
            'rating' => ['nullable', 'integer', 'min:1', 'max:5'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if (isset($validated['content']) && !isset($validated['feedback'])) {
            $validated['feedback'] = $validated['content'];
        }

        $oldAvatar = $testimonial->avatar;

        $testimonial->update($validated);

        if ($oldAvatar && array_key_exists('avatar', $validated) && $oldAvatar !== $validated['avatar']) {
            FileUploadService::deleteUploadFile($oldAvatar);
        }

        return $this->successResponse($testimonial, 'Testimonial updated successfully.');
    }

    /**
     * Store customer submitted feedback (pending approval).
     */
    public function submitPublicFeedback(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'role' => ['nullable', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'avatar' => ['nullable', 'string'],
            'feedback' => ['nullable', 'string'],
            'content' => ['nullable', 'string'],
            'rating' => ['nullable', 'integer', 'min:1', 'max:5'],
        ]);

        $feedbackText = $validated['feedback'] ?? $validated['content'] ?? 'Outstanding logistics service.';

        $testimonial = Testimonial::create([
            'name' => $validated['name'],
            'role' => !empty($validated['role']) ? $validated['role'] : 'Valued Client',
            'company' => !empty($validated['company']) ? $validated['company'] : 'Enterprise Partner',
            'avatar' => $validated['avatar'] ?? null,
            'feedback' => $feedbackText,
            'rating' => $validated['rating'] ?? 5,
            'is_active' => false, // Requires admin approval
        ]);

        return $this->successResponse($testimonial, 'Thank you! Your feedback has been submitted successfully and is awaiting review.', 201);
    }

    /**
     * Remove the specified testimonial.
     */
    public function destroy($id): JsonResponse
    {
        $testimonial = Testimonial::find($id);

        if (!$testimonial) {
            return $this->errorResponse('Testimonial not found.', 404);
        }

        if ($testimonial->avatar) {
            FileUploadService::deleteUploadFile($testimonial->avatar);
        }

        $testimonial->delete();

        return $this->successResponse(null, 'Testimonial deleted successfully.');
    }
}
