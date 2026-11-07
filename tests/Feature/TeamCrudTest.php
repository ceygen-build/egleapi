<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Team\Models\TeamMember;
use Tests\TestCase;

class TeamCrudTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test public list team members.
     */
    public function test_anyone_can_list_team_members()
    {
        TeamMember::create([
            'name' => 'John Doe',
            'role' => 'CEO',
            'image' => 'profile.jpg',
            'order_index' => 1,
        ]);

        $response = $this->getJson('/api/team');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.name', 'John Doe');
    }

    /**
     * Test create team member.
     */
    public function test_admin_can_create_team_member()
    {
        $admin = User::factory()->create(['role' => 'Administrator']);

        $response = $this->actingAs($admin, 'sanctum')
            ->postJson('/api/team', [
                'name' => 'Jane Smith',
                'role' => 'CFO',
                'image' => 'jane.jpg',
                'order_index' => 2,
                'email' => 'jane@example.com',
            ]);

        $response->assertStatus(201)
            ->assertJsonPath('data.name', 'Jane Smith');

        $this->assertDatabaseHas('team_members', [
            'name' => 'Jane Smith',
            'role' => 'CFO',
        ]);
    }

    /**
     * Test update team member.
     */
    public function test_admin_can_update_team_member()
    {
        $admin = User::factory()->create(['role' => 'Administrator']);
        $member = TeamMember::create([
            'name' => 'Old Name',
            'role' => 'Manager',
            'image' => 'old.jpg',
            'order_index' => 5,
        ]);

        $response = $this->actingAs($admin, 'sanctum')
            ->putJson("/api/team/{$member->id}", [
                'name' => 'New Name',
                'role' => 'Director',
                'image' => 'new.jpg',
                'order_index' => 3,
                'education' => ['MBA', 'BSc'],
            ]);

        $response->assertStatus(200)
            ->assertJsonPath('data.name', 'New Name')
            ->assertJsonPath('data.order_index', 3)
            ->assertJsonPath('data.education.0', 'MBA');
    }

    /**
     * Test delete team member.
     */
    public function test_admin_can_delete_team_member()
    {
        $admin = User::factory()->create(['role' => 'Administrator']);
        $member = TeamMember::create([
            'name' => 'To Delete',
            'role' => 'Consultant',
            'image' => 'delete.jpg',
            'order_index' => 4,
        ]);

        $response = $this->actingAs($admin, 'sanctum')
            ->deleteJson("/api/team/{$member->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('team_members', ['id' => $member->id]);
    }
}
