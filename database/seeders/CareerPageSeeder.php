<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Career\Models\CareerPage;

class CareerPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'hero_tag' => 'Join Our Team',
            'hero_title' => "Build Your Career\nWith Eagle Logistic",
            'hero_subtitle' => "Be part of a team that moves Sri Lanka's trade forward. We offer exciting roles, internship programs and a culture built on growth.",
            'hero_image' => 'https://images.unsplash.com/photo-1521737711867-e3b97375f902?w=1600&q=80',
            'why_join_label' => 'Why Eagle Logistic',
            'why_join_title' => 'A Place Where Careers Take Flight',
            'why_join_subtitle' => "Join a team of passionate logistics professionals who are shaping the future of Sri Lanka's supply chain industry.",
            'perks' => [
                [
                    'id' => 1,
                    'icon' => 'growth',
                    'title' => 'Career Growth',
                    'description' => 'Clear progression paths and continuous learning opportunities to help you reach your full potential.',
                ],
                [
                    'id' => 2,
                    'icon' => 'culture',
                    'title' => 'Eagle Culture',
                    'description' => 'A collaborative, inclusive workplace built on the Eagle Spirit — integrity, agility and excellence.',
                ],
                [
                    'id' => 3,
                    'icon' => 'global',
                    'title' => 'Global Exposure',
                    'description' => 'Work with international partners across 240+ cities through our PSA BDP global network.',
                ],
                [
                    'id' => 4,
                    'icon' => 'innovation',
                    'title' => 'Innovation First',
                    'description' => "From AI-powered BPO to digital visibility tools — you'll work at the cutting edge of logistics tech.",
                ],
            ],
            'internship' => [
                'title' => 'Student Internship Program',
                'subtitle' => 'Launching Careers Since 2005',
                'description' => "Eagle Logistic's internship program is designed for school leavers and undergraduates who want real-world experience in logistics, supply chain, customs and business technology. You'll be mentored by industry professionals and work on live projects from day one.",
                'duration' => '3 - 6 Months',
                'open_to' => 'School Leavers & Undergrads',
                'departments' => [
                    'Freight Forwarding',
                    'Logistics BPO',
                    'Customs & Consultancy',
                    'IT & Technology',
                    'Sales & Marketing',
                ],
                'benefits' => [
                    'Hands-on experience in freight, customs and BPO operations',
                    'Mentorship from senior logistics professionals',
                    'Exposure to international trade and global networks',
                    'Certificate of completion and performance reference',
                    'Pathway to full-time Associate roles for top performers',
                ],
                'eligibility' => [
                    'School leavers (A/L completed)',
                    'Undergraduates (any discipline)',
                    'Postgraduate students seeking industry experience',
                ],
                'contact' => [
                    'name' => 'Majintha Rathnayake',
                    'role' => 'Human Resources',
                    'email' => 'hrm@eaglelogisticscmb.com',
                    'phone' => '011 2577892',
                    'avatar' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=200&q=80',
                ],
            ],
            'application_heading' => 'Apply for a Position',
            'application_subheading' => "Don't see the right role above? Submit a general application and we'll reach out when an opportunity opens that fits your skills.",
        ];

        CareerPage::firstOrCreate([], $data);
    }
}

