<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Contact\Models\ContactDetails;
use Tests\TestCase;

class ContactCrudTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test public fetch contact details.
     */
    public function test_anyone_can_fetch_contact_details()
    {
        ContactDetails::create([
            'phone' => '+94771112233',
            'email' => 'contact@test.com',
            'address' => 'Test Address',
            'map_iframe_url' => 'https://maps.google.com/test',
        ]);

        $response = $this->getJson('/api/contact-details');

        $response->assertStatus(200)
            ->assertJsonPath('data.phone', '+94771112233')
            ->assertJsonPath('data.email', 'contact@test.com');
    }

    /**
     * Test admin can update contact details.
     */
    public function test_admin_can_update_contact_details()
    {
        $admin = User::factory()->create(['role' => 'Administrator']);
        
        // Initial insert
        ContactDetails::create([
            'phone' => '+94771112233',
            'email' => 'contact@test.com',
            'address' => 'Test Address',
            'map_iframe_url' => 'https://maps.google.com/test',
        ]);

        $response = $this->actingAs($admin, 'sanctum')
            ->postJson('/api/contact-details', [
                'phone' => '+94779998877',
                'email' => 'updated@test.com',
                'address' => 'Updated Address',
                'map_iframe_url' => 'https://maps.google.com/updated',
            ]);

        $response->assertStatus(200)
            ->assertJsonPath('data.phone', '+94779998877')
            ->assertJsonPath('data.email', 'updated@test.com');

        $this->assertDatabaseHas('contact_details', [
            'phone' => '+94779998877',
            'email' => 'updated@test.com',
        ]);
    }
}
