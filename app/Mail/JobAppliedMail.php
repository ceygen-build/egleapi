<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Modules\Career\Models\JobApplication;

class JobAppliedMail extends Mailable
{
    use Queueable, SerializesModels;

    public JobApplication $application;

    /**
     * Create a new message instance.
     */
    public function __construct(JobApplication $application)
    {
        $this->application = $application;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Application Received: ' . $this->application->job_title,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $frontendUrl = config('app.frontend_url', 'https://eaglelogistic.com');
        $displayUrl = preg_replace('/^https?:\/\/(www\.)?/', '', $frontendUrl);

        return new Content(
            htmlString: "
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset='utf-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Application Received</title>
                <style>
                    body {
                        margin: 0;
                        padding: 0;
                        background-color: #f4f6f9;
                        font-family: 'Segoe UI', Helvetica, Arial, sans-serif;
                        color: #334155;
                    }
                    .email-container {
                        max-width: 600px;
                        margin: 40px auto;
                        background-color: #ffffff;
                        border-radius: 16px;
                        overflow: hidden;
                        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
                        border: 1px solid #e2e8f0;
                    }
                    .email-header {
                        background-color: #0057d9;
                        padding: 32px;
                        text-align: center;
                    }
                    .email-header h1 {
                        color: #ffffff;
                        margin: 0;
                        font-size: 20px;
                        font-weight: 800;
                        letter-spacing: 0.5px;
                        text-transform: uppercase;
                    }
                    .email-body {
                        padding: 40px 32px;
                    }
                    .greeting {
                        font-size: 16px;
                        font-weight: 700;
                        color: #0f172a;
                        margin-bottom: 20px;
                    }
                    .message-content {
                        font-size: 14px;
                        line-height: 1.6;
                        color: #334155;
                        margin-bottom: 24px;
                    }
                    .detail-row {
                        margin-bottom: 12px;
                        font-size: 13px;
                    }
                    .detail-label {
                        font-weight: 800;
                        color: #64748b;
                        display: inline-block;
                        width: 150px;
                    }
                    .detail-value {
                        color: #1e293b;
                        font-weight: 600;
                    }
                    .email-footer {
                        background-color: #f8fafc;
                        padding: 24px 32px;
                        text-align: center;
                        border-top: 1px solid #e2e8f0;
                        font-size: 12px;
                        color: #64748b;
                    }
                    .email-footer p {
                        margin: 4px 0;
                    }
                    .email-footer a {
                        color: #0057d9;
                        text-decoration: none;
                        font-weight: 600;
                    }
                </style>
            </head>
            <body>
                <div class='email-container'>
                    <div class='email-header'>
                        <h1>Eagle Logistic</h1>
                    </div>
                    <div class='email-body'>
                        <div class='greeting'>Dear {$this->application->candidate_name},</div>
                        <div class='message-content'>
                            Thank you for your interest in joining Eagle Logistic. We have successfully received your job application and CV for the position of <strong>{$this->application->job_title}</strong>.
                            Our HR team will review your qualifications, and we will get back to you shortly if your profile matches our requirements.
                        </div>
                        
                        <div style='border-top: 2px solid #f1f5f9; padding-top: 20px;'>
                            <div class='detail-row'>
                                <span class='detail-label'>Position Applied:</span>
                                <span class='detail-value'>{$this->application->job_title}</span>
                            </div>
                            <div class='detail-row'>
                                <span class='detail-label'>Candidate Name:</span>
                                <span class='detail-value'>{$this->application->candidate_name}</span>
                            </div>
                            <div class='detail-row'>
                                <span class='detail-label'>Email Address:</span>
                                <span class='detail-value'>{$this->application->candidate_email}</span>
                            </div>
                            <div class='detail-row'>
                                <span class='detail-label'>Contact Phone:</span>
                                <span class='detail-value'>{$this->application->candidate_phone}</span>
                            </div>
                            <div class='detail-row'>
                                <span class='detail-label'>Applied Date:</span>
                                <span class='detail-value'>{$this->application->applied_date}</span>
                            </div>
                        </div>
                    </div>
                    <div class='email-footer'>
                        <p>&copy; " . date('Y') . " Eagle Logistic. All rights reserved.</p>
                        <p>Human Resources Department | <a href='{$frontendUrl}'>{$displayUrl}</a></p>
                    </div>
                </div>
            </body>
            </html>
            ",
        );
    }
}
