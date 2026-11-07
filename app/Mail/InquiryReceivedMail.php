<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Modules\Inquiry\Models\InquiryModel;

class InquiryReceivedMail extends Mailable
{
    use Queueable, SerializesModels;

    public InquiryModel $inquiry;

    /**
     * Create a new message instance.
     */
    public function __construct(InquiryModel $inquiry)
    {
        $this->inquiry = $inquiry;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Website Inquiry: ' . $this->inquiry->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $formattedMessage = nl2br(e($this->inquiry->message));

        return new Content(
            htmlString: "
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset='utf-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>New Inquiry Notification</title>
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
                    .section-title {
                        font-size: 16px;
                        font-weight: 700;
                        color: #0f172a;
                        margin-bottom: 20px;
                        border-bottom: 2px solid #f1f5f9;
                        padding-bottom: 10px;
                    }
                    .detail-row {
                        margin-bottom: 12px;
                        font-size: 13px;
                    }
                    .detail-label {
                        font-weight: 800;
                        color: #64748b;
                        display: inline-block;
                        width: 120px;
                    }
                    .detail-value {
                        color: #1e293b;
                        font-weight: 600;
                    }
                    .message-box {
                        margin-top: 24px;
                        padding: 24px;
                        background-color: #f8fafc;
                        border-left: 4px solid #0057d9;
                        border-radius: 8px;
                    }
                    .message-title {
                        font-size: 11px;
                        font-weight: 800;
                        text-transform: uppercase;
                        color: #64748b;
                        margin-bottom: 8px;
                        letter-spacing: 0.5px;
                    }
                    .message-text {
                        font-size: 13px;
                        line-height: 1.6;
                        color: #334155;
                        font-weight: 500;
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
                </style>
            </head>
            <body>
                <div class='email-container'>
                    <div class='email-header'>
                        <h1>Eagle Logistic</h1>
                    </div>
                    <div class='email-body'>
                        <div class='section-title'>New Customer Inquiry Received</div>
                        
                        <div class='detail-row'>
                            <span class='detail-label'>Sender Name:</span>
                            <span class='detail-value'>{$this->inquiry->name}</span>
                        </div>
                        <div class='detail-row'>
                            <span class='detail-label'>Email Address:</span>
                            <span class='detail-value'>{$this->inquiry->email}</span>
                        </div>
                        <div class='detail-row'>
                            <span class='detail-label'>Phone Number:</span>
                            <span class='detail-value'>{$this->inquiry->phone}</span>
                        </div>
                        <div class='detail-row'>
                            <span class='detail-label'>Submitted Date:</span>
                            <span class='detail-value'>{$this->inquiry->date}</span>
                        </div>
                        
                        <div class='message-box'>
                            <div class='message-title'>Subject: {$this->inquiry->subject}</div>
                            <div class='message-text'>{$formattedMessage}</div>
                        </div>
                    </div>
                    <div class='email-footer'>
                        <p>This is an automated system notification regarding a website contact form submission.</p>
                        <p>&copy; " . date('Y') . " Eagle Logistic Portal.</p>
                    </div>
                </div>
            </body>
            </html>
            ",
        );
    }
}
