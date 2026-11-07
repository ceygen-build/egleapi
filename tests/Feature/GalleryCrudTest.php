<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Gallery\Models\GalleryItem;
use Tests\TestCase;

class GalleryCrudTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test public list gallery.
     */
    public function test_anyone_can_list_gallery()
    {
        GalleryItem::create([
            'title' => 'Test Album',
            'subtitle' => 'Test Subtitle',
            'images' => [
                ['id' => '1', 'imageTitle' => 'Image 1', 'imageUrl' => 'img1.jpg']
            ],
        ]);

        $response = $this->getJson('/api/gallery');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.title', 'Test Album');
    }

    /**
     * Test admin can create gallery album.
     */
    public function test_admin_can_create_gallery_album()
    {
        $admin = User::factory()->create(['role' => 'Administrator']);

        $response = $this->actingAs($admin, 'sanctum')
            ->postJson('/api/gallery', [
                'title' => 'New Album',
                'subtitle' => 'New Subtitle',
                'images' => [
                    ['id' => 'img-1', 'imageTitle' => 'Cargo flight', 'imageUrl' => 'plane.jpg']
                ],
            ]);

        $response->assertStatus(201)
            ->assertJsonPath('data.title', 'New Album');

        $this->assertDatabaseHas('gallery_items', [
            'title' => 'New Album',
            'subtitle' => 'New Subtitle',
        ]);
    }

    /**
     * Test admin can update gallery album.
     */
    public function test_admin_can_update_gallery_album()
    {
        $admin = User::factory()->create(['role' => 'Administrator']);
        $album = GalleryItem::create([
            'title' => 'Old Title',
            'subtitle' => 'Old Subtitle',
            'images' => [
                ['id' => '1', 'imageTitle' => 'Old Image', 'imageUrl' => 'old.jpg']
            ],
        ]);

        $response = $this->actingAs($admin, 'sanctum')
            ->putJson("/api/gallery/{$album->id}", [
                'title' => 'Updated Title',
                'subtitle' => 'Updated Subtitle',
                'images' => [
                    ['id' => '1', 'imageTitle' => 'New Image', 'imageUrl' => 'new.jpg']
                ],
            ]);

        $response->assertStatus(200)
            ->assertJsonPath('data.title', 'Updated Title')
            ->assertJsonPath('data.images.0.imageTitle', 'New Image');
    }

    /**
     * Test admin can delete gallery album.
     */
    public function test_admin_can_delete_gallery_album()
    {
        $admin = User::factory()->create(['role' => 'Administrator']);
        $album = GalleryItem::create([
            'title' => 'To Delete',
            'subtitle' => 'To Delete Subtitle',
            'images' => [
                ['id' => '1', 'imageTitle' => 'To Delete', 'imageUrl' => 'del.jpg']
            ],
        ]);

        $response = $this->actingAs($admin, 'sanctum')
            ->deleteJson("/api/gallery/{$album->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('gallery_items', ['id' => $album->id]);
    }
}
