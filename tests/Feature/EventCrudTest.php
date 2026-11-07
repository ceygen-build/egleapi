<?php

namespace Tests\Feature;

use App\Mail\EventRegisteredMail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Modules\Event\Models\EventItem;
use Modules\Event\Models\EventRegistration;
use Tests\TestCase;

class EventCrudTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test public list events.
     */
    public function test_anyone_can_list_events()
    {
        EventItem::create([
            'id' => 'test-event-1',
            'title' => 'Test Event 1',
            'category' => 'Webinar',
            'date' => 'August 24, 2026',
            'time' => '10:00 AM',
            'location' => 'Colombo',
            'city' => 'Colombo',
            'image' => 'test.jpg',
            'description' => 'Test desc',
            'status' => 'Registration Open',
        ]);

        $response = $this->getJson('/api/events');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.id', 'test-event-1');
    }

    /**
     * Test admin can create event.
     */
    public function test_admin_can_create_event()
    {
        $admin = User::factory()->create(['role' => 'Administrator']);

        $response = $this->actingAs($admin, 'sanctum')
            ->postJson('/api/events', [
                'id' => 'new-event-post',
                'title' => 'New Event Title',
                'category' => 'Conference',
                'date' => 'September 1, 2026',
                'time' => '09:00 AM - 05:00 PM',
                'location' => 'Main Hall',
                'city' => 'Galle',
                'image' => 'event.jpg',
                'description' => 'Detailed description here.',
                'speakers' => ['Speaker 1', 'Speaker 2'],
                'status' => 'Registration Open',
            ]);

        $response->assertStatus(201)
            ->assertJsonPath('data.id', 'new-event-post');

        $this->assertDatabaseHas('events', [
            'id' => 'new-event-post',
            'title' => 'New Event Title',
        ]);
    }

    /**
     * Test guest can register for event and receive confirmation email.
     */
    public function test_guest_can_register_for_event_sends_email()
    {
        Mail::fake();

        $event = EventItem::create([
            'id' => 'event-123',
            'title' => 'Test Event Title',
            'category' => 'Webinar',
            'date' => 'August 24, 2026',
            'time' => '10:00 AM',
            'location' => 'Colombo',
            'city' => 'Colombo',
            'image' => 'test.jpg',
            'description' => 'Test desc',
            'status' => 'Registration Open',
        ]);

        $response = $this->postJson('/api/event-registrations', [
            'event_id' => 'event-123',
            'event_name' => 'Test Event Title',
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'company' => 'Example Inc.',
            'registered_date' => '2026-08-07 14:00',
        ]);

        $response->assertStatus(201)
            ->assertJsonPath('data.name', 'John Doe');

        $this->assertDatabaseHas('event_registrations', [
            'email' => 'john@example.com',
            'event_id' => 'event-123',
        ]);

        Mail::assertSent(EventRegisteredMail::class, function ($mail) {
            return $mail->hasTo('john@example.com') &&
                   $mail->registration->name === 'John Doe';
        });
    }

    /**
     * Test admin can view registrations list.
     */
    public function test_admin_can_view_registrations()
    {
        $admin = User::factory()->create(['role' => 'Administrator']);
        
        $event = EventItem::create([
            'id' => 'event-1',
            'title' => 'Test Event',
            'category' => 'Webinar',
            'date' => 'August 24, 2026',
            'time' => '10:00 AM',
            'location' => 'Colombo',
            'city' => 'Colombo',
            'image' => 'test.jpg',
            'description' => 'Test desc',
            'status' => 'Registration Open',
        ]);

        EventRegistration::create([
            'event_id' => 'event-1',
            'event_name' => 'Test Event',
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'company' => 'Google',
            'registered_date' => '2026-08-07 12:00',
        ]);

        $response = $this->actingAs($admin, 'sanctum')
            ->getJson('/api/event-registrations');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.name', 'Jane Doe');
    }
}
