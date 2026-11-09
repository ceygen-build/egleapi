<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Modules\Hero\Models\HeroSlide;
use Modules\Service\Models\ServiceItem;
use Modules\Service\Models\ServiceFeature;
use Modules\Service\Models\ServicePage;
use Modules\Team\Models\TeamMember;
use Modules\About\Models\AboutData;
use Modules\About\Models\AboutTimeline;
use Modules\Blog\Models\BlogPost;
use Modules\Blog\Models\BlogPage;
use Modules\Event\Models\EventItem;
use Modules\Gallery\Models\GalleryItem;
use Modules\Career\Models\Vacancy;
use Modules\Career\Models\CareerOption;
use Modules\Career\Models\CareerPage;
use Modules\Faq\Models\FaqItem;
use Modules\Contact\Models\ContactDetails;
use Modules\Contact\Models\ContactPage;
use Modules\Contact\Models\RegionalHub;
use Modules\FacebookFeed\Models\FacebookFeedItem;
use Modules\Settings\Models\SettingsModel;
use Modules\Partner\Models\PartnerModel;
use App\Models\Industry;
use App\Models\Testimonial;
use App\Models\HowItWorksStep;

class PublicDataController extends Controller
{
    use ApiResponse;

    /**
     * Consolidate all guest-facing dynamic configurations.
     */
    public function index(): JsonResponse
    {
        $slides = HeroSlide::orderBy('id', 'desc')->get();
        $services = ServiceItem::orderBy('id', 'desc')->get();
        $team = TeamMember::orderBy('order_index', 'asc')->get();

        $about = AboutData::first();
        $aboutDefaults = [
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
        ];

        if (!$about) {
            $about = new AboutData();
            foreach ($aboutDefaults as $k => $v) {
                $about->{$k} = $v;
            }
        } else {
            foreach ($aboutDefaults as $k => $v) {
                if (empty($about->{$k}) && $about->{$k} !== '0' && $v !== null) {
                    $about->{$k} = $v;
                }
            }
        }

        $timeline = AboutTimeline::orderBy('sort_order', 'asc')->orderBy('year', 'asc')->get();

        $blogs = BlogPost::orderBy('id', 'desc')->get();
        $events = EventItem::orderBy('id', 'desc')->get();
        $gallery = GalleryItem::orderBy('id', 'desc')->get();
        $vacancies = Vacancy::orderBy('id', 'desc')->get();
        $faqs = FaqItem::orderBy('id', 'desc')->get();

        if (Industry::whereNotNull('short')->count() === 0) {
            Industry::truncate();

            $defaultIndustries = [
                [
                    'name' => "Fashion &\nApparel",
                    'short' => 'Fashion',
                    'description' => 'End-to-end logistics for fashion brands — from factory to retail floor. Time-sensitive deliveries, seasonal planning and global sourcing support.',
                    'color' => '#e11d48',
                    'bg_color' => '#1a0a0d',
                    'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800&q=80',
                    'stats' => '48hr Turnaround',
                    'services' => ['Air Freight', 'Express Delivery', 'Warehousing'],
                    'icon_name' => 'fashion',
                    'sort_order' => 1,
                    'is_active' => true,
                    'link' => '/contact',
                ],
                [
                    'name' => "Medical &\nPharma",
                    'short' => 'Medical',
                    'description' => 'GDP-compliant cold chain logistics for pharmaceuticals, medical devices and healthcare products. Zero-compromise quality and regulatory adherence.',
                    'color' => '#2563eb',
                    'bg_color' => '#040e1f',
                    'image' => 'https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?w=800&q=80',
                    'stats' => 'GDP Certified',
                    'services' => ['Cold Chain', 'Logipharma', 'Customs Clearance'],
                    'icon_name' => 'medical',
                    'sort_order' => 2,
                    'is_active' => true,
                    'link' => '/contact',
                ],
                [
                    'name' => "FMCG &\nRetail",
                    'short' => 'FMCG',
                    'description' => 'High-volume, high-velocity logistics for consumer goods. We keep your supply chain moving so your shelves are never empty.',
                    'color' => '#f97316',
                    'bg_color' => '#1a0c03',
                    'image' => 'https://images.unsplash.com/photo-1578575437130-527eed3abbec?w=800&q=80',
                    'stats' => '300+ Clients',
                    'services' => ['Ocean Freight', 'LCL / FCL', 'Distribution'],
                    'icon_name' => 'fmcg',
                    'sort_order' => 3,
                    'is_active' => true,
                    'link' => '/contact',
                ],
                [
                    'name' => "Chemical &\nIndustrial",
                    'short' => 'Chemical',
                    'description' => 'Safe, compliant handling of hazardous and non-hazardous chemicals. IMDG-certified teams managing documentation, storage and cross-border movement.',
                    'color' => '#0f6e56',
                    'bg_color' => '#03120f',
                    'image' => 'https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?w=800&q=80',
                    'stats' => 'IMDG Certified',
                    'services' => ['Hazmat Handling', 'Specialized Freight', 'Compliance'],
                    'icon_name' => 'chemical',
                    'sort_order' => 4,
                    'is_active' => true,
                    'link' => '/contact',
                ],
                [
                    'name' => "Automotive &\nMachinery",
                    'short' => 'Automotive',
                    'description' => 'Heavy cargo, oversized equipment and automotive parts — handled with precision. RO/RO, breakbulk and project cargo specialists at your service.',
                    'color' => '#7c3aed',
                    'bg_color' => '#0f0820',
                    'image' => 'https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?w=800&q=80',
                    'stats' => 'RO/RO Specialists',
                    'services' => ['RO/RO', 'Project Cargo', 'Breakbulk'],
                    'icon_name' => 'auto',
                    'sort_order' => 5,
                    'is_active' => true,
                    'link' => '/contact',
                ],
            ];

            foreach ($defaultIndustries as $item) {
                Industry::create($item);
            }
        }
        $industries = Industry::where('is_active', true)->orderBy('sort_order', 'asc')->orderBy('id', 'asc')->get();
        $testimonials = Testimonial::where('is_active', true)->orderBy('id', 'desc')->get();

        $contact = ContactDetails::first();
        if (!$contact) {
            $contact = new ContactDetails();
        }

        if (RegionalHub::count() === 0) {
            $initialHubs = [
                ['name' => 'Colombo HQ', 'phone' => '+94 11 234 5678', 'sort_order' => 1, 'is_active' => true],
                ['name' => 'Singapore Hub', 'phone' => '+65 6789 0123', 'sort_order' => 2, 'is_active' => true],
                ['name' => 'Rotterdam Gateway', 'phone' => '+31 10 987 6543', 'sort_order' => 3, 'is_active' => true],
                ['name' => 'Los Angeles Terminal', 'phone' => '+1 213 555 0199', 'sort_order' => 4, 'is_active' => true],
            ];
            foreach ($initialHubs as $hub) {
                RegionalHub::create($hub);
            }
        }
        $regionalHubs = RegionalHub::where('is_active', true)->orderBy('sort_order', 'asc')->orderBy('id', 'asc')->get();

        $facebookFeed = FacebookFeedItem::where('status', 'approved')->orderBy('posted_at', 'desc')->get();

        $settings = SettingsModel::first();
        if (!$settings) {
            $settings = SettingsModel::create([
                'facebook_page_id' => '',
                'facebook_access_token' => '',
                'website_logo' => '/images/logo.png',
                'website_favicon' => '/favicon.svg',
                'experience_badge' => 'OUR EXPERIENCE',
                'experience_title' => 'We are a Leading one-Stop Logistic Service provider helps to Reach Your exact delivery destination on Time Without',
                'experience_highlight' => 'Delay and Damages.',
                'experience_is_active' => true,
            ]);
        } else {
            if (empty($settings->website_favicon)) {
                $settings->website_favicon = '/favicon.svg';
            }
            if (empty($settings->experience_badge)) {
                $settings->experience_badge = 'OUR EXPERIENCE';
            }
            if (empty($settings->experience_title)) {
                $settings->experience_title = 'We are a Leading one-Stop Logistic Service provider helps to Reach Your exact delivery destination on Time Without';
            }
            if (empty($settings->experience_highlight)) {
                $settings->experience_highlight = 'Delay and Damages.';
            }
            if ($settings->experience_is_active === null) {
                $settings->experience_is_active = true;
            }
            if (empty($settings->delivering_image)) {
                $settings->delivering_image = 'https://images.unsplash.com/photo-1601584115197-04ecc0da31d7?w=800&q=80';
            }
            if (empty($settings->delivering_card_title)) {
                $settings->delivering_card_title = 'Delivering Monster for industry leaders';
            }
            if (empty($settings->delivering_card_num)) {
                $settings->delivering_card_num = '245+';
            }
            if (empty($settings->delivering_card_label)) {
                $settings->delivering_card_label = "Cargo Delivered Per\nMonth";
            }
            if (empty($settings->delivering_description)) {
                $settings->delivering_description = 'Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt dolores suspendisse ultrices gravida risus.';
            }
            if (empty($settings->delivering_checklist)) {
                $settings->delivering_checklist = "We will never compromise the safety of our people\nFour decades of experience providing solutions\nSee projects through and proactively develop solutions";
            }
            if (empty($settings->delivering_btn_text)) {
                $settings->delivering_btn_text = 'Know About Us';
            }
            if (empty($settings->delivering_btn_link)) {
                $settings->delivering_btn_link = '/about';
            }
            if (empty($settings->delivering_tags)) {
                $settings->delivering_tags = "Air Freight\nWarehousing\nSea Freight";
            }
            if ($settings->delivering_is_active === null) {
                $settings->delivering_is_active = true;
            }
            if ($settings->delivering_ticker_is_active === null) {
                $settings->delivering_ticker_is_active = true;
            }
            if (empty($settings->service_carousel_badge)) {
                $settings->service_carousel_badge = 'OUR EXPERIENCE';
            }
            if (empty($settings->service_carousel_title)) {
                $settings->service_carousel_title = "Essential Features\nof our Services.";
            }
            if ($settings->service_carousel_is_active === null) {
                $settings->service_carousel_is_active = true;
            }
            if (empty($settings->industry_badge)) {
                $settings->industry_badge = 'Industries We Serve';
            }
            if (empty($settings->industry_title)) {
                $settings->industry_title = "Specialized Solutions for\nEvery Industry";
            }
            if (empty($settings->industry_subtitle)) {
                $settings->industry_subtitle = "From fashion to pharmaceuticals — we bring deep industry expertise to every shipment.";
            }
            if ($settings->industry_is_active === null) {
                $settings->industry_is_active = true;
            }
            if (empty($settings->how_it_works_badge)) {
                $settings->how_it_works_badge = 'HOW IT WORKS';
            }
            if (empty($settings->how_it_works_title)) {
                $settings->how_it_works_title = "Logistics Solutions to\nHelp Businesses";
            }
            if ($settings->how_it_works_is_active === null) {
                $settings->how_it_works_is_active = true;
            }
            if (empty($settings->supply_chain_badge)) {
                $settings->supply_chain_badge = 'OUR EXPERIENCE';
            }
            if (empty($settings->supply_chain_title)) {
                $settings->supply_chain_title = 'Leader In Supply Chain Storage & Distribution';
            }
            if (empty($settings->supply_chain_image)) {
                $settings->supply_chain_image = 'https://images.unsplash.com/photo-1494412574643-ff11b0a5c1c3?w=900&q=80';
            }
            if (empty($settings->supply_chain_checklist)) {
                $settings->supply_chain_checklist = "Safe Packing\nIn Time Delivery\nShip Everywhere\nCost Saving\nZero Risk\nFastest Shipping";
            }
            if (empty($settings->supply_chain_btn_text)) {
                $settings->supply_chain_btn_text = 'More Details';
            }
            if (empty($settings->supply_chain_btn_link)) {
                $settings->supply_chain_btn_link = '/services';
            }
            if (empty($settings->supply_chain_stat1_value)) {
                $settings->supply_chain_stat1_value = '150k';
            }
            if (empty($settings->supply_chain_stat1_desc)) {
                $settings->supply_chain_stat1_desc = 'Join the companies that trust create to lead their AI transformation.';
            }
            if (empty($settings->supply_chain_stat2_value)) {
                $settings->supply_chain_stat2_value = '245k';
            }
            if (empty($settings->supply_chain_stat2_desc)) {
                $settings->supply_chain_stat2_desc = 'Successful Project Completion for all transport authorize';
            }
            if ($settings->supply_chain_is_active === null) {
                $settings->supply_chain_is_active = true;
            }
            if (empty($settings->video_call_thumbnail)) {
                $settings->video_call_thumbnail = '/assets/video-thumbnail.jpg';
            }
            if (empty($settings->video_call_video_type)) {
                $settings->video_call_video_type = 'youtube';
            }
            if (empty($settings->video_call_youtube_url)) {
                $settings->video_call_youtube_url = 'https://youtube.com/@EagleLogisticsCMB';
            }
            if (empty($settings->video_call_title)) {
                $settings->video_call_title = 'We know that every decision has an impact';
            }
            if (empty($settings->video_call_phone_label)) {
                $settings->video_call_phone_label = 'Call for free';
            }
            if (empty($settings->video_call_phone_number)) {
                $settings->video_call_phone_number = '+94 11 2577892';
            }
            if ($settings->video_call_is_active === null) {
                $settings->video_call_is_active = true;
            }
            if (empty($settings->footer_brand_name)) {
                $settings->footer_brand_name = 'EAGLE LOGISTICS';
            }
            if (empty($settings->footer_contact_title)) {
                $settings->footer_contact_title = 'Say Hello';
            }
            if (empty($settings->footer_phone)) {
                $settings->footer_phone = '011 2577892';
            }
            if (empty($settings->footer_email)) {
                $settings->footer_email = 'info@eaglelogisticscmb.com';
            }
            if (empty($settings->footer_address)) {
                $settings->footer_address = 'Colombo, Sri Lanka';
            }
            if (empty($settings->footer_useful_title)) {
                $settings->footer_useful_title = 'Useful Link';
            }
            if (empty($settings->footer_useful_links)) {
                $settings->footer_useful_links = json_encode([
                    ['id' => 1, 'label' => 'About', 'href' => '/about'],
                    ['id' => 2, 'label' => 'Careers', 'href' => '/careers'],
                    ['id' => 3, 'label' => 'Contact Us', 'href' => '/contact'],
                    ['id' => 4, 'label' => 'Press & Media', 'href' => '/press'],
                    ['id' => 5, 'label' => 'Supply Chain Community', 'href' => '/supply-chain-community'],
                ]);
            }
            if (empty($settings->footer_services_title)) {
                $settings->footer_services_title = 'Our Services';
            }
            if (empty($settings->footer_services_links)) {
                $settings->footer_services_links = json_encode([
                    ['id' => 1, 'label' => 'International Trade', 'href' => '/services/freight-forwarding'],
                    ['id' => 2, 'label' => 'Logistics Business Process Outsourcing', 'href' => '/services/logistics-bpo'],
                    ['id' => 3, 'label' => 'Customs & Consultancy', 'href' => '/services/customs-consultancy'],
                    ['id' => 4, 'label' => 'Trade Consultation', 'href' => '/services/trade-consultation'],
                    ['id' => 5, 'label' => 'BDP Partnership', 'href' => '/bdp-partnership'],
                ]);
            }
            if (empty($settings->footer_copyright)) {
                $settings->footer_copyright = 'Copyright © {year} Eagle Logistics, All Rights Reserved.';
            }
            if (empty($settings->instagram_url)) {
                $settings->instagram_url = 'https://instagram.com/eagle_logistics_cmb';
            }
            if (empty($settings->youtube_url)) {
                $settings->youtube_url = 'https://youtube.com/@EagleLogisticsCMB';
            }
            if (empty($settings->tiktok_url)) {
                $settings->tiktok_url = 'https://tiktok.com/@eaglelogistics';
            }
        }

        if (ServiceFeature::count() === 0) {
            $defaultFeatures = [
                [
                    'title' => 'Customs House Brokerage',
                    'description' => 'The Team at Eagle Logistics is adept at handling different commodities.....',
                    'image' => 'https://images.unsplash.com/photo-1578575437130-527eed3abbec?w=700&q=80',
                    'icon' => 'customs',
                    'featured' => false,
                    'sort_order' => 1,
                    'link' => '/services',
                    'is_active' => true,
                ],
                [
                    'title' => 'International Trade',
                    'description' => 'From its inception, Eagle Logistics Colombo has specialised in International....',
                    'image' => 'https://images.unsplash.com/photo-1601584115197-04ecc0da31d7?w=700&q=80',
                    'icon' => 'trade',
                    'featured' => true,
                    'sort_order' => 2,
                    'link' => '/services',
                    'is_active' => true,
                ],
                [
                    'title' => 'Logistics BPO',
                    'description' => 'Our optimized Logistics Business Process Outsourcing Services are designed to scale your business and its...',
                    'image' => 'https://images.unsplash.com/photo-1494412574643-ff11b0a5c1c3?w=700&q=80',
                    'icon' => 'bpo',
                    'featured' => false,
                    'sort_order' => 3,
                    'link' => '/services',
                    'is_active' => true,
                ],
                [
                    'title' => 'Trade Consultation',
                    'description' => 'Our Team has over 15 years of experience in Global Trade and optimized Logistics Services...',
                    'image' => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=700&q=80',
                    'icon' => 'consultation',
                    'featured' => false,
                    'sort_order' => 4,
                    'link' => '/services',
                    'is_active' => true,
                ],
            ];

            foreach ($defaultFeatures as $item) {
                ServiceFeature::create($item);
            }
        }
        $serviceFeatures = ServiceFeature::where('is_active', true)->orderBy('sort_order', 'asc')->orderBy('id', 'asc')->get();

        $partners = PartnerModel::orderBy('id', 'desc')->get();
        $careerOptions = CareerOption::orderBy('type')->orderBy('name')->get();

        if (HowItWorksStep::count() === 0) {
            $defaultSteps = [
                [
                    'step' => '01',
                    'title' => 'Receive packages',
                    'description' => 'Sed ut perspiciatis unde omnis iste natus ut perspic iatis unde omnis iste perspiciatis ut perspiciatis unde omnis iste natus.',
                    'image' => 'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?w=800&q=80',
                    'image_only' => false,
                    'text_only' => false,
                    'sort_order' => 1,
                    'is_active' => true,
                ],
                [
                    'step' => '02',
                    'title' => 'Deliver packages',
                    'description' => 'Sed ut perspiciatis unde omnis iste natus ut perspic iatis unde omnis iste perspiciatis ut perspiciatis unde omnis iste natus.',
                    'image' => 'https://images.unsplash.com/photo-1601584115197-04ecc0da31d7?w=800&q=80',
                    'image_only' => false,
                    'text_only' => false,
                    'sort_order' => 2,
                    'is_active' => true,
                ],
                [
                    'step' => '03',
                    'title' => 'Transport packages',
                    'description' => 'Sovereign ocean cargo routes and carrier telemetries connecting multi-port international trade channels seamlessly.',
                    'image' => 'https://images.unsplash.com/photo-1605745341112-85968b19335b?w=900&q=80',
                    'image_only' => false,
                    'text_only' => false,
                    'sort_order' => 3,
                    'is_active' => true,
                ],
                [
                    'step' => '04',
                    'title' => 'Warehousing Operation',
                    'description' => 'Sed ut perspiciatis unde omnis iste natus ut perspic iatis unde omnis iste perspiciatis ut perspiciatis unde omnis iste natus. sed do euism od tempor...',
                    'image' => 'https://images.unsplash.com/photo-1553413077-190dd305871c?w=800&q=80',
                    'image_only' => false,
                    'text_only' => false,
                    'sort_order' => 4,
                    'is_active' => true,
                ],
            ];

            foreach ($defaultSteps as $step) {
                HowItWorksStep::create($step);
            }
        }
        $howItWorks = HowItWorksStep::where('is_active', true)->orderBy('sort_order', 'asc')->orderBy('id', 'asc')->get();
        $servicePages = ServicePage::all()->keyBy('slug');
        $blogPages = BlogPage::all()->keyBy('slug');

        return $this->successResponse([
            'slides' => $slides,
            'services' => $services,
            'service_features' => $serviceFeatures,
            'service_pages' => $servicePages,
            'blog_pages' => $blogPages,
            'how_it_works' => $howItWorks,
            'team' => $team,
            'about' => $about,
            'timeline' => $timeline,
            'blogs' => $blogs,
            'events' => $events,
            'gallery' => $gallery,
            'vacancies' => $vacancies,
            'career_options' => $careerOptions,
            'career_page' => CareerPage::first(),
            'faqs' => $faqs,
            'contact_details' => $contact,
            'contact_page' => ContactPage::first(),
            'regional_hubs' => $regionalHubs,
            'facebook_feed' => $facebookFeed,
            'settings' => $settings,
            'partners' => $partners,
            'industries' => $industries,
            'testimonials' => $testimonials,
        ]);
    }

}
