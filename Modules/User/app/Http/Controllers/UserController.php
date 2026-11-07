<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the users.
     */
    public function index(): JsonResponse
    {
        $users = User::orderBy('id', 'desc')->get();
        return $this->successResponse($users);
    }

    /**
     * Store a newly created user in database.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role' => ['required', 'string', 'in:Administrator,Editor,Viewer'],
            'status' => ['required', 'string', 'in:Active,Inactive'],
        ]);

        // Default password for created users
        $validated['password'] = Hash::make('password123');

        $user = User::create($validated);

        return $this->successResponse($user, 'User created successfully.', 201);
    }

    /**
     * Update the specified user in database.
     */
    public function update(Request $request, $id): JsonResponse
    {
        $user = User::findOrFail($id);

        // Prevent modification of main administrator account email
        if (in_array($user->email, ['admin@eaglelogistic.com', 'admin@interglob.com']) && $request->input('email') !== $user->email) {
            return $this->errorResponse('The email of the main administrator account cannot be changed.', 403);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', 'string', 'in:Administrator,Editor,Viewer'],
            'status' => ['required', 'string', 'in:Active,Inactive'],
        ]);

        $user->update($validated);

        return $this->successResponse($user, 'User details updated successfully.');
    }

    /**
     * Remove the specified user from database.
     */
    public function destroy($id): JsonResponse
    {
        $user = User::findOrFail($id);

        if (in_array($user->email, ['admin@eaglelogistic.com', 'admin@interglob.com'])) {
            return $this->errorResponse('The main administrator account cannot be deleted.', 403);
        }

        $user->delete();

        return $this->successResponse(null, 'User account deleted successfully.');
    }
}
