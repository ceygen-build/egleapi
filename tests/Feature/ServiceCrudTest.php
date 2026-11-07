<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Service\Models\ServiceItem;
use Tests\TestCase;

class ServiceCrudTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test public list services.
     */
    public function test_anyone_can_list_services()
    {
        ServiceItem::create([
            'slug' => 'test-service-1',
            'title' => 'Test Service 1',
            'description' => 'Test Description',
            'icon_name' => 'Ship',
            'category' => 'Freight',
        ]);

        $response = $this->getJson('/api/services');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.slug', 'test-service-1');
    }

    /**
     * Test create service.
     */
    public function test_admin_can_create_service()
    {
        $admin = User::factory()->create(['role' => 'Administrator']);

        $response = $this->actingAs($admin, 'sanctum')
            ->postJson('/api/services', [
                'slug' => 'air-freight',
                'title' => 'Air Freight Solutions',
                'description' => 'Fast air shipping solutions.',
                'icon_name' => 'Plane',
                'category' => 'Freight',
            ]);

        $response->assertStatus(201)
            ->assertJsonPath('data.slug', 'air-freight');

        $this->assertDatabaseHas('services', [
            'slug' => 'air-freight',
            'title' => 'Air Freight Solutions',
        ]);
    }

    /**
     * Test update service.
     */
    public function test_admin_can_update_service()
    {
        $admin = User::factory()->create(['role' => 'Administrator']);
        $service = ServiceItem::create([
            'slug' => 'old-slug',
            'title' => 'Old Title',
            'description' => 'Old description.',
            'icon_name' => 'Ship',
            'category' => 'Freight',
        ]);

        $response = $this->actingAs($admin, 'sanctum')
            ->putJson("/api/services/{$service->id}", [
                'slug' => 'new-slug',
                'title' => 'Updated Title',
                'description' => 'Updated description.',
                'icon_name' => 'Anchor',
                'category' => 'Marine',
                'key_benefits' => ['Fast', 'Reliable'],
            ]);

        $response->assertStatus(200)
            ->assertJsonPath('data.title', 'Updated Title')
            ->assertJsonPath('data.slug', 'new-slug')
            ->assertJsonPath('data.key_benefits.0', 'Fast');
    }

    /**
     * Test delete service.
     */
    public function test_admin_can_delete_service()
    {
        $admin = User::factory()->create(['role' => 'Administrator']);
        $service = ServiceItem::create([
            'slug' => 'to-delete',
            'title' => 'To Delete',
            'description' => 'To delete description.',
            'icon_name' => 'Ship',
            'category' => 'Freight',
        ]);

        $response = $this->actingAs($admin, 'sanctum')
            ->deleteJson("/api/services/{$service->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('services', ['id' => $service->id]);
    }

    /**
     * Test public list service features (auto-seeds if empty).
     */
    public function test_anyone_can_list_service_features()
    {
        $response = $this->getJson('/api/service-features');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    '*' => ['id', 'title', 'description', 'icon', 'featured', 'is_active'],
                ],
            ]);
    }

    /**
     * Test admin can create a service feature card.
     */
    public function test_admin_can_create_service_feature()
    {
        $admin = User::factory()->create(['role' => 'Administrator']);

        $response = $this->actingAs($admin, 'sanctum')
            ->postJson('/api/service-features', [
                'title' => 'Customs Clearance Specialist',
                'description' => 'Fast clearance for import and export.',
                'icon' => 'customs',
                'featured' => true,
                'sort_order' => 10,
                'link' => '/services',
                'is_active' => true,
            ]);

        $response->assertStatus(201)
            ->assertJsonPath('data.title', 'Customs Clearance Specialist')
            ->assertJsonPath('data.featured', true);

        $this->assertDatabaseHas('service_features', [
            'title' => 'Customs Clearance Specialist',
            'featured' => 1,
        ]);
    }

    /**
     * Test admin can update a service feature card.
     */
    public function test_admin_can_update_service_feature()
    {
        $admin = User::factory()->create(['role' => 'Administrator']);

        // First trigger listing to have seeded features
        $this->getJson('/api/service-features');

        $feature = \Modules\Service\Models\ServiceFeature::first();

        $response = $this->actingAs($admin, 'sanctum')
            ->putJson("/api/service-features/{$feature->id}", [
                'title' => 'Updated Feature Title',
                'description' => 'Updated Description text.',
                'icon' => 'plane',
                'featured' => false,
                'sort_order' => 1,
                'is_active' => true,
            ]);

        $response->assertStatus(200)
            ->assertJsonPath('data.title', 'Updated Feature Title')
            ->assertJsonPath('data.icon', 'plane')
            ->assertJsonPath('data.featured', false);

        $this->assertDatabaseHas('service_features', [
            'id' => $feature->id,
            'title' => 'Updated Feature Title',
        ]);
    }

    /**
     * Test admin can delete a service feature card.
     */
    public function test_admin_can_delete_service_feature()
    {
        $admin = User::factory()->create(['role' => 'Administrator']);

        $feature = \Modules\Service\Models\ServiceFeature::create([
            'title' => 'Feature To Delete',
            'description' => 'Short lived card.',
            'icon' => 'truck',
            'featured' => false,
            'sort_order' => 99,
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin, 'sanctum')
            ->deleteJson("/api/service-features/{$feature->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('service_features', ['id' => $feature->id]);
    }
}
