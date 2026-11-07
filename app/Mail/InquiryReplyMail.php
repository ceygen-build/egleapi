<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Modules\Inquiry\Models\InquiryModel;

class InquiryReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public InquiryModel $inquiry;
    public string $replyMessage;

    /**
     * Create a new message instance.
     */
    public function __construct(InquiryModel $inquiry, string $replyMessage)
    {
        $this->inquiry = $inquiry;
        $this->replyMessage = $replyMessage;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Re: ' . $this->inquiry->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $logoUrl = asset('images/logo.png'); // Fallback if logo not configured
        $formattedReply = nl2br(e($this->replyMessage));
        $formattedOriginal = nl2br(e($this->inquiry->message));

        $frontendUrl = config('app.frontend_url', 'https://eaglelogistic.com');
        $displayUrl = preg_replace('/^https?:\/\/(www\.)?/', '', $frontendUrl);

        return new Content(
            htmlString: "
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset='utf-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Inquiry Response</title>
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
                    }
                    .original-inquiry-box {
                        margin-top: 32px;
                        padding: 24px;
                        background-color: #f8fafc;
                        border-left: 4px solid #cbd5e1;
                        border-radius: 8px;
                    }
                    .original-title {
                        font-size: 11px;
                        font-weight: 800;
                        text-transform: uppercase;
                        color: #64748b;
                        margin-bottom: 8px;
                        letter-spacing: 0.5px;
                    }
                    .original-text {
                        font-size: 13px;
                        line-height: 1.5;
                        color: #475569;
                        font-style: italic;
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
                        <div class='greeting'>Dear {$this->inquiry->name},</div>
                        <div class='message-content'>
                            {$formattedReply}
                        </div>
                        
                        <div class='original-inquiry-box'>
                            <div class='original-title'>Your Original Inquiry (Subject: {$this->inquiry->subject})</div>
                            <div class='original-text'>\"{$formattedOriginal}\"</div>
                        </div>
                    </div>
                    <div class='email-footer'>
                        <p>&copy; " . date('Y') . " Eagle Logistic. All rights reserved.</p>
                        <p>If you have any further questions, visit our website at <a href='{$frontendUrl}'>{$displayUrl}</a>.</p>
                    </div>
                </div>
            </body>
            </html>
            ",
        );
    }
}
