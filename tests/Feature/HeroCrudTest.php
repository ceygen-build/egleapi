<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Hero\Models\HeroSlide;
use Tests\TestCase;

class HeroCrudTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test public list slides.
     */
    public function test_anyone_can_list_slides()
    {
        HeroSlide::create([
            'is_active' => true,
            'target_page' => '/',
            'is_multiple' => false,
            'title' => 'Test Slide 1',
        ]);

        $response = $this->getJson('/api/slides');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.title', 'Test Slide 1');
    }

    /**
     * Test create slide.
     */
    public function test_admin_can_create_slide()
    {
        $admin = User::factory()->create(['role' => 'Administrator']);

        $response = $this->actingAs($admin, 'sanctum')
            ->postJson('/api/slides', [
                'is_active' => true,
                'target_page' => '/',
                'is_multiple' => false,
                'title' => 'New Slide',
                'category' => 'Air',
            ]);

        $response->assertStatus(201)
            ->assertJsonPath('data.title', 'New Slide');

        $this->assertDatabaseHas('hero_slides', [
            'title' => 'New Slide',
            'category' => 'Air',
        ]);
    }

    /**
     * Test update slide.
     */
    public function test_admin_can_update_slide()
    {
        $admin = User::factory()->create(['role' => 'Administrator']);
        $slide = HeroSlide::create([
            'is_active' => true,
            'target_page' => '/',
            'is_multiple' => false,
            'title' => 'Old Title',
        ]);

        $response = $this->actingAs($admin, 'sanctum')
            ->putJson("/api/slides/{$slide->id}", [
                'is_active' => false,
                'target_page' => '/about',
                'is_multiple' => true,
                'title' => 'Updated Title',
                'sub_slides' => [['title' => 'Sub 1']],
            ]);

        $response->assertStatus(200)
            ->assertJsonPath('data.title', 'Updated Title')
            ->assertJsonPath('data.is_active', false)
            ->assertJsonPath('data.sub_slides.0.title', 'Sub 1');
    }

    /**
     * Test delete slide.
     */
    public function test_admin_can_delete_slide()
    {
        $admin = User::factory()->create(['role' => 'Administrator']);
        $slide = HeroSlide::create([
            'is_active' => true,
            'target_page' => '/',
            'is_multiple' => false,
            'title' => 'To Delete',
        ]);

        $response = $this->actingAs($admin, 'sanctum')
            ->deleteJson("/api/slides/{$slide->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('hero_slides', ['id' => $slide->id]);
    }
}
