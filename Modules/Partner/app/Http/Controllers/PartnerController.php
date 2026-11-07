<?php

namespace Modules\Partner\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Partner\Models\PartnerModel;
use App\Support\FileUploadService;
use Illuminate\Support\Facades\File;

class PartnerController extends Controller
{
    use ApiResponse;

    /**
     * Get all partners/carriers.
     */
    public function index(): JsonResponse
    {
        $partners = PartnerModel::orderBy('id', 'desc')->get();
        return $this->successResponse($partners);
    }

    /**
     * Add a new partner/carrier.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'logo_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,svg,webp', 'max:4096'],
            'logo_path' => ['nullable', 'string'],
            'logo' => ['nullable', 'string'],
        ]);

        $partner = new PartnerModel();
        $partner->name = $validated['name'];

        if ($request->hasFile('logo_file')) {
            $file = $request->file('logo_file');
            $fileName = 'partner_' . time() . '_' . rand(100, 999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/partners'), $fileName);
            $partner->logo_path = asset('uploads/partners/' . $fileName);
        } elseif (!empty($validated['logo_path'])) {
            $partner->logo_path = $validated['logo_path'];
        } elseif (!empty($validated['logo'])) {
            $partner->logo_path = $validated['logo'];
        } else {
            $partner->logo_path = '';
        }

        $partner->save();

        return $this->successResponse($partner, 'Partner/Brand added successfully.', 201);
    }

    /**
     * Update an existing partner/carrier.
     */
    public function update(Request $request, $id): JsonResponse
    {
        $partner = PartnerModel::findOrFail($id);
        $oldLogo = $partner->logo_path;

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'logo_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,svg,webp', 'max:4096'],
            'logo_path' => ['nullable', 'string'],
            'logo' => ['nullable', 'string'],
        ]);

        $partner->name = $validated['name'];

        if ($request->hasFile('logo_file')) {
            FileUploadService::deleteUploadFile($oldLogo);

            $file = $request->file('logo_file');
            $fileName = 'partner_' . time() . '_' . rand(100, 999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/partners'), $fileName);
            $partner->logo_path = asset('uploads/partners/' . $fileName);
        } elseif (array_key_exists('logo_path', $validated)) {
            $newLogo = $validated['logo_path'] ?? '';
            if ($oldLogo && $oldLogo !== $newLogo) {
                FileUploadService::deleteUploadFile($oldLogo);
            }
            $partner->logo_path = $newLogo;
        } elseif (array_key_exists('logo', $validated)) {
            $newLogo = $validated['logo'] ?? '';
            if ($oldLogo && $oldLogo !== $newLogo) {
                FileUploadService::deleteUploadFile($oldLogo);
            }
            $partner->logo_path = $newLogo;
        }

        $partner->save();

        return $this->successResponse($partner, 'Partner/Brand updated successfully.');
    }

    /**
     * Remove a partner/carrier.
     */
    public function destroy($id): JsonResponse
    {
        $partner = PartnerModel::findOrFail($id);

        // Delete logo file from disk if it was an upload
        FileUploadService::deleteUploadFile($partner->logo_path);

        $partner->delete();

        return $this->successResponse(null, 'Carrier deleted successfully.');
    }
}
