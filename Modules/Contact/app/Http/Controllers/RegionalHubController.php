<?php

namespace Modules\Contact\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Contact\Models\RegionalHub;

class RegionalHubController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of regional hubs.
     */
    public function index(): JsonResponse
    {
        if (RegionalHub::count() === 0) {
            $initialHubs = [
                ['name' => 'Colombo HQ', 'phone' => '+94 11 234 5678', 'sort_order' => 1, 'is_active' => true],
                ['name' => 'Singapore Hub', 'phone' => '+65 6789 0123', 'sort_order' => 2, 'is_active' => true],
                ['name' => 'Rotterdam Gateway', 'phone' => '+31 10 987 6543', 'sort_order' => 3, 'is_active' => true],
                ['name' => 'Los Angeles Terminal', 'phone' => '+1 213 555 0199', 'sort_order' => 4, 'is_active' => true],
            ];

            foreach ($initialHubs as $hub) {
                RegionalHub::create($hub);
            }
        }

        $hubs = RegionalHub::orderBy('sort_order', 'asc')->orderBy('id', 'asc')->get();

        return $this->successResponse($hubs);
    }

    /**
     * Store a newly created regional hub.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $hub = RegionalHub::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'address' => $validated['address'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $validated['is_active'] ?? true,
        ]);

        return $this->successResponse($hub, 'Regional hub created successfully.');
    }

    /**
     * Update the specified regional hub.
     */
    public function update(Request $request, $id): JsonResponse
    {
        $hub = RegionalHub::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $hub->update($validated);

        return $this->successResponse($hub, 'Regional hub updated successfully.');
    }

    /**
     * Remove the specified regional hub.
     */
    public function destroy($id): JsonResponse
    {
        $hub = RegionalHub::findOrFail($id);
        $hub->delete();

        return $this->successResponse(null, 'Regional hub deleted successfully.');
    }
}
