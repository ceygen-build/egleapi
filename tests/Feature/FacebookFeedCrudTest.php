<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\FacebookFeed\Models\FacebookFeedItem;
use Tests\TestCase;

class FacebookFeedCrudTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test public fetch approved feed.
     */
    public function test_anyone_can_fetch_approved_facebook_feed()
    {
        FacebookFeedItem::create([
            'id' => 'fb_1',
            'caption' => 'Test Caption Approved',
            'fb_image_url' => 'https://img.com/1.jpg',
            'status' => 'approved',
            'posted_at' => '2026-08-07 10:00',
        ]);

        FacebookFeedItem::create([
            'id' => 'fb_2',
            'caption' => 'Test Caption Pending',
            'fb_image_url' => 'https://img.com/2.jpg',
            'status' => 'pending',
            'posted_at' => '2026-08-07 10:00',
        ]);

        $response = $this->getJson('/api/facebook-feed/approved');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.id', 'fb_1');
    }

    /**
     * Test admin can fetch all facebook feed items.
     */
    public function test_admin_can_fetch_all_facebook_feed_items()
    {
        $admin = User::factory()->create(['role' => 'Administrator']);
        FacebookFeedItem::create([
            'id' => 'fb_1',
            'caption' => 'Test Caption Approved',
            'fb_image_url' => 'https://img.com/1.jpg',
            'status' => 'approved',
            'posted_at' => '2026-08-07 10:00',
        ]);

        $response = $this->actingAs($admin, 'sanctum')
            ->getJson('/api/facebook-feed');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data');
    }

    /**
     * Test admin can update facebook feed status.
     */
    public function test_admin_can_update_facebook_feed_status()
    {
        $admin = User::factory()->create(['role' => 'Administrator']);
        $item = FacebookFeedItem::create([
            'id' => 'fb_1',
            'caption' => 'Test Caption Pending',
            'fb_image_url' => 'https://img.com/1.jpg',
            'status' => 'pending',
            'posted_at' => '2026-08-07 10:00',
        ]);

        $response = $this->actingAs($admin, 'sanctum')
            ->putJson("/api/facebook-feed/{$item->id}", [
                'status' => 'approved',
            ]);

        $response->assertStatus(200)
            ->assertJsonPath('data.status', 'approved');

        $this->assertDatabaseHas('facebook_feed_items', [
            'id' => 'fb_1',
            'status' => 'approved',
        ]);
    }

    /**
     * Test admin can trigger sync.
     */
    public function test_admin_can_trigger_sync()
    {
        $admin = User::factory()->create(['role' => 'Administrator']);

        $response = $this->actingAs($admin, 'sanctum')
            ->postJson('/api/facebook-feed/sync');

        $response->assertStatus(200);
        $this->assertDatabaseHas('facebook_feed_items', [
            'id' => 'fb_photo_101',
        ]);
    }
}
