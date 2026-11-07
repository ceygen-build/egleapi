<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Modules\Partner\Models\PartnerModel;
use Tests\TestCase;

class PartnerCrudTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test public fetch partners list.
     */
    public function test_anyone_can_fetch_partners()
    {
        PartnerModel::create([
            'name' => 'Maersk Line',
            'logo_path' => 'https://localhost/uploads/partners/dummy.png',
        ]);

        $response = $this->getJson('/api/partners');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.name', 'Maersk Line');
    }

    /**
     * Test admin can create a new partner.
     */
    public function test_admin_can_create_partner()
    {
        $admin = User::factory()->create(['role' => 'Administrator']);
        
        Storage::fake('public');
        $file = UploadedFile::fake()->image('partner_logo.png');

        $response = $this->actingAs($admin, 'sanctum')
            ->postJson('/api/partners', [
                'name' => 'DHL Express',
                'logo_file' => $file,
            ]);

        $response->assertStatus(201)
            ->assertJsonPath('data.name', 'DHL Express');

        $this->assertDatabaseHas('partners', [
            'name' => 'DHL Express',
        ]);
    }

    /**
     * Test admin can update a partner.
     */
    public function test_admin_can_update_partner()
    {
        $admin = User::factory()->create(['role' => 'Administrator']);
        $partner = PartnerModel::create([
            'name' => 'Flexport Old',
            'logo_path' => 'https://localhost/uploads/partners/dummy.png',
        ]);

        $response = $this->actingAs($admin, 'sanctum')
            ->postJson("/api/partners/{$partner->id}", [
                'name' => 'Flexport New',
            ]);

        $response->assertStatus(200)
            ->assertJsonPath('data.name', 'Flexport New');

        $this->assertDatabaseHas('partners', [
            'id' => $partner->id,
            'name' => 'Flexport New',
        ]);
    }

    /**
     * Test admin can delete a partner.
     */
    public function test_admin_can_delete_partner()
    {
        $admin = User::factory()->create(['role' => 'Administrator']);
        $partner = PartnerModel::create([
            'name' => 'Maersk Line',
            'logo_path' => 'https://localhost/uploads/partners/dummy.png',
        ]);

        $response = $this->actingAs($admin, 'sanctum')
            ->deleteJson("/api/partners/{$partner->id}");

        $response->assertStatus(200);

        $this->assertDatabaseMissing('partners', [
            'id' => $partner->id,
        ]);
    }
}
