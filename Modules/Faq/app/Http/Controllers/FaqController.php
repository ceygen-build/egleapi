<?php

namespace Modules\Faq\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Faq\Models\FaqItem;

class FaqController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the FAQs.
     */
    public function index(): JsonResponse
    {
        $faqs = FaqItem::orderBy('created_at', 'desc')->get();
        return $this->successResponse($faqs);
    }

    /**
     * Store a newly created FAQ in database.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'question' => ['required', 'string', 'max:255'],
            'answer' => ['required', 'string'],
        ]);

        $faq = FaqItem::create($validated);

        return $this->successResponse($faq, 'FAQ created successfully.', 201);
    }

    /**
     * Update the specified FAQ in database.
     */
    public function update(Request $request, $id): JsonResponse
    {
        $faq = FaqItem::findOrFail($id);

        $validated = $request->validate([
            'question' => ['required', 'string', 'max:255'],
            'answer' => ['required', 'string'],
        ]);

        $faq->update($validated);

        return $this->successResponse($faq, 'FAQ updated successfully.');
    }

    /**
     * Remove the specified FAQ from database.
     */
    public function destroy($id): JsonResponse
    {
        $faq = FaqItem::findOrFail($id);
        $faq->delete();

        return $this->successResponse(null, 'FAQ deleted successfully.');
    }
}
