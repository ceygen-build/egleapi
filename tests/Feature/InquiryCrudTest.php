<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Inquiry\Models\InquiryModel;
use Tests\TestCase;

class InquiryCrudTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test guest can submit inquiry.
     */
    public function test_guest_can_submit_inquiry()
    {
        $response = $this->postJson('/api/inquiries', [
            'name' => 'John Doe',
            'email' => 'john@doe.com',
            'phone' => '+94771234567',
            'subject' => 'Freight Cost Quote',
            'message' => 'Please quote for Singapore to Colombo.',
            'date' => '2026-08-07 14:00',
        ]);

        $response->assertStatus(201)
            ->assertJsonPath('data.name', 'John Doe')
            ->assertJsonPath('data.status', 'Unread');

        $this->assertDatabaseHas('inquiries', [
            'name' => 'John Doe',
            'subject' => 'Freight Cost Quote',
        ]);
    }

    /**
     * Test admin can fetch inquiries list.
     */
    public function test_admin_can_fetch_inquiries()
    {
        $admin = User::factory()->create(['role' => 'Administrator']);
        InquiryModel::create([
            'name' => 'John Doe',
            'email' => 'john@doe.com',
            'phone' => '12345',
            'subject' => 'Quote',
            'message' => 'Quote details',
            'status' => 'Unread',
            'date' => '2026-08-07 14:00',
        ]);

        $response = $this->actingAs($admin, 'sanctum')
            ->getJson('/api/inquiries');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.name', 'John Doe');
    }

    /**
     * Test admin can update inquiry status.
     */
    public function test_admin_can_update_inquiry_status()
    {
        $admin = User::factory()->create(['role' => 'Administrator']);
        $inquiry = InquiryModel::create([
            'name' => 'John Doe',
            'email' => 'john@doe.com',
            'phone' => '12345',
            'subject' => 'Quote',
            'message' => 'Quote details',
            'status' => 'Unread',
            'date' => '2026-08-07 14:00',
        ]);

        $response = $this->actingAs($admin, 'sanctum')
            ->putJson("/api/inquiries/{$inquiry->id}", [
                'status' => 'Replied',
            ]);

        $response->assertStatus(200)
            ->assertJsonPath('data.status', 'Replied');

        $this->assertDatabaseHas('inquiries', [
            'id' => $inquiry->id,
            'status' => 'Replied',
        ]);
    }

    /**
     * Test admin can delete inquiry.
     */
    public function test_admin_can_delete_inquiry()
    {
        $admin = User::factory()->create(['role' => 'Administrator']);
        $inquiry = InquiryModel::create([
            'name' => 'John Doe',
            'email' => 'john@doe.com',
            'phone' => '12345',
            'subject' => 'Quote',
            'message' => 'Quote details',
            'status' => 'Unread',
            'date' => '2026-08-07 14:00',
        ]);

        $response = $this->actingAs($admin, 'sanctum')
            ->deleteJson("/api/inquiries/{$inquiry->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('inquiries', ['id' => $inquiry->id]);
    }
}
