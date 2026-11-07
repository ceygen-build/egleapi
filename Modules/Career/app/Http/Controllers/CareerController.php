<?php

namespace Modules\Career\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\JobAppliedMail;
use App\Traits\ApiResponse;
use App\Support\FileUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Modules\Career\Models\Vacancy;
use Modules\Career\Models\JobApplication;
use Modules\Career\Models\CareerOption;
use Modules\Career\Models\CareerPage;

class CareerController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of managed career category options (Departments, Locations, Job Types).
     */
    public function indexOptions(): JsonResponse
    {
        $options = CareerOption::orderBy('type')->orderBy('name')->get();
        return $this->successResponse($options);
    }

    /**
     * Store a newly created category option in database.
     */
    public function storeOption(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'type' => ['required', 'string', 'in:department,location,job_type'],
            'name' => ['required', 'string', 'max:255'],
        ]);

        $option = CareerOption::create($validated);
        return $this->successResponse($option, 'Career category option created successfully.', 201);
    }

    /**
     * Update an existing category option in database.
     */
    public function updateOption(Request $request, $id): JsonResponse
    {
        $option = CareerOption::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $option->update($validated);
        return $this->successResponse($option, 'Career category option updated successfully.');
    }

    /**
     * Delete a category option from database.
     */
    public function destroyOption($id): JsonResponse
    {
        $option = CareerOption::findOrFail($id);
        $option->delete();
        return $this->successResponse(null, 'Career category option deleted successfully.');
    }

    /**
     * Display a listing of the job vacancies with filters and pagination.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Vacancy::query();

        // Search text filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Department filter
        if ($request->filled('department')) {
            $query->where('department', $request->input('department'));
        }

        // Location filter
        if ($request->filled('location')) {
            $query->where('location', 'like', "%" . $request->input('location') . "%");
        }

        // Job type filter
        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        $query->orderBy('created_at', 'desc');

        // Check if pagination is requested (if page or per_page is passed)
        if ($request->has('page') || $request->filled('per_page') || $request->has('paginate')) {
            $perPage = (int) $request->input('per_page', 5);
            $paginated = $query->paginate($perPage);
            return $this->successResponse($paginated);
        }

        $vacancies = $query->get();
        return $this->successResponse($vacancies);
    }

    /**
     * Store a newly created vacancy in database.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'id' => ['required', 'string', 'unique:vacancies,id'],
            'title' => ['required', 'string', 'max:255'],
            'department' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:255'],
            'experience' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ]);

        $vacancy = Vacancy::create($validated);

        return $this->successResponse($vacancy, 'Job vacancy created successfully.', 201);
    }

    /**
     * Update the specified vacancy in database.
     */
    public function update(Request $request, $id): JsonResponse
    {
        $vacancy = Vacancy::findOrFail($id);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'department' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:255'],
            'experience' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ]);

        $vacancy->update($validated);

        return $this->successResponse($vacancy, 'Job vacancy updated successfully.');
    }

    /**
     * Remove the specified vacancy from database.
     */
    public function destroy($id): JsonResponse
    {
        $vacancy = Vacancy::findOrFail($id);
        $vacancy->delete();

        return $this->successResponse(null, 'Job vacancy deleted successfully.');
    }

    /**
     * Display a listing of all job applications (Admin only).
     */
    public function indexApplications(): JsonResponse
    {
        $applications = JobApplication::orderBy('created_at', 'desc')->get();
        return $this->successResponse($applications);
    }

    /**
     * Store a new job application / CV submission (Public, sends confirmation email).
     */
    public function storeApplication(Request $request): JsonResponse
    {
        // Direct resume file upload support with strict PDF validation
        if ($request->hasFile('resume')) {
            $request->validate([
                'resume' => [
                    'required',
                    'file',
                    'mimes:pdf',
                    'mimetypes:application/pdf,application/x-pdf',
                    'max:10240', // 10MB
                ],
            ], [
                'resume.mimes' => 'Only PDF files (.pdf) are allowed for resumes.',
                'resume.mimetypes' => 'Only valid PDF documents (.pdf) are accepted.',
                'resume.max' => 'The resume file size must not exceed 10MB.',
            ]);

            $file = $request->file('resume');
            $fileName = 'cv_' . time() . '_' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $targetDir = public_path('uploads/resumes');
            if (!file_exists($targetDir)) {
                @mkdir($targetDir, 0755, true);
            }
            $file->move($targetDir, $fileName);
            $request->merge(['cv_url' => asset('uploads/resumes/' . $fileName)]);
        }

        $validated = $request->validate([
            'vacancy_id' => ['nullable', 'string'],
            'job_title' => ['required', 'string', 'max:255'],
            'candidate_name' => ['required', 'string', 'max:255'],
            'candidate_email' => ['required', 'email', 'max:255'],
            'candidate_phone' => ['required', 'string', 'max:255'],
            'cover_letter' => ['nullable', 'string'],
            'cv_url' => [
                'required',
                'string',
                'regex:/\.pdf(\?.*)?$/i',
            ],
            'applied_date' => ['nullable', 'string', 'max:255'],
        ], [
            'cv_url.required' => 'Please upload your CV / Resume in PDF format.',
            'cv_url.regex' => 'The uploaded resume must be a valid PDF document (.pdf).',
            'candidate_name.required' => 'Please provide your full name.',
            'candidate_email.required' => 'Please provide your email address.',
            'candidate_email.email' => 'Please enter a valid email address.',
            'candidate_phone.required' => 'Please provide your contact phone number.',
        ]);

        if (empty($validated['applied_date'])) {
            $validated['applied_date'] = date('Y-m-d');
        }

        // Ensure vacancy_id exists or map to fallback/general vacancy to preserve foreign key integrity
        $targetVacancyId = $validated['vacancy_id'] ?? null;
        if (!$targetVacancyId || !Vacancy::where('id', $targetVacancyId)->exists()) {
            $existingGeneral = Vacancy::where('id', 'general-application')->first();
            if (!$existingGeneral) {
                $firstVac = Vacancy::first();
                if ($firstVac) {
                    $targetVacancyId = $firstVac->id;
                } else {
                    $newGeneral = Vacancy::create([
                        'id' => 'general-application',
                        'title' => 'General Application',
                        'department' => 'General',
                        'location' => 'Colombo, Sri Lanka',
                        'type' => 'Full-time',
                        'experience' => 'Any',
                        'description' => 'General unsolicited job application pool.',
                    ]);
                    $targetVacancyId = $newGeneral->id;
                }
            } else {
                $targetVacancyId = 'general-application';
            }
        }
        $validated['vacancy_id'] = $targetVacancyId;

        $application = JobApplication::create($validated);

        try {
            Mail::to($application->candidate_email)->send(new JobAppliedMail($application));
        } catch (\Exception $e) {
            logger()->error('Failed to send job application confirmation email: ' . $e->getMessage());
        }

        return $this->successResponse($application, 'Job application submitted successfully.', 201);
    }

    /**
     * Remove the specified job application and its uploaded CV from database and disk.
     */
    public function destroyApplication($id): JsonResponse
    {
        $application = JobApplication::findOrFail($id);

        if ($application->cv_url) {
            FileUploadService::deleteUploadFile($application->cv_url);
        }

        $application->delete();

        return $this->successResponse(null, 'Job application deleted successfully.');
    }

    /**
     * Retrieve the Career page settings.
     */
    public function showPage(): JsonResponse
    {
        $page = CareerPage::first();
        if (!$page) {
            $page = CareerPage::create([
                'hero_tag' => 'Join Our Team',
                'hero_title' => "Build Your Career\nWith Eagle Logistic",
                'hero_subtitle' => "Be part of a team that moves Sri Lanka's trade forward.",
                'why_join_label' => 'Why Eagle Logistic',
                'why_join_title' => 'A Place Where Careers Take Flight',
            ]);
        }
        return $this->successResponse($page);
    }

    /**
     * Update the Career page settings.
     */
    public function updatePage(Request $request): JsonResponse
    {
        $page = CareerPage::first();
        if (!$page) {
            $page = new CareerPage();
        }

        $validated = $request->validate([
            'hero_tag' => ['nullable', 'string', 'max:255'],
            'hero_title' => ['nullable', 'string'],
            'hero_subtitle' => ['nullable', 'string'],
            'hero_image' => ['nullable', 'string'],
            'why_join_label' => ['nullable', 'string', 'max:255'],
            'why_join_title' => ['nullable', 'string', 'max:255'],
            'why_join_subtitle' => ['nullable', 'string'],
            'perks' => ['nullable'],
            'internship' => ['nullable'],
            'application_heading' => ['nullable', 'string', 'max:255'],
            'application_subheading' => ['nullable', 'string'],
        ]);

        $oldHeroImage = $page->hero_image;

        $page->fill($validated);
        $page->save();

        if ($oldHeroImage && array_key_exists('hero_image', $validated) && $oldHeroImage !== $validated['hero_image']) {
            FileUploadService::deleteUploadFile($oldHeroImage);
        }

        return $this->successResponse($page, 'Career page settings updated successfully.');
    }
}
