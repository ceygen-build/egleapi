<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Faq\Models\FaqItem;
use Tests\TestCase;

class FaqCrudTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test public list FAQs.
     */
    public function test_anyone_can_list_faqs()
    {
        FaqItem::create([
            'question' => 'What is 4PL?',
            'answer' => 'Fourth-party logistics description here.',
        ]);

        $response = $this->getJson('/api/faqs');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.question', 'What is 4PL?');
    }

    /**
     * Test admin can create FAQ.
     */
    public function test_admin_can_create_faq()
    {
        $admin = User::factory()->create(['role' => 'Administrator']);

        $response = $this->actingAs($admin, 'sanctum')
            ->postJson('/api/faqs', [
                'question' => 'How to track shipment?',
                'answer' => 'Use telemetry panel tracking.',
            ]);

        $response->assertStatus(201)
            ->assertJsonPath('data.question', 'How to track shipment?');

        $this->assertDatabaseHas('faqs', [
            'question' => 'How to track shipment?',
            'answer' => 'Use telemetry panel tracking.',
        ]);
    }

    /**
     * Test admin can update FAQ.
     */
    public function test_admin_can_update_faq()
    {
        $admin = User::factory()->create(['role' => 'Administrator']);
        $faq = FaqItem::create([
            'question' => 'Old Question',
            'answer' => 'Old Answer',
        ]);

        $response = $this->actingAs($admin, 'sanctum')
            ->putJson("/api/faqs/{$faq->id}", [
                'question' => 'New Question',
                'answer' => 'New Answer',
            ]);

        $response->assertStatus(200)
            ->assertJsonPath('data.question', 'New Question')
            ->assertJsonPath('data.answer', 'New Answer');
    }

    /**
     * Test admin can delete FAQ.
     */
    public function test_admin_can_delete_faq()
    {
        $admin = User::factory()->create(['role' => 'Administrator']);
        $faq = FaqItem::create([
            'question' => 'To delete',
            'answer' => 'Will be deleted',
        ]);

        $response = $this->actingAs($admin, 'sanctum')
            ->deleteJson("/api/faqs/{$faq->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('faqs', ['id' => $faq->id]);
    }
}
