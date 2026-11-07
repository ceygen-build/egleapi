<?php

namespace App\Http\Controllers;

use App\Models\EstimateRequest;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EstimateRequestController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of estimate quote requests (Admin).
     */
    public function index(): JsonResponse
    {
        if (EstimateRequest::count() === 0) {
            $defaultEstimates = [
                [
                    'phone' => '+94 77 123 4567',
                    'email' => 'importer@globaltrade.lk',
                    'city_departure' => 'Colombo Port (CMB)',
                    'delivery_city' => 'Rotterdam Gateway (RTM)',
                    'weight' => '1,200 kg',
                    'length' => '120 cm',
                    'width' => '80 cm',
                    'height' => '160 cm',
                    'status' => 'Pending',
                    'admin_notes' => 'Awaiting ocean carrier capacity confirmation.',
                ],
                [
                    'phone' => '+65 9123 4567',
                    'email' => 'supply@singaporecargo.com',
                    'city_departure' => 'Singapore Hub (SIN)',
                    'delivery_city' => 'Los Angeles Terminal (LAX)',
                    'weight' => '850 kg',
                    'length' => '100 cm',
                    'width' => '60 cm',
                    'height' => '80 cm',
                    'status' => 'Contacted',
                    'quoted_amount' => 3450.00,
                    'admin_notes' => 'Contacted client regarding air express tariff options.',
                ],
            ];

            foreach ($defaultEstimates as $est) {
                EstimateRequest::create($est);
            }
        }

        $estimates = EstimateRequest::orderBy('created_at', 'desc')->get();
        return $this->successResponse($estimates);
    }

    /**
     * Store a newly created estimate request from the guest public website.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'phone' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255'],
            'city_departure' => ['required', 'string', 'max:255'],
            'delivery_city' => ['required', 'string', 'max:255'],
            'weight' => ['nullable', 'string', 'max:50'],
            'length' => ['nullable', 'string', 'max:50'],
            'width' => ['nullable', 'string', 'max:50'],
            'height' => ['nullable', 'string', 'max:50'],
        ]);

        $validated['status'] = 'Pending';

        $estimate = EstimateRequest::create($validated);

        // Also duplicate to inquiries table so it appears in both "Inquiries & Leads" and "Estimates & Quotes"
        try {
            $dims = [];
            if ($estimate->weight) $dims[] = "Weight: {$estimate->weight}";
            if ($estimate->length) $dims[] = "Length: {$estimate->length} cm";
            if ($estimate->width) $dims[] = "Width: {$estimate->width} cm";
            $dimsStr = !empty($dims) ? implode(' | ', $dims) : 'Standard Freight Cargo';

            \Modules\Inquiry\Models\InquiryModel::create([
                'name' => "Quote: {$estimate->city_departure} ➔ {$estimate->delivery_city}",
                'email' => $estimate->email,
                'phone' => $estimate->phone,
                'subject' => "Freight Quote Request ({$estimate->city_departure} -> {$estimate->delivery_city})",
                'message' => "Route: {$estimate->city_departure} to {$estimate->delivery_city}\nPackage: {$dimsStr}",
                'date' => now()->toDateString(),
                'status' => 'Unread',
            ]);
        } catch (\Throwable $e) {
            \Log::warning('Could not sync estimate to inquiries table: ' . $e->getMessage());
        }

        return $this->successResponse($estimate, 'Your estimate request has been submitted successfully!', 201);
    }

    /**
     * Update the estimate request (status, quote amount, admin notes).
     */
    public function update(Request $request, $id): JsonResponse
    {
        $estimate = EstimateRequest::findOrFail($id);

        $validated = $request->validate([
            'status' => ['nullable', 'string', 'max:50'],
            'quoted_amount' => ['nullable', 'numeric'],
            'admin_notes' => ['nullable', 'string'],
        ]);

        $estimate->update($validated);

        if (!empty($validated['status'])) {
            try {
                \Modules\Inquiry\Models\InquiryModel::where('email', $estimate->email)
                    ->where('phone', $estimate->phone)
                    ->update([
                        'status' => in_array($validated['status'], ['Contacted', 'Quoted', 'Completed']) ? 'Replied' : 'Read'
                    ]);
            } catch (\Throwable $e) {
                // Non-blocking sync
            }
        }

        return $this->successResponse($estimate, 'Estimate request updated successfully.');
    }

    /**
     * Remove the estimate request from database.
     */
    public function destroy($id): JsonResponse
    {
        $estimate = EstimateRequest::findOrFail($id);
        $estimate->delete();

        return $this->successResponse(null, 'Estimate request deleted successfully.');
    }
}

