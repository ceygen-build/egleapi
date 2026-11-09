<?php

namespace Modules\About\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use App\Support\FileUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\About\Models\AboutData;
use Modules\About\Models\AboutTimeline;

class AboutController extends Controller
{
    use ApiResponse;

    /**
     * Retrieve default values for About Us page configuration.
     */
    private function getDefaultAboutData(): array
    {
        return [
            'hero_tag' => 'Who We Are',
            'hero_title' => "Moving the World.\nPowering Sri Lanka's Trade.",
            'hero_subtitle' => 'Over two decades of freight forwarding, logistics, and supply chain excellence — built on trust, driven by innovation.',
            'hero_image' => null,
            'company_label' => 'Our Story',
            'company_title' => "From a Single Vision to Sri Lanka's Leading Logistics Partner",
            'company_subtitle' => 'Corporate Profile',
            'company_desc1' => 'Eagle Logistics Colombo was founded in 2005. The company was formed in Partnership between its founder and CEO Asanga Weerackody and CL Synergy Pvt. Limited. With just a 5-member team, Eagle Logistics focused its attention solely on the freight forwarding industry and established itself as one of the best service businesses in the country.',
            'company_desc2' => 'Now making 2 decades of growth, the Eagle Group has diversified into Leisure and IT and operates with a team of over 300 members across its portfolio of companies. While Logistics remains a part of its core operations, the company has also focused on providing end-to-end innovative Supply Chain solutions which help solve complex problems across the industry.',
            'company_founded_year' => '2005',
            'company_image' => null,
            'company_stat1_value' => '20+',
            'company_stat1_label' => 'Years of Experience',
            'company_stat2_value' => '240+',
            'company_stat2_label' => 'Cities Worldwide',
            'company_stat3_value' => '500+',
            'company_stat3_label' => 'Supply Chain Professionals',
            'company_stat4_value' => '100%',
            'company_stat4_label' => 'Customs Compliance',

            'vision_title' => 'Think Differently',
            'vision_statement' => 'To be the most innovative and forward-thinking logistics partner, continuously challenging conventional methods to deliver superior value for our clients globally.',
            'mission_title' => 'Revolutionize Logistics',
            'mission_statement' => 'To revolutionize logistics and supply chains through customer-centric solutions, operational excellence, cutting-edge technology, and empowering our people.',
            'quality_title' => 'Quality Policy',
            'quality_statement' => 'We are committed to delivering world-class freight and logistics solutions with zero compromise on safety, transparency, and timely delivery.',
            'quality_points' => json_encode([
                'Strict compliance with international customs regulations and freight standards.',
                'Continuous improvement through modern tracking and cloud-based analytics.',
                'Transparent customer communication and round-the-clock proactive updates.',
                'Certified cargo handling protocols and temperature-controlled logistics.',
            ], JSON_UNESCAPED_SLASHES),
            'spirit_label' => 'Our Culture & Values',
            'spirit_title' => 'The Eagle Spirit',
            'spirit_subtitle' => 'Our Culture & Values',
            'spirit_description' => "At Eagle Logistic, we believe that great logistics is built on great people. The \"Eagle Spirit\" is our organizational culture — a commitment to soaring above challenges, seeing the big picture, and delivering with precision. Our team embodies agility, integrity, and relentless pursuit of excellence in every shipment, every process, and every partnership.",
            'spirit_quote' => "We don't just move cargo — we move businesses forward.",
            'spirit_image' => 'https://images.unsplash.com/photo-1601584115197-04ecc0da31d7?w=900&q=80',
            'spirit_values' => json_encode([
                ['id' => 1, 'icon' => 'integrity', 'title' => 'Integrity First', 'description' => 'Honesty and transparency in every transaction, every quote, and every delivery promise.'],
                ['id' => 2, 'icon' => 'agility', 'title' => 'Agility & Speed', 'description' => 'Adapting swiftly to global disruption, supply chain volatility, and urgent client requirements.'],
                ['id' => 3, 'icon' => 'excellence', 'title' => 'Operational Excellence', 'description' => 'Continuous pursuit of zero defects, timely delivery, and measurable cost optimization.'],
                ['id' => 4, 'icon' => 'partnership', 'title' => 'True Partnership', 'description' => 'Treating your business as our own — invested in long-term mutual growth and trust.'],
            ], JSON_UNESCAPED_SLASHES),
            'timeline_label' => 'Our Journey',
            'timeline_title' => 'Two Decades of Growth',
            'timeline_subtitle' => 'From a single office in Colombo to a nationwide logistics network — every milestone tells our story.',
            'cta_title' => "Ready to partner with Sri Lanka's leading logistics team?",
            'cta_desc' => 'Whether you need freight forwarding, customs consultancy, or a full BPO solution — we are ready to build something great together.',
            'cta_primary_btn_text' => 'Get in Touch',
            'cta_primary_btn_url' => '/contact',
            'cta_secondary_btn_text' => 'Explore Services',
            'cta_secondary_btn_url' => '/services',
            'seal_text' => 'LOGISTICS EXCELLENCE • SINCE 2008 •',
            'rating_badge_title' => 'Clients 4.8 / 5.0',
            'rating_badge_subtitle' => '(3,567 VERIFIED REVIEWS)',
        ];
    }

    /**
     * Retrieve the About page configuration data.
     */
    public function index(): JsonResponse
    {
        $about = AboutData::first();
        $defaults = $this->getDefaultAboutData();

        if (!$about) {
            $about = new AboutData();
            foreach ($defaults as $key => $val) {
                $about->{$key} = $val;
            }
        } else {
            // Fill any missing properties with fallback defaults
            foreach ($defaults as $key => $val) {
                if (empty($about->{$key}) && $about->{$key} !== '0' && $val !== null) {
                    $about->{$key} = $val;
                }
            }
        }

        return $this->successResponse($about);
    }

    /**
     * Update/Save the About page configuration data.
     */
    public function update(Request $request): JsonResponse
    {
        $about = AboutData::first();
        if (!$about) {
            $about = new AboutData();
        }

        $validated = $request->validate([
            'hero_tag' => ['nullable', 'string', 'max:255'],
            'hero_title' => ['required', 'string'],
            'hero_subtitle' => ['nullable', 'string'],
            'hero_image' => ['nullable', 'string'],

            'company_label' => ['nullable', 'string', 'max:255'],
            'company_title' => ['required', 'string'],
            'company_subtitle' => ['nullable', 'string', 'max:255'],
            'company_desc1' => ['required', 'string'],
            'company_desc2' => ['nullable', 'string'],
            'company_image' => ['nullable', 'string'],
            'company_founded_year' => ['nullable', 'string', 'max:20'],
            'company_stat1_value' => ['nullable', 'string', 'max:50'],
            'company_stat1_label' => ['nullable', 'string', 'max:255'],
            'company_stat2_value' => ['nullable', 'string', 'max:50'],
            'company_stat2_label' => ['nullable', 'string', 'max:255'],
            'company_stat3_value' => ['nullable', 'string', 'max:50'],
            'company_stat3_label' => ['nullable', 'string', 'max:255'],
            'company_stat4_value' => ['nullable', 'string', 'max:50'],
            'company_stat4_label' => ['nullable', 'string', 'max:255'],


            'vision_title' => ['nullable', 'string', 'max:255'],
            'vision_desc' => ['nullable', 'string'],
            'vision_statement' => ['nullable', 'string'],

            'mission_title' => ['nullable', 'string', 'max:255'],
            'mission_desc' => ['nullable', 'string'],
            'mission_statement' => ['nullable', 'string'],

            'quality_title' => ['nullable', 'string', 'max:255'],
            'quality_statement' => ['nullable', 'string'],
            'quality_points' => ['nullable'],

            'spirit_label' => ['nullable', 'string', 'max:255'],
            'spirit_title' => ['nullable', 'string', 'max:255'],
            'spirit_subtitle' => ['nullable', 'string', 'max:255'],
            'spirit_description' => ['nullable', 'string'],
            'spirit_image' => ['nullable', 'string'],
            'spirit_quote' => ['nullable', 'string'],
            'spirit_values' => ['nullable'],

            'timeline_label' => ['nullable', 'string', 'max:255'],
            'timeline_title' => ['nullable', 'string', 'max:255'],
            'timeline_subtitle' => ['nullable', 'string'],

            'cta_title' => ['nullable', 'string'],
            'cta_desc' => ['nullable', 'string'],
            'cta_primary_btn_text' => ['nullable', 'string', 'max:100'],
            'cta_primary_btn_url' => ['nullable', 'string', 'max:255'],
            'cta_secondary_btn_text' => ['nullable', 'string', 'max:100'],
            'cta_secondary_btn_url' => ['nullable', 'string', 'max:255'],

            'ceo_message_title' => ['nullable', 'string', 'max:255'],
            'ceo_message_subtitle' => ['nullable', 'string', 'max:255'],
            'ceo_message_quote' => ['nullable', 'string'],
            'ceo_message_body' => ['nullable', 'string'],
            'ceo_name' => ['nullable', 'string', 'max:255'],
            'ceo_title' => ['nullable', 'string', 'max:255'],
            'ceo_image' => ['nullable', 'string'],
            'values_title' => ['nullable', 'string', 'max:255'],
            'values_desc' => ['nullable', 'string'],
            'motivation_title' => ['nullable', 'string', 'max:255'],
            'motivation_desc' => ['nullable', 'string'],
            'youtube_url' => ['nullable', 'string', 'max:255'],
            'seal_text' => ['nullable', 'string', 'max:255'],
            'rating_badge_title' => ['nullable', 'string', 'max:255'],
            'rating_badge_subtitle' => ['nullable', 'string', 'max:255'],
        ]);

        // Clean up replaced images
        $imageFields = ['hero_image', 'company_image', 'spirit_image', 'ceo_image'];
        foreach ($imageFields as $field) {
            if (array_key_exists($field, $validated) && $about->{$field} && $about->{$field} !== $validated[$field]) {
                FileUploadService::deleteUploadFile($about->{$field});
            }
        }

        // Serialize arrays if supplied
        if (array_key_exists('quality_points', $validated)) {
            $validated['quality_points'] = is_array($validated['quality_points'])
                ? json_encode($validated['quality_points'], JSON_UNESCAPED_SLASHES)
                : $validated['quality_points'];
        }

        if (array_key_exists('spirit_values', $validated)) {
            $validated['spirit_values'] = is_array($validated['spirit_values'])
                ? json_encode($validated['spirit_values'], JSON_UNESCAPED_SLASHES)
                : $validated['spirit_values'];
        }

        $about->fill($validated);
        $about->save();

        return $this->successResponse($about, 'About configurations updated successfully.');
    }

    /**
     * Retrieve all timeline milestones.
     */
    public function indexTimeline(): JsonResponse
    {
        $milestones = AboutTimeline::orderBy('sort_order', 'asc')
            ->orderBy('year', 'asc')
            ->get();

        return $this->successResponse($milestones);
    }

    /**
     * Store a new timeline milestone.
     */
    public function storeTimeline(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'year' => ['required', 'string', 'max:10'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $milestone = AboutTimeline::create($validated);

        return $this->successResponse($milestone, 'Timeline milestone added successfully.', 201);
    }

    /**
     * Update an existing timeline milestone.
     */
    public function updateTimeline(Request $request, int $id): JsonResponse
    {
        $milestone = AboutTimeline::findOrFail($id);

        $validated = $request->validate([
            'year' => ['required', 'string', 'max:10'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $milestone->update($validated);

        return $this->successResponse($milestone, 'Timeline milestone updated successfully.');
    }

    /**
     * Delete a timeline milestone.
     */
    public function destroyTimeline(int $id): JsonResponse
    {
        $milestone = AboutTimeline::findOrFail($id);
        $milestone->delete();

        return $this->successResponse(null, 'Timeline milestone deleted successfully.');
    }
}
