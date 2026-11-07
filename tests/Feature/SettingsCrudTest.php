<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Modules\Settings\Models\SettingsModel;
use Tests\TestCase;

class SettingsCrudTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test public fetch settings.
     */
    public function test_anyone_can_fetch_settings()
    {
        $response = $this->getJson('/api/settings');

        $response->assertStatus(200)
            ->assertJsonPath('data.website_logo', '/images/logo.png');
    }

    /**
     * Test admin can update settings and upload logo.
     */
    public function test_admin_can_update_settings_and_upload_logo()
    {
        $admin = User::factory()->create(['role' => 'Administrator']);
        
        // Prepare dummy logo upload file
        Storage::fake('public');
        $file = UploadedFile::fake()->image('logo.png');

        $response = $this->actingAs($admin, 'sanctum')
            ->postJson('/api/settings', [
                'facebook_page_id' => '1234567890',
                'facebook_access_token' => 'abcde12345',
                'website_logo_file' => $file,
            ]);

        $response->assertStatus(200)
            ->assertJsonPath('data.facebook_page_id', '1234567890')
            ->assertJsonPath('data.facebook_access_token', 'abcde12345');

        $this->assertDatabaseHas('settings', [
            'facebook_page_id' => '1234567890',
        ]);
    }
}
