<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use App\Mail\InquiryReceivedMail;
use Modules\Contact\Models\ContactDetails;
use Tests\TestCase;

class ContactEmailsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test admin can save sales_email and careers_email in contact details.
     */
    public function test_admin_can_save_multiple_contact_emails()
    {
        $admin = User::factory()->create(['role' => 'Administrator']);

        $response = $this->actingAs($admin, 'sanctum')
            ->postJson('/api/contact-details', [
                'phone' => '+94 11 000 0000',
                'email' => 'general@interglob.com',
                'sales_email' => 'sales@interglob.com',
                'careers_email' => 'careers@interglob.com',
                'address' => 'Colombo 03',
                'map_iframe_url' => 'https://maps.google.com',
            ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('contact_details', [
            'email' => 'general@interglob.com',
            'sales_email' => 'sales@interglob.com',
            'careers_email' => 'careers@interglob.com',
        ]);
    }

    /**
     * Test inquiries submit dispatches mail to target_email.
     */
    public function test_inquiry_submission_sends_email_to_target_department()
    {
        Mail::fake();

        $response = $this->postJson('/api/inquiries', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '+94 77 123 4567',
            'subject' => 'Inquiry subject',
            'message' => 'Inquiry body',
            'date' => '2026-08-08 00:00',
            'target_email' => 'sales@interglob.com',
        ]);

        $response->assertStatus(201);

        Mail::assertSent(InquiryReceivedMail::class, function ($mail) {
            return $mail->hasTo('sales@interglob.com');
        });
    }
}
