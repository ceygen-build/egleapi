<?php

namespace Modules\Settings\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use App\Support\FileUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Settings\Models\SettingsModel;

class SettingsController extends Controller
{
    use ApiResponse;

    /**
     * Get active global settings.
     */
    public function index(): JsonResponse
    {
        $settings = SettingsModel::first();

        if (!$settings) {
            // Seed a default single row if none exists
            $settings = SettingsModel::create([
                'facebook_page_id' => '',
                'facebook_access_token' => '',
                'website_logo' => '/images/logo.png', // default placeholder asset
                'website_favicon' => '/favicon.svg',
                'experience_badge' => 'OUR EXPERIENCE',
                'experience_title' => 'We are a Leading one-Stop Logistic Service provider helps to Reach Your exact delivery destination on Time Without',
                'experience_highlight' => 'Delay and Damages.',
                'experience_is_active' => true,
            ]);
        } else {
            // Ensure defaults are present if null
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

        return $this->successResponse($settings);
    }

    /**
     * Update/Save global settings.
     */
    public function store(Request $request): JsonResponse
    {
        $settings = SettingsModel::first();
        if (!$settings) {
            $settings = new SettingsModel();
        }

        $validated = $request->validate([
            'facebook_page_id' => ['nullable', 'string', 'max:255'],
            'facebook_access_token' => ['nullable', 'string'],
            'website_logo_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,svg,webp', 'max:4096'],
            'website_logo' => ['nullable', 'string'],
            'website_favicon_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,svg,webp,ico', 'max:4096'],
            'website_favicon' => ['nullable', 'string'],
            'stat1_value' => ['nullable', 'string', 'max:255'],
            'stat1_label' => ['nullable', 'string', 'max:255'],
            'stat2_value' => ['nullable', 'string', 'max:255'],
            'stat2_label' => ['nullable', 'string', 'max:255'],
            'stat3_value' => ['nullable', 'string', 'max:255'],
            'stat3_label' => ['nullable', 'string', 'max:255'],
            'stat4_value' => ['nullable', 'string', 'max:255'],
            'stat4_label' => ['nullable', 'string', 'max:255'],
            'about_stat1_value' => ['nullable', 'integer'],
            'about_stat1_suffix' => ['nullable', 'string', 'max:20'],
            'about_stat1_label' => ['nullable', 'string', 'max:255'],
            'about_stat2_value' => ['nullable', 'integer'],
            'about_stat2_suffix' => ['nullable', 'string', 'max:20'],
            'about_stat2_label' => ['nullable', 'string', 'max:255'],
            'about_stat3_value' => ['nullable', 'integer'],
            'about_stat3_suffix' => ['nullable', 'string', 'max:20'],
            'about_stat3_label' => ['nullable', 'string', 'max:255'],
            'about_stat4_value' => ['nullable', 'integer'],
            'about_stat4_suffix' => ['nullable', 'string', 'max:20'],
            'about_stat4_label' => ['nullable', 'string', 'max:255'],
            'facebook_url' => ['nullable', 'string', 'url', 'max:500'],
            'twitter_url' => ['nullable', 'string', 'url', 'max:500'],
            'linkedin_url' => ['nullable', 'string', 'url', 'max:500'],
            'mail_host' => ['nullable', 'string', 'max:255'],
            'mail_port' => ['nullable', 'integer'],
            'mail_username' => ['nullable', 'string', 'max:255'],
            'mail_password' => ['nullable', 'string', 'max:255'],
            'mail_encryption' => ['nullable', 'string', 'max:50'],
            'mail_from_address' => ['nullable', 'string', 'email', 'max:255'],
            'mail_from_name' => ['nullable', 'string', 'max:255'],
            'website_url' => ['nullable', 'string', 'url', 'max:255'],
            'footer_about' => ['nullable', 'string'],
            'experience_badge' => ['nullable', 'string', 'max:255'],
            'experience_title' => ['nullable', 'string'],
            'experience_highlight' => ['nullable', 'string', 'max:255'],
            'experience_is_active' => ['nullable', 'boolean'],
            'delivering_image' => ['nullable', 'string'],
            'delivering_card_title' => ['nullable', 'string', 'max:255'],
            'delivering_card_num' => ['nullable', 'string', 'max:50'],
            'delivering_card_label' => ['nullable', 'string'],
            'delivering_description' => ['nullable', 'string'],
            'delivering_checklist' => ['nullable', 'string'],
            'delivering_btn_text' => ['nullable', 'string', 'max:255'],
            'delivering_btn_link' => ['nullable', 'string', 'max:255'],
            'delivering_tags' => ['nullable', 'string'],
            'delivering_is_active' => ['nullable', 'boolean'],
            'delivering_ticker_is_active' => ['nullable', 'boolean'],
            'service_carousel_badge' => ['nullable', 'string', 'max:255'],
            'service_carousel_title' => ['nullable', 'string'],
            'service_carousel_is_active' => ['nullable', 'boolean'],
            'industry_badge' => ['nullable', 'string', 'max:255'],
            'industry_title' => ['nullable', 'string'],
            'industry_subtitle' => ['nullable', 'string'],
            'industry_is_active' => ['nullable', 'boolean'],
            'how_it_works_badge' => ['nullable', 'string', 'max:255'],
            'how_it_works_title' => ['nullable', 'string'],
            'how_it_works_is_active' => ['nullable', 'boolean'],
            'supply_chain_badge' => ['nullable', 'string', 'max:255'],
            'supply_chain_title' => ['nullable', 'string'],
            'supply_chain_image' => ['nullable', 'string'],
            'supply_chain_checklist' => ['nullable', 'string'],
            'supply_chain_btn_text' => ['nullable', 'string', 'max:255'],
            'supply_chain_btn_link' => ['nullable', 'string', 'max:255'],
            'supply_chain_stat1_value' => ['nullable', 'string', 'max:255'],
            'supply_chain_stat1_desc' => ['nullable', 'string'],
            'supply_chain_stat2_value' => ['nullable', 'string', 'max:255'],
            'supply_chain_stat2_desc' => ['nullable', 'string'],
            'supply_chain_is_active' => ['nullable', 'boolean'],
            'video_call_thumbnail' => ['nullable', 'string'],
            'video_call_video_type' => ['nullable', 'string', 'in:youtube,file'],
            'video_call_youtube_url' => ['nullable', 'string'],
            'video_call_video_file' => ['nullable', 'string'],
            'video_call_title' => ['nullable', 'string', 'max:255'],
            'video_call_phone_label' => ['nullable', 'string', 'max:255'],
            'video_call_phone_number' => ['nullable', 'string', 'max:255'],
            'video_call_is_active' => ['nullable', 'boolean'],
            'instagram_url' => ['nullable', 'string'],
            'youtube_url' => ['nullable', 'string'],
            'tiktok_url' => ['nullable', 'string'],
            'footer_brand_name' => ['nullable', 'string'],
            'footer_contact_title' => ['nullable', 'string'],
            'footer_phone' => ['nullable', 'string'],
            'footer_email' => ['nullable', 'string'],
            'footer_address' => ['nullable', 'string'],
            'footer_useful_title' => ['nullable', 'string'],
            'footer_useful_links' => ['nullable'],
            'footer_services_title' => ['nullable', 'string'],
            'footer_services_links' => ['nullable'],
            'footer_copyright' => ['nullable', 'string'],
        ]);

        $settings->facebook_page_id = $validated['facebook_page_id'] ?? '';
        $settings->facebook_access_token = $validated['facebook_access_token'] ?? '';
        $settings->facebook_url = $validated['facebook_url'] ?? '';
        $settings->twitter_url = $validated['twitter_url'] ?? '';
        $settings->linkedin_url = $validated['linkedin_url'] ?? '';

        $settings->website_url = $validated['website_url'] ?? '';
        $settings->footer_about = $validated['footer_about'] ?? '';

        $settings->experience_badge = array_key_exists('experience_badge', $validated)
            ? $validated['experience_badge']
            : ($settings->experience_badge ?? 'OUR EXPERIENCE');
        $settings->experience_title = array_key_exists('experience_title', $validated)
            ? $validated['experience_title']
            : ($settings->experience_title ?? 'We are a Leading one-Stop Logistic Service provider helps to Reach Your exact delivery destination on Time Without');
        $settings->experience_highlight = array_key_exists('experience_highlight', $validated)
            ? $validated['experience_highlight']
            : ($settings->experience_highlight ?? 'Delay and Damages.');
        $settings->experience_is_active = array_key_exists('experience_is_active', $validated)
            ? (bool) $validated['experience_is_active']
            : ($settings->experience_is_active ?? true);

        // Delivering section
        if (array_key_exists('delivering_image', $validated)) {
            $newDeliveringImg = $validated['delivering_image'];
            if ($settings->delivering_image && $settings->delivering_image !== $newDeliveringImg) {
                FileUploadService::deleteUploadFile($settings->delivering_image);
            }
            $settings->delivering_image = $newDeliveringImg;
        }

        $settings->delivering_card_title = array_key_exists('delivering_card_title', $validated)
            ? $validated['delivering_card_title']
            : ($settings->delivering_card_title ?? 'Delivering Monster for industry leaders');
        $settings->delivering_card_num = array_key_exists('delivering_card_num', $validated)
            ? $validated['delivering_card_num']
            : ($settings->delivering_card_num ?? '245+');
        $settings->delivering_card_label = array_key_exists('delivering_card_label', $validated)
            ? $validated['delivering_card_label']
            : ($settings->delivering_card_label ?? "Cargo Delivered Per\nMonth");
        $settings->delivering_description = array_key_exists('delivering_description', $validated)
            ? $validated['delivering_description']
            : $settings->delivering_description;
        $settings->delivering_checklist = array_key_exists('delivering_checklist', $validated)
            ? $validated['delivering_checklist']
            : $settings->delivering_checklist;
        $settings->delivering_btn_text = array_key_exists('delivering_btn_text', $validated)
            ? $validated['delivering_btn_text']
            : ($settings->delivering_btn_text ?? 'Know About Us');
        $settings->delivering_btn_link = array_key_exists('delivering_btn_link', $validated)
            ? $validated['delivering_btn_link']
            : ($settings->delivering_btn_link ?? '/about');
        $settings->delivering_tags = array_key_exists('delivering_tags', $validated)
            ? $validated['delivering_tags']
            : $settings->delivering_tags;
        $settings->delivering_is_active = array_key_exists('delivering_is_active', $validated)
            ? (bool) $validated['delivering_is_active']
            : ($settings->delivering_is_active ?? true);
        $settings->delivering_ticker_is_active = array_key_exists('delivering_ticker_is_active', $validated)
            ? (bool) $validated['delivering_ticker_is_active']
            : ($settings->delivering_ticker_is_active ?? true);

        // Service carousel header
        $settings->service_carousel_badge = array_key_exists('service_carousel_badge', $validated)
            ? $validated['service_carousel_badge']
            : ($settings->service_carousel_badge ?? 'OUR EXPERIENCE');
        $settings->service_carousel_title = array_key_exists('service_carousel_title', $validated)
            ? $validated['service_carousel_title']
            : ($settings->service_carousel_title ?? "Essential Features\nof our Services.");
        $settings->service_carousel_is_active = array_key_exists('service_carousel_is_active', $validated)
            ? (bool) $validated['service_carousel_is_active']
            : ($settings->service_carousel_is_active ?? true);

        // Industry section header
        $settings->industry_badge = array_key_exists('industry_badge', $validated)
            ? $validated['industry_badge']
            : ($settings->industry_badge ?? 'Industries We Serve');
        $settings->industry_title = array_key_exists('industry_title', $validated)
            ? $validated['industry_title']
            : ($settings->industry_title ?? "Specialized Solutions for\nEvery Industry");
        $settings->industry_subtitle = array_key_exists('industry_subtitle', $validated)
            ? $validated['industry_subtitle']
            : ($settings->industry_subtitle ?? "From fashion to pharmaceuticals — we bring deep industry expertise to every shipment.");
        $settings->industry_is_active = array_key_exists('industry_is_active', $validated)
            ? (bool) $validated['industry_is_active']
            : ($settings->industry_is_active ?? true);

        // How It Works section header
        $settings->how_it_works_badge = array_key_exists('how_it_works_badge', $validated)
            ? $validated['how_it_works_badge']
            : ($settings->how_it_works_badge ?? 'HOW IT WORKS');
        $settings->how_it_works_title = array_key_exists('how_it_works_title', $validated)
            ? $validated['how_it_works_title']
            : ($settings->how_it_works_title ?? "Logistics Solutions to\nHelp Businesses");
        $settings->how_it_works_is_active = array_key_exists('how_it_works_is_active', $validated)
            ? (bool) $validated['how_it_works_is_active']
            : ($settings->how_it_works_is_active ?? true);

        // Supply Chain Banner section
        if (array_key_exists('supply_chain_image', $validated)) {
            $newSupplyChainImg = $validated['supply_chain_image'];
            if ($settings->supply_chain_image && $settings->supply_chain_image !== $newSupplyChainImg) {
                FileUploadService::deleteUploadFile($settings->supply_chain_image);
            }
            $settings->supply_chain_image = $newSupplyChainImg;
        }

        $settings->supply_chain_badge = array_key_exists('supply_chain_badge', $validated)
            ? $validated['supply_chain_badge']
            : ($settings->supply_chain_badge ?? 'OUR EXPERIENCE');
        $settings->supply_chain_title = array_key_exists('supply_chain_title', $validated)
            ? $validated['supply_chain_title']
            : ($settings->supply_chain_title ?? 'Leader In Supply Chain Storage & Distribution');
        $settings->supply_chain_checklist = array_key_exists('supply_chain_checklist', $validated)
            ? $validated['supply_chain_checklist']
            : ($settings->supply_chain_checklist ?? "Safe Packing\nIn Time Delivery\nShip Everywhere\nCost Saving\nZero Risk\nFastest Shipping");
        $settings->supply_chain_btn_text = array_key_exists('supply_chain_btn_text', $validated)
            ? $validated['supply_chain_btn_text']
            : ($settings->supply_chain_btn_text ?? 'More Details');
        $settings->supply_chain_btn_link = array_key_exists('supply_chain_btn_link', $validated)
            ? $validated['supply_chain_btn_link']
            : ($settings->supply_chain_btn_link ?? '/services');
        $settings->supply_chain_stat1_value = array_key_exists('supply_chain_stat1_value', $validated)
            ? $validated['supply_chain_stat1_value']
            : ($settings->supply_chain_stat1_value ?? '150k');
        $settings->supply_chain_stat1_desc = array_key_exists('supply_chain_stat1_desc', $validated)
            ? $validated['supply_chain_stat1_desc']
            : ($settings->supply_chain_stat1_desc ?? 'Join the companies that trust create to lead their AI transformation.');
        $settings->supply_chain_stat2_value = array_key_exists('supply_chain_stat2_value', $validated)
            ? $validated['supply_chain_stat2_value']
            : ($settings->supply_chain_stat2_value ?? '245k');
        $settings->supply_chain_stat2_desc = array_key_exists('supply_chain_stat2_desc', $validated)
            ? $validated['supply_chain_stat2_desc']
            : ($settings->supply_chain_stat2_desc ?? 'Successful Project Completion for all transport authorize');
        $settings->supply_chain_is_active = array_key_exists('supply_chain_is_active', $validated)
            ? (bool) $validated['supply_chain_is_active']
            : ($settings->supply_chain_is_active ?? true);

        // Video Call Section
        if (array_key_exists('video_call_thumbnail', $validated)) {
            $newThumbnail = $validated['video_call_thumbnail'];
            if ($settings->video_call_thumbnail && $settings->video_call_thumbnail !== $newThumbnail) {
                FileUploadService::deleteUploadFile($settings->video_call_thumbnail);
            }
            $settings->video_call_thumbnail = $newThumbnail;
        }

        if (array_key_exists('video_call_video_file', $validated)) {
            $newVideoFile = $validated['video_call_video_file'];
            if ($settings->video_call_video_file && $settings->video_call_video_file !== $newVideoFile) {
                FileUploadService::deleteUploadFile($settings->video_call_video_file);
            }
            $settings->video_call_video_file = $newVideoFile;
        }

        $settings->video_call_video_type = $validated['video_call_video_type'] ?? ($settings->video_call_video_type ?? 'youtube');
        $settings->video_call_youtube_url = $validated['video_call_youtube_url'] ?? ($settings->video_call_youtube_url ?? 'https://youtube.com/@EagleLogisticsCMB');
        $settings->video_call_title = array_key_exists('video_call_title', $validated)
            ? $validated['video_call_title']
            : ($settings->video_call_title ?? 'We know that every decision has an impact');
        $settings->video_call_phone_label = array_key_exists('video_call_phone_label', $validated)
            ? $validated['video_call_phone_label']
            : ($settings->video_call_phone_label ?? 'Call for free');
        $settings->video_call_phone_number = array_key_exists('video_call_phone_number', $validated)
            ? $validated['video_call_phone_number']
            : ($settings->video_call_phone_number ?? '+94 11 2577892');
        $settings->video_call_is_active = array_key_exists('video_call_is_active', $validated)
            ? (bool) $validated['video_call_is_active']
            : ($settings->video_call_is_active ?? true);

        // Footer & Social Media Settings
        if (array_key_exists('instagram_url', $validated)) {
            $settings->instagram_url = $validated['instagram_url'] ?? '';
        }
        if (array_key_exists('youtube_url', $validated)) {
            $settings->youtube_url = $validated['youtube_url'] ?? '';
        }
        if (array_key_exists('tiktok_url', $validated)) {
            $settings->tiktok_url = $validated['tiktok_url'] ?? '';
        }
        if (array_key_exists('footer_brand_name', $validated)) {
            $settings->footer_brand_name = $validated['footer_brand_name'] ?? 'EAGLE LOGISTICS';
        }
        if (array_key_exists('footer_contact_title', $validated)) {
            $settings->footer_contact_title = $validated['footer_contact_title'] ?? 'Say Hello';
        }
        if (array_key_exists('footer_phone', $validated)) {
            $settings->footer_phone = $validated['footer_phone'] ?? '011 2577892';
        }
        if (array_key_exists('footer_email', $validated)) {
            $settings->footer_email = $validated['footer_email'] ?? 'info@eaglelogisticscmb.com';
        }
        if (array_key_exists('footer_address', $validated)) {
            $settings->footer_address = $validated['footer_address'] ?? 'Colombo, Sri Lanka';
        }
        if (array_key_exists('footer_useful_title', $validated)) {
            $settings->footer_useful_title = $validated['footer_useful_title'] ?? 'Useful Link';
        }
        if (array_key_exists('footer_useful_links', $validated)) {
            $links = $validated['footer_useful_links'];
            $settings->footer_useful_links = is_array($links) ? json_encode($links) : $links;
        }
        if (array_key_exists('footer_services_title', $validated)) {
            $settings->footer_services_title = $validated['footer_services_title'] ?? 'Our Services';
        }
        if (array_key_exists('footer_services_links', $validated)) {
            $links = $validated['footer_services_links'];
            $settings->footer_services_links = is_array($links) ? json_encode($links) : $links;
        }
        if (array_key_exists('footer_copyright', $validated)) {
            $settings->footer_copyright = $validated['footer_copyright'] ?? 'Copyright © {year} Eagle Logistics, All Rights Reserved.';
        }

        $settings->mail_host = $validated['mail_host'] ?? '';
        $settings->mail_port = $validated['mail_port'] ?? null;
        $settings->mail_username = $validated['mail_username'] ?? '';
        $settings->mail_password = $validated['mail_password'] ?? '';
        $settings->mail_encryption = $validated['mail_encryption'] ?? '';
        $settings->mail_from_address = $validated['mail_from_address'] ?? '';
        $settings->mail_from_name = $validated['mail_from_name'] ?? '';

        $settings->stat1_value = $validated['stat1_value'] ?? '15+';
        $settings->stat1_label = $validated['stat1_label'] ?? "Years of\nExcellence";
        $settings->stat2_value = $validated['stat2_value'] ?? '120+';
        $settings->stat2_label = $validated['stat2_label'] ?? "Countries\nServed";
        $settings->stat3_value = $validated['stat3_value'] ?? '25K+';
        $settings->stat3_label = $validated['stat3_label'] ?? "Shipments\nDelivered";
        $settings->stat4_value = $validated['stat4_value'] ?? '24/7';
        $settings->stat4_label = $validated['stat4_label'] ?? "Client\nSupport";

        $settings->about_stat1_value = $validated['about_stat1_value'] ?? 150;
        $settings->about_stat1_suffix = $validated['about_stat1_suffix'] ?? '+';
        $settings->about_stat1_label = $validated['about_stat1_label'] ?? 'Countries Served';

        $settings->about_stat2_value = $validated['about_stat2_value'] ?? 2500;
        $settings->about_stat2_suffix = $validated['about_stat2_suffix'] ?? '+';
        $settings->about_stat2_label = $validated['about_stat2_label'] ?? 'Satisfied Enterprise Clients';

        $settings->about_stat3_value = $validated['about_stat3_value'] ?? 48000;
        $settings->about_stat3_suffix = $validated['about_stat3_suffix'] ?? '+';
        $settings->about_stat3_label = $validated['about_stat3_label'] ?? 'Shipments Handled Annually';

        $settings->about_stat4_value = $validated['about_stat4_value'] ?? 15;
        $settings->about_stat4_suffix = $validated['about_stat4_suffix'] ?? '+';
        $settings->about_stat4_label = $validated['about_stat4_label'] ?? 'Years Cargo Experience';

        // Handle logo file upload
        $oldLogo = $settings->website_logo;
        if ($request->hasFile('website_logo_file')) {
            FileUploadService::deleteUploadFile($oldLogo);

            $file = $request->file('website_logo_file');
            $fileName = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/logo'), $fileName);
            
            // Generate full public URL
            $settings->website_logo = asset('uploads/logo/' . $fileName);
        } elseif (array_key_exists('website_logo', $validated)) {
            $newLogo = $validated['website_logo'];
            if ($oldLogo && $oldLogo !== $newLogo) {
                FileUploadService::deleteUploadFile($oldLogo);
            }
            $settings->website_logo = $newLogo;
        }


        // Handle favicon
        $oldFavicon = $settings->website_favicon;
        if ($request->hasFile('website_favicon_file')) {
            FileUploadService::deleteUploadFile($oldFavicon);

            $file = $request->file('website_favicon_file');
            $fileName = 'favicon_' . time() . '.' . $file->getClientOriginalExtension();
            $targetDir = public_path('uploads/logo');
            if (!file_exists($targetDir)) {
                @mkdir($targetDir, 0755, true);
            }
            $file->move($targetDir, $fileName);
            $settings->website_favicon = asset('uploads/logo/' . $fileName);
        } elseif (array_key_exists('website_favicon', $validated)) {
            $newFavicon = $validated['website_favicon'];
            if ($oldFavicon && $oldFavicon !== $newFavicon) {
                FileUploadService::deleteUploadFile($oldFavicon);
            }
            $settings->website_favicon = $newFavicon;
        }

        $settings->save();

        // Also dynamically push these keys to the env configurations for active sessions
        config(['services.facebook.page_id' => $settings->facebook_page_id]);
        config(['services.facebook.access_token' => $settings->facebook_access_token]);
        config(['app.frontend_url' => $settings->website_url ?? 'https://ceygen.com/']);

        if (!empty($settings->mail_host)) {
            config([
                'mail.default' => 'smtp',
                'mail.mailers.smtp.host' => $settings->mail_host,
                'mail.mailers.smtp.port' => $settings->mail_port ?? 587,
                'mail.mailers.smtp.username' => $settings->mail_username,
                'mail.mailers.smtp.password' => $settings->mail_password,
                'mail.mailers.smtp.encryption' => $settings->mail_encryption,
                'mail.from.address' => $settings->mail_from_address,
                'mail.from.name' => $settings->mail_from_name,
            ]);
        }

        return $this->successResponse($settings, 'Global settings updated successfully.');
    }
}
