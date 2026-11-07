<?php

namespace Modules\Inquiry\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\InquiryReceivedMail;
use App\Mail\InquiryReplyMail;
use App\Mail\InquiryAcknowledgementMail;
use Modules\Inquiry\Models\InquiryModel;

class InquiryController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the inquiries (Admin only).
     */
    public function index(): JsonResponse
    {
        $inquiries = InquiryModel::orderBy('created_at', 'desc')->get();
        return $this->successResponse($inquiries);
    }

    /**
     * Store a newly created inquiry from guest contact form.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
            'status' => ['nullable', 'string', 'max:255'],
            'date' => ['required', 'string', 'max:255'],
        ]);

        if (empty($validated['status'])) {
            $validated['status'] = 'Unread';
        }

        $inquiry = InquiryModel::create($validated);

        // Send email to target_email if provided
        $targetEmail = $request->input('target_email');
        if ($targetEmail && filter_var($targetEmail, FILTER_VALIDATE_EMAIL)) {
            try {
                Mail::to($targetEmail)->send(new InquiryReceivedMail($inquiry));
            } catch (\Exception $e) {
                // Log/ignore on mail dispatch failure
            }
        }

        // Send acknowledgement email to customer
        if (!empty($inquiry->email)) {
            try {
                Mail::to($inquiry->email)->send(new InquiryAcknowledgementMail($inquiry));
            } catch (\Exception $e) {
                // Log/ignore
            }
        }

        return $this->successResponse($inquiry, 'Inquiry submitted successfully.', 201);
    }

    /**
     * Update the specified inquiry status (Admin only).
     */
    public function update(Request $request, $id): JsonResponse
    {
        $inquiry = InquiryModel::findOrFail($id);

        $validated = $request->validate([
            'status' => ['required', 'string', 'max:255'],
        ]);

        $inquiry->update($validated);

        return $this->successResponse($inquiry, 'Inquiry status updated successfully.');
    }

    /**
     * Send email reply to the inquiry (Admin only).
     */
    public function reply(Request $request, $id): JsonResponse
    {
        $inquiry = InquiryModel::findOrFail($id);

        $validated = $request->validate([
            'reply_message' => ['required', 'string'],
        ]);

        // Send email
        try {
            Mail::to($inquiry->email)->send(new InquiryReplyMail($inquiry, $validated['reply_message']));
            $inquiry->update(['status' => 'Replied']);
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to send email: ' . $e->getMessage(), 500);
        }

        return $this->successResponse($inquiry, 'Reply sent successfully.');
    }

    /**
     * Remove the specified inquiry from storage (Admin only).
     */
    public function destroy($id): JsonResponse
    {
        $inquiry = InquiryModel::findOrFail($id);
        $inquiry->delete();

        return $this->successResponse(null, 'Inquiry deleted successfully.');
    }
}
