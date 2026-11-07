<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Contact\Models\ContactDetails;
use Tests\TestCase;

class RegionalContactTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test admin can save india_address and maldives_address.
     */
    public function test_admin_can_save_regional_office_addresses()
    {
        $admin = User::factory()->create(['role' => 'Administrator']);

        $response = $this->actingAs($admin, 'sanctum')
            ->postJson('/api/contact-details', [
                'phone' => '+94 11 000 0000',
                'email' => 'general@interglob.com',
                'sales_email' => 'sales@interglob.com',
                'careers_email' => 'careers@interglob.com',
                'address' => 'Colombo 03',
                'india_address' => 'Chennai India',
                'maldives_address' => 'Male Maldives',
                'map_iframe_url' => 'https://maps.google.com',
            ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('contact_details', [
            'india_address' => 'Chennai India',
            'maldives_address' => 'Male Maldives',
        ]);
    }
}
