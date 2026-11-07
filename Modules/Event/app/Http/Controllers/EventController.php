<?php

namespace Modules\Event\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\EventRegisteredMail;
use App\Traits\ApiResponse;
use App\Support\FileUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Modules\Event\Models\EventItem;
use Modules\Event\Models\EventRegistration;

class EventController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the events.
     */
    public function index(): JsonResponse
    {
        $events = EventItem::orderBy('created_at', 'desc')->get();
        return $this->successResponse($events);
    }

    /**
     * Store a newly created event in database.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'id' => ['required', 'string', 'unique:events,id'],
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'date' => ['required', 'string', 'max:255'],
            'time' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'image' => ['required', 'string'],
            'description' => ['required', 'string'],
            'speakers' => ['nullable', 'array'],
            'status' => ['required', 'string', 'max:255'],
        ]);

        $event = EventItem::create($validated);

        return $this->successResponse($event, 'Event created successfully.', 201);
    }

    /**
     * Update the specified event in database.
     */
    public function update(Request $request, $id): JsonResponse
    {
        $event = EventItem::findOrFail($id);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'date' => ['required', 'string', 'max:255'],
            'time' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'image' => ['required', 'string'],
            'description' => ['required', 'string'],
            'speakers' => ['nullable', 'array'],
            'status' => ['required', 'string', 'max:255'],
        ]);

        $oldImage = $event->image;

        $event->update($validated);

        if ($oldImage && array_key_exists('image', $validated) && $oldImage !== $validated['image']) {
            FileUploadService::deleteUploadFile($oldImage);
        }

        return $this->successResponse($event, 'Event updated successfully.');
    }

    /**
     * Remove the specified event from database.
     */
    public function destroy($id): JsonResponse
    {
        $event = EventItem::findOrFail($id);
        FileUploadService::deleteUploadFile($event->image);
        $event->delete();

        return $this->successResponse(null, 'Event deleted successfully.');
    }

    /**
     * Display a listing of all event registrations (Admin only).
     */
    public function indexRegistrations(): JsonResponse
    {
        $registrations = EventRegistration::orderBy('created_at', 'desc')->get();
        return $this->successResponse($registrations);
    }

    /**
     * Store a new event registration (Public, sends confirmation email).
     */
    public function storeRegistration(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'event_id' => ['required', 'string', 'exists:events,id'],
            'event_name' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'registered_date' => ['required', 'string', 'max:255'],
        ]);

        $registration = EventRegistration::create($validated);

        try {
            
            Mail::to($registration->email)->send(new EventRegisteredMail($registration));
           
        } catch (\Exception $e) {
            // Log error or let it continue if mail driver is not configured, but do not crash the registration response
            logger()->error('Failed to send event registration email: ' . $e->getMessage());
        }

        return $this->successResponse($registration, 'Successfully registered for the event.', 201);
    }
}
