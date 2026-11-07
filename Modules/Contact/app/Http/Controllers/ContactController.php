<?php

namespace Modules\Contact\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use App\Support\FileUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Contact\Models\ContactDetails;
use Modules\Contact\Models\ContactPage;

class ContactController extends Controller
{
    use ApiResponse;

    /**
     * Get the active contact details record.
     */
    public function showDetails(): JsonResponse
    {
        $details = ContactDetails::first();

        if (!$details) {
            $details = ContactDetails::create([
                'phone' => '+94 115 743 743',
                'email' => 'info@eaglelogistic.com',
                'sales_email' => 'sales@eaglelogistic.com',
                'careers_email' => 'careers@eaglelogistic.com',
                'address' => 'No 281, R. A. De Mel Mawatha, Colombo 03, Sri Lanka.',
                'india_address' => 'No.7, 2nd Floor, Venkatasamy Street, Chetpet, Chennai-600031.',
                'maldives_address' => "H.Blue Asseyri (First Floor), Raiyvilla Hingun, Male', Rep. of Maldives.",
                'map_iframe_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3961.023318920453!2d79.8593982!3d6.887810099999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae25bc4cb5b0259%3A0x568eccf2c8efa7c5!2s281%2C%203%20R.%20A.%20De%2520Mel%2520Mawatha%2C%2520Colombo%252000500!5e0!3m2!1sen!2slk!4v1786154296377!5m2!1sen!2slk',
            ]);
        }

        return $this->successResponse($details);
    }

    /**
     * Update the contact details record.
     */
    public function updateDetails(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'phone' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'sales_email' => ['nullable', 'email', 'max:255'],
            'careers_email' => ['nullable', 'email', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'india_address' => ['nullable', 'string'],
            'maldives_address' => ['nullable', 'string'],
            'map_iframe_url' => ['required', 'string'],
        ]);

        $details = ContactDetails::first();

        if ($details) {
            $details->update($validated);
        } else {
            $details = ContactDetails::create($validated);
        }

        return $this->successResponse($details, 'Contact details updated successfully.');
    }

    /**
     * Retrieve default values for Contact page configuration.
     */
    private function getDefaultContactPage(): array
    {
        return [
            'hero_tag' => 'Get In Touch',
            'hero_title' => "We Are Ready\nTo Help You",
            'hero_subtitle' => 'Whether you need a freight quote, customs advice or want to explore our BPO services — our team is ready to respond within 24 hours.',
            'hero_image' => 'https://images.unsplash.com/photo-1578575437130-527eed3abbec?w=1600&q=80',
            'stats' => [
                ['id' => 1, 'value' => '< 24hrs', 'label' => 'Response Time'],
                ['id' => 2, 'value' => '20+', 'label' => 'Years Experience'],
                ['id' => 3, 'value' => '4', 'label' => 'Office Locations'],
                ['id' => 4, 'value' => '100%', 'label' => 'Client Satisfaction'],
            ],
            'form_label' => 'Send a Message',
            'form_title' => "Let's Start a Conversation",
            'form_desc' => 'Fill in the form and one of our specialists will get back to you within 24 hours — often much sooner.',
            'direct_phone' => '011 2577892',
            'direct_email' => 'info@eaglelogisticscmb.com',
            'business_hours' => 'Mon - Fri: 8:30 AM - 5:30 PM',
            'departments' => [
                [
                    'id' => 1,
                    'name' => 'General Inquiries',
                    'email' => 'info@eaglelogisticscmb.com',
                    'description' => 'General questions about our services and company.',
                    'icon' => 'mail',
                ],
                [
                    'id' => 2,
                    'name' => 'Freight & Logistics',
                    'email' => 'info@eaglelogisticscmb.com',
                    'description' => 'Freight forwarding quotes and logistics solutions.',
                    'icon' => 'ship',
                ],
                [
                    'id' => 3,
                    'name' => 'Customs & Compliance',
                    'email' => 'sewwandi@eaglelogisticscmb.com',
                    'description' => 'Customs clearance and trade compliance queries.',
                    'icon' => 'clipboard',
                ],
                [
                    'id' => 4,
                    'name' => 'Careers & HR',
                    'email' => 'hrm@eaglelogisticscmb.com',
                    'description' => 'Job applications and internship enquiries.',
                    'icon' => 'people',
                ],
                [
                    'id' => 5,
                    'name' => 'Logistics BPO',
                    'email' => 'info@eaglelogisticscmb.com',
                    'description' => 'BPO services, outsourcing and cost-saving solutions.',
                    'icon' => 'cpu',
                ],
                [
                    'id' => 6,
                    'name' => 'Technology & IT',
                    'email' => 'it@eaglelogisticscmb.com',
                    'description' => 'Prime Business Solutions and IT consultation.',
                    'icon' => 'code',
                ],
            ],
            'offices' => [
                [
                    'id' => 1,
                    'name' => 'Head Office — Colombo',
                    'address' => 'No.281-1/1, R. A. De Mel Mawatha, Colombo 03, Sri Lanka.',
                    'phone' => '011 2577892',
                    'email' => 'info@eaglelogisticscmb.com',
                    'mapUrl' => 'https://maps.app.goo.gl/WZ5iXgwTFeJEBoCE6',
                    'embedUrl' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d990.21399161402!2d79.8530741!3d6.9078208!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae2596d975c086f%3A0x347979271bd2ae77!2sEagle%20Logistics%20Colombo%20(Pvt)%20Ltd!5e0!3m2!1sen!2slk!4v1791521157333!5m2!1sen!2slk',
                    'primary' => true,
                ],
                [
                    'id' => 2,
                    'name' => 'Katunayake Branch',
                    'address' => 'No.210, Colombo Road, Liyanagemulla, Seeduwa, Sri Lanka.',
                    'phone' => '011 2577892',
                    'email' => 'info@eaglelogisticscmb.com',
                    'mapUrl' => 'https://maps.app.goo.gl/xopkfQn75w6yjDMh7',
                    'embedUrl' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3958.8307352809766!2d79.87353019999999!3d7.1455625!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae2f1d348d5dff3%3A0xe1d44a99bdcfcbd5!2sEagle%20Logistics%20CMB%20Katunayake!5e0!3m2!1sen!2slk!4v1791521557218!5m2!1sen!2slk',
                    'primary' => false,
                ],
                [
                    'id' => 3,
                    'name' => 'Moratuwa Office',
                    'address' => 'No.437, Galle Road, Rawathawaththa, Moratuwa, Sri Lanka.',
                    'phone' => '011 2577892',
                    'email' => 'info@eaglelogisticscmb.com',
                    'mapUrl' => 'https://maps.app.goo.gl/fsWXJBbm4VFm1BaL7',
                    'embedUrl' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3961.837018328245!2d79.88557589999999!3d6.789677900000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae2451abd19affd%3A0xbf5ae8c6ff20ed2!2sEagle%20Logistics%20Colombo%20Moratuwa!5e0!3m2!1sen!2slk!4v1791521845196!5m2!1sen!2slk',
                    'primary' => false,
                ],
                [
                    'id' => 4,
                    'name' => 'Battaramulla Office',
                    'address' => 'No.717/C, 3rd Floor, Battaramulla - Pannipitiya Rd, Battaramulla, Sri Lanka.',
                    'phone' => '011 2577892',
                    'email' => 'info@eaglelogisticscmb.com',
                    'mapUrl' => 'https://maps.app.goo.gl/v2iootrGU8bFGTsi7',
                    'embedUrl' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.906744164476!2d79.91961520000001!3d6.9017553000000005!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae2577c16fbe2c5%3A0x650f19ab411c859b!2sEagle%20Logistics%20CMB%20Battaramulla!5e0!3m2!1sen!2slk!4v1791522003420!5m2!1sen!2slk',
                    'primary' => false,
                ],
            ],
        ];
    }

    /**
     * Get the active Contact page configuration.
     */
    public function showPage(): JsonResponse
    {
        $page = ContactPage::first();
        if (!$page) {
            $page = ContactPage::create($this->getDefaultContactPage());
        }

        return $this->successResponse($page);
    }

    /**
     * Update/Save the Contact page configuration data.
     */
    public function updatePage(Request $request): JsonResponse
    {
        $page = ContactPage::first();
        if (!$page) {
            $page = new ContactPage();
        }

        $validated = $request->validate([
            'hero_tag' => ['nullable', 'string', 'max:255'],
            'hero_title' => ['required', 'string'],
            'hero_subtitle' => ['nullable', 'string'],
            'hero_image' => ['nullable', 'string'],
            'stats' => ['nullable', 'array'],
            'stats.*.value' => ['nullable', 'string'],
            'stats.*.label' => ['nullable', 'string'],
            'form_label' => ['nullable', 'string', 'max:255'],
            'form_title' => ['nullable', 'string', 'max:255'],
            'form_desc' => ['nullable', 'string'],
            'direct_phone' => ['nullable', 'string', 'max:255'],
            'direct_email' => ['nullable', 'string', 'max:255'],
            'business_hours' => ['nullable', 'string', 'max:255'],
            'departments' => ['nullable', 'array'],
            'offices' => ['nullable', 'array'],
        ]);

        $oldHeroImage = $page->hero_image;

        $page->fill($validated);
        $page->save();

        if ($oldHeroImage && array_key_exists('hero_image', $validated) && $oldHeroImage !== $validated['hero_image']) {
            FileUploadService::deleteUploadFile($oldHeroImage);
        }

        return $this->successResponse($page, 'Contact page configuration updated successfully.');
    }
}
