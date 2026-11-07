<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCrudTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test list users.
     */
    public function test_can_list_users()
    {
        $admin = User::factory()->create(['role' => 'Administrator']);
        User::factory()->count(3)->create();

        $response = $this->actingAs($admin, 'sanctum')
            ->getJson('/api/users');

        $response->assertStatus(200)
            ->assertJsonCount(4, 'data');
    }

    /**
     * Test create user.
     */
    public function test_can_create_user()
    {
        $admin = User::factory()->create(['role' => 'Administrator']);

        $response = $this->actingAs($admin, 'sanctum')
            ->postJson('/api/users', [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'role' => 'Editor',
                'status' => 'Active',
            ]);

        $response->assertStatus(201)
            ->assertJsonPath('data.name', 'Jane Smith')
            ->assertJsonPath('data.role', 'Editor');

        $this->assertDatabaseHas('users', [
            'email' => 'jane@example.com',
            'role' => 'Editor',
            'status' => 'Active',
        ]);
    }

    /**
     * Test update user.
     */
    public function test_can_update_user()
    {
        $admin = User::factory()->create(['role' => 'Administrator']);
        $user = User::factory()->create(['role' => 'Viewer', 'status' => 'Active']);

        $response = $this->actingAs($admin, 'sanctum')
            ->putJson("/api/users/{$user->id}", [
                'name' => 'Updated Name',
                'email' => 'updated@example.com',
                'role' => 'Editor',
                'status' => 'Inactive',
            ]);

        $response->assertStatus(200)
            ->assertJsonPath('data.name', 'Updated Name')
            ->assertJsonPath('data.status', 'Inactive');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
            'status' => 'Inactive',
        ]);
    }

    /**
     * Test delete user.
     */
    public function test_can_delete_user()
    {
        $admin = User::factory()->create(['role' => 'Administrator']);
        $user = User::factory()->create();

        $response = $this->actingAs($admin, 'sanctum')
            ->deleteJson("/api/users/{$user->id}");

        $response->assertStatus(200);
        $this->assertSoftDeletedOrMissing($user);
    }

    /**
     * Test main administrator cannot be deleted.
     */
    public function test_cannot_delete_main_admin()
    {
        $admin = User::factory()->create(['email' => 'admin@interglob.com', 'role' => 'Administrator']);

        $response = $this->actingAs($admin, 'sanctum')
            ->deleteJson("/api/users/{$admin->id}");

        $response->assertStatus(403);
        $this->assertDatabaseHas('users', [
            'email' => 'admin@interglob.com',
        ]);
    }

    private function assertSoftDeletedOrMissing($user)
    {
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
