<?php

namespace Modules\Team\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use App\Support\FileUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Team\Models\TeamMember;

class TeamController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the team members.
     */
    public function index(): JsonResponse
    {
        $team = TeamMember::orderBy('order_index', 'asc')->orderBy('id', 'asc')->get();
        return $this->successResponse($team);
    }

    /**
     * Store a newly created team member in database.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'max:255'],
            'group' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'string'],
            'order_index' => ['nullable', 'integer'],
            'show_on_home' => ['nullable', 'boolean'],
            'bio' => ['nullable', 'string'],
            'linkedin' => ['nullable', 'string', 'max:255'],
            'twitter' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255'],
            'education' => ['nullable', 'array'],
        ]);

        if (empty($validated['group'])) {
            $validated['group'] = 'Board of Directors';
        }

        if (!isset($validated['order_index'])) {
            $maxOrder = TeamMember::max('order_index') ?? 0;
            $validated['order_index'] = $maxOrder + 1;
        }

        if (!isset($validated['show_on_home'])) {
            $validated['show_on_home'] = false;
        }

        $member = TeamMember::create($validated);

        return $this->successResponse($member, 'Team member created successfully.', 201);
    }

    /**
     * Update the specified team member in database.
     */
    public function update(Request $request, $id): JsonResponse
    {
        $member = TeamMember::findOrFail($id);

        $validated = $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'role' => ['sometimes', 'required', 'string', 'max:255'],
            'group' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'string'],
            'order_index' => ['nullable', 'integer'],
            'show_on_home' => ['nullable', 'boolean'],
            'bio' => ['nullable', 'string'],
            'linkedin' => ['nullable', 'string', 'max:255'],
            'twitter' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255'],
            'education' => ['nullable', 'array'],
        ]);

        $oldImage = $member->image;

        $member->update($validated);

        if ($oldImage && array_key_exists('image', $validated) && $oldImage !== $validated['image']) {
            FileUploadService::deleteUploadFile($oldImage);
        }

        return $this->successResponse($member, 'Team member updated successfully.');
    }

    /**
     * Remove the specified team member from database.
     */
    public function destroy($id): JsonResponse
    {
        $member = TeamMember::findOrFail($id);
        FileUploadService::deleteUploadFile($member->image);
        $member->delete();

        return $this->successResponse(null, 'Team member deleted successfully.');
    }
}
