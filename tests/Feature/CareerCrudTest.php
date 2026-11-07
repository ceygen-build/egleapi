<?php

namespace Tests\Feature;

use App\Mail\JobAppliedMail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Modules\Career\Models\Vacancy;
use Modules\Career\Models\JobApplication;
use Tests\TestCase;

class CareerCrudTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test public list vacancies.
     */
    public function test_anyone_can_list_vacancies()
    {
        Vacancy::create([
            'id' => 'senior-broker',
            'title' => 'Senior Broker',
            'department' => 'Operations',
            'location' => 'Colombo HQ',
            'type' => 'Full-time',
            'experience' => '5+ Years',
            'description' => 'Test description',
        ]);

        $response = $this->getJson('/api/vacancies');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.id', 'senior-broker');
    }

    /**
     * Test admin can create vacancy.
     */
    public function test_admin_can_create_vacancy()
    {
        $admin = User::factory()->create(['role' => 'Administrator']);

        $response = $this->actingAs($admin, 'sanctum')
            ->postJson('/api/vacancies', [
                'id' => 'sales-manager',
                'title' => 'Sales Manager',
                'department' => 'Sales',
                'location' => 'Colombo',
                'type' => 'Full-time',
                'experience' => '3+ Years',
                'description' => 'Sales description here.',
            ]);

        $response->assertStatus(201)
            ->assertJsonPath('data.id', 'sales-manager');

        $this->assertDatabaseHas('vacancies', [
            'id' => 'sales-manager',
            'title' => 'Sales Manager',
        ]);
    }

    /**
     * Test guest can submit job application and receive confirmation email.
     */
    public function test_guest_can_apply_job_sends_email()
    {
        Mail::fake();

        $vacancy = Vacancy::create([
            'id' => 'broker-123',
            'title' => 'Senior Broker',
            'department' => 'Operations',
            'location' => 'Colombo HQ',
            'type' => 'Full-time',
            'experience' => '5+ Years',
            'description' => 'Test description',
        ]);

        $response = $this->postJson('/api/job-applications', [
            'vacancy_id' => 'broker-123',
            'job_title' => 'Senior Broker',
            'candidate_name' => 'Jane Smith',
            'candidate_email' => 'jane@example.com',
            'candidate_phone' => '+94770001122',
            'cover_letter' => 'I love logistics.',
            'cv_url' => '/uploads/cv.pdf',
            'applied_date' => '2026-08-07 15:00',
        ]);

        $response->assertStatus(201)
            ->assertJsonPath('data.candidate_name', 'Jane Smith');

        $this->assertDatabaseHas('job_applications', [
            'candidate_email' => 'jane@example.com',
            'vacancy_id' => 'broker-123',
        ]);

        Mail::assertSent(JobAppliedMail::class, function ($mail) {
            return $mail->hasTo('jane@example.com') &&
                   $mail->application->candidate_name === 'Jane Smith';
        });
    }

    /**
     * Test admin can view applications list.
     */
    public function test_admin_can_view_applications()
    {
        $admin = User::factory()->create(['role' => 'Administrator']);
        
        $vacancy = Vacancy::create([
            'id' => 'broker-1',
            'title' => 'Senior Broker',
            'department' => 'Operations',
            'location' => 'Colombo HQ',
            'type' => 'Full-time',
            'experience' => '5+ Years',
            'description' => 'Test description',
        ]);

        JobApplication::create([
            'vacancy_id' => 'broker-1',
            'job_title' => 'Senior Broker',
            'candidate_name' => 'John Doe',
            'candidate_email' => 'john@example.com',
            'candidate_phone' => '12345678',
            'cover_letter' => 'Test cover letter',
            'cv_url' => 'cv.pdf',
            'applied_date' => '2026-08-07 10:00',
        ]);

        $response = $this->actingAs($admin, 'sanctum')
            ->getJson('/api/job-applications');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.candidate_name', 'John Doe');
    }
}
