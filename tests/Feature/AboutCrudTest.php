<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\About\Models\AboutData;
use Tests\TestCase;

class AboutCrudTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test public list about data.
     */
    public function test_anyone_can_view_about_data()
    {
        AboutData::create([
            'hero_title' => 'Initial Title',
            'company_title' => 'Initial Company',
            'company_desc1' => 'Initial Description',
        ]);

        $response = $this->getJson('/api/about');

        $response->assertStatus(200)
            ->assertJsonPath('data.hero_title', 'Initial Title');
    }

    /**
     * Test admin can update about data.
     */
    public function test_admin_can_update_about_data()
    {
        $admin = User::factory()->create(['role' => 'Administrator']);

        AboutData::create([
            'hero_title' => 'Old Title',
            'company_title' => 'Old Company',
            'company_desc1' => 'Old Description',
        ]);

        $response = $this->actingAs($admin, 'sanctum')
            ->putJson('/api/about', [
                'hero_title' => 'New Title',
                'hero_subtitle' => 'New Subtitle',
                'company_title' => 'New Company Title',
                'company_desc1' => 'New company description paragraph 1.',
            ]);

        $response->assertStatus(200)
            ->assertJsonPath('data.hero_title', 'New Title')
            ->assertJsonPath('data.hero_subtitle', 'New Subtitle');

        $this->assertDatabaseHas('about_data', [
            'hero_title' => 'New Title',
            'company_title' => 'New Company Title',
        ]);
    }
}
