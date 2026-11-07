<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Testimonial;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Modules\Event\Models\EventRegistration;
use Modules\Career\Models\JobApplication;
use Modules\Inquiry\Models\InquiryModel;
use Modules\FacebookFeed\Models\FacebookFeedItem;

class AdminDataController extends Controller
{
    use ApiResponse;

    /**
     * Consolidate all admin-specific lists.
     */
    public function index(): JsonResponse
    {
        $users = User::orderBy('id', 'desc')->get();
        $testimonials = Testimonial::orderBy('id', 'desc')->get();
        $eventRegistrations = EventRegistration::orderBy('id', 'desc')->get();
        $jobApplications = JobApplication::orderBy('id', 'desc')->get();
        $inquiries = InquiryModel::orderBy('id', 'desc')->get();
        $facebookFeed = FacebookFeedItem::orderBy('posted_at', 'desc')->get();

        return $this->successResponse([
            'users' => $users,
            'testimonials' => $testimonials,
            'event_registrations' => $eventRegistrations,
            'job_applications' => $jobApplications,
            'inquiries' => $inquiries,
            'facebook_feed' => $facebookFeed,
        ]);
    }
}
