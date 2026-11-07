<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Service\Models\ServicePage;

class ServicePagesSeeder extends Seeder
{
    /**
     * Seed the default service pages.
     */
    public function run(): void
    {
        $pages = [
            [
                'slug' => 'freight-forwarding',
                'page_name' => 'International Trade',
                'hero_tag' => 'International Trade',
                'hero_title' => "Global Freight Solutions\nBuilt for Sri Lanka",
                'hero_subtitle' => 'Whether you ship a single pallet or a full container, we manage every mile with precision and care.',
                'hero_image' => 'https://images.unsplash.com/photo-1578575437130-527eed3abbec?w=1600&q=80',
                'intro_label' => 'International Trade',
                'intro_title' => "Ocean & Air Freight —\nLCL and FCL",
                'intro_description' => "Eagle Logistic offers a full range of International Trade services, connecting Sri Lankan businesses to global markets. Our expert team handles everything from booking and documentation to customs clearance and final delivery - ensuring your cargo arrives safely, on time, and in full compliance with all regulations.",
                'intro_image' => null,
                'stats' => [
                    ['id' => 1, 'value' => '240+', 'label' => 'Cities Worldwide'],
                    ['id' => 2, 'value' => '20+', 'label' => 'Years Experience'],
                    ['id' => 3, 'value' => '100%', 'label' => 'On-Time Documentation'],
                ],
                'sections_data' => [
                    'ocean_title' => "Global Ocean Freight\nSolutions",
                    'ocean_desc1' => "In today's Global Business Environment, companies are in dire need to effectively use Ocean Freight services to transport finished goods and spare parts. The Ocean Transportation unit at Eagle Logistics has experience in handling the most delicate and time-sensitive consignments — to and from anywhere across the globe.",
                    'ocean_desc2' => "In conjunction with our Global Network of Offices and Agents, we offer our clients a multitude of ocean carriers and services at competitive prices — ensuring reliability, speed and full compliance at every port of call.",
                    'ocean_services' => [
                        ['label' => 'LCL & FCL Services'],
                        ['label' => 'RO/RO & Break Bulk'],
                        ['label' => 'CY to CY / CFS to CFS'],
                        ['label' => 'Port to Port & Door to Door'],
                        ['label' => 'Freight Consolidation'],
                        ['label' => 'Multi-Modal Transport'],
                    ],
                    'ocean_btn_text' => 'Get an Ocean Freight Quote',
                    'ocean_btn_url' => '/contact',
                    'air_title' => "Fast & Reliable\nAir Freight Forwarding",
                    'air_desc1' => "When time is of the essence, our Air Freight solutions provide rapid transit times and guaranteed cargo safety. We coordinate with major commercial airlines and cargo freighters to secure space even during peak seasons.",
                    'air_desc2' => "From small packages and urgent spare parts to heavy oversized cargo, we tailor air solutions with complete customs documentation, priority handling, and direct door-to-door tracking.",
                    'air_services' => [
                        ['label' => 'Door to Door Services'],
                        ['label' => 'Door to Airport Services'],
                        ['label' => 'Express Freight'],
                        ['label' => 'Same Day Departure'],
                        ['label' => 'Heavy Equipment Freight'],
                        ['label' => 'Time-Critical Shipments'],
                    ],
                    'air_btn_text' => 'Get an Air Freight Quote',
                    'air_btn_url' => '/contact',
                ],
                'cta_title' => "Ready to move your cargo with\nSri Lanka's leading freight specialist?",
                'cta_desc' => 'Get in touch with our operations team today for customized shipping schedules and competitive rates.',
                'cta_btn_text' => 'Contact Us',
                'cta_btn_url' => '/contact',
            ],
            [
                'slug' => 'logistics-bpo',
                'page_name' => 'Logistics Business Process Outsourcing',
                'hero_tag' => 'Logistics Business Process Outsourcing',
                'hero_title' => "Cut Costs by 45%.\nNever Compromise Compliance.",
                'hero_subtitle' => 'Outsource your logistics back-office to Eagle Logistic and let us run the operations while you focus on growth.',
                'hero_image' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?w=1600&q=80',
                'intro_label' => 'Logistics BPO',
                'intro_title' => 'What is Logistics Business Process Outsourcing?',
                'intro_description' => "Logistics Business Process Outsourcing (BPO) means handing your back-office logistics operations - data entry, shipment tracking, invoice processing, compliance reporting - to a specialist team. Eagle Logistic's BPO division has helped clients reduce operational costs by up to 45% while maintaining 100% regulatory compliance.",
                'intro_image' => null,
                'stats' => [],
                'sections_data' => [
                    'challenge_label' => 'The Challenge',
                    'challenge_title' => "Logistics and Shipping\nisn't easy.",
                    'challenge_desc1' => "Our optimized Logistics Business Process Outsourcing Services are designed to scale your business and its operations. While you focus on strategic growth, our teams ensure that your back-end Supply Chain Processes are equipped to deliver on that vision.",
                    'challenge_desc2' => "From data entry and shipment tracking to invoice processing and compliance reporting — Eagle Logistic's BPO division takes on the complexity so you don't have to.",
                    'challenge_points' => [
                        'Scale without hiring',
                        'Reduce operational costs by 45%',
                        'Ensure 100% compliance',
                        'Focus on your core business',
                    ],
                    'benefits' => [
                        ['id' => 1, 'title' => 'Scale Up Faster', 'desc' => 'Scale your business with an experienced team that can raise productivity, speed up the supply chain, and deliver accurate work across a range of complex but repetitive logistics processes.'],
                        ['id' => 2, 'title' => 'Expert Professionals', 'desc' => '15+ years of experience in handling different aspects of International Trade Management ensures that we are well-versed with a range of logistics tasks and can ensure speed and efficiency of processes.'],
                        ['id' => 3, 'title' => 'Guaranteed Compliance', 'desc' => 'In-depth industry knowledge and experience ensures that all your documentation is 100% compliant. Hence, there is reduced risks of errors, delays, and penalties.'],
                        ['id' => 4, 'title' => 'Increased Savings', 'desc' => 'Drive up to 45% Cost reduction with efficient and compliant logistics processes, as well as cost savings on hiring and training staff for high quality logistics processes.'],
                        ['id' => 5, 'title' => 'Personalized Services', 'desc' => 'Dedicated teams that understand your business requirements in and out, to be able to leverage optimal cost-saving opportunities while ensuring on-budget and on-time deliveries.'],
                        ['id' => 6, 'title' => 'Confidential and Secure', 'desc' => 'Your data is secure in our data center. With a written agreement backed by our professional indemnity insurance, your business is in safe hands.'],
                    ],
                    'process' => [
                        ['step' => '01', 'title' => 'Assessment', 'desc' => 'We audit your current back-office processes and identify cost and compliance gaps.'],
                        ['step' => '02', 'title' => 'Onboarding', 'desc' => 'We set up systems, integrate with your tools and brief your dedicated team.'],
                        ['step' => '03', 'title' => 'Operations', 'desc' => 'Our team takes over day-to-day processing, tracking and compliance reporting.'],
                        ['step' => '04', 'title' => 'Optimisation', 'desc' => 'Monthly reviews ensure we continuously improve performance and reduce costs further.'],
                    ],
                ],
                'cta_title' => 'Ready to optimize your logistics back-office?',
                'cta_desc' => 'Speak with our BPO specialists to discover potential savings and efficiency gains.',
                'cta_btn_text' => 'Request Consultation',
                'cta_btn_url' => '/contact',
            ],
            [
                'slug' => 'customs-consultancy',
                'page_name' => 'Customs & Consultancy',
                'hero_tag' => 'Customs House Brokerage',
                'hero_title' => "Navigating Sri Lanka Customs\nwith Confidence",
                'hero_subtitle' => 'Expert consultancy that keeps your imports and exports moving — fully compliant, zero delays.',
                'hero_image' => '/assets/slider_img/custom-slide.jpg',
                'intro_label' => 'Customs & Consultancy',
                'intro_title' => 'Your Sri Lanka Customs Specialist',
                'intro_description' => "The Team at Eagle Logistics is adept at handling a wide range of commodities across various industries and navigating the sensitive rules and regulations of Sri Lanka Customs. For those who wish to understand the complexities of customs operations from an academic or research perspective, professional academic support services can provide valuable guidance in exploring such specialized topics. We offer a full range of services that cover every aspect of the Import Clearance Process.",
                'intro_image' => 'https://images.unsplash.com/photo-1578575437130-527eed3abbec?w=900&q=80',
                'stats' => [],
                'sections_data' => [
                    'services_label' => 'What We Cover',
                    'services_title' => 'Complete Customs Services',
                    'services' => [
                        ['id' => 1, 'title' => 'Import & Export Clearance', 'desc' => 'Full customs clearance service for all types of goods entering or leaving Sri Lanka.'],
                        ['id' => 2, 'title' => 'Tariff Classification', 'desc' => 'Accurate HS code classification to ensure correct duty rates and avoid overpayment.'],
                        ['id' => 3, 'title' => 'Duty & Tax Calculation', 'desc' => 'Precise calculation of import duties, VAT, CESS and other levies before shipment.'],
                        ['id' => 4, 'title' => 'Customs Audit Support', 'desc' => 'Preparation and representation during Sri Lanka Customs audits and inspections.'],
                        ['id' => 5, 'title' => 'Trade Compliance Training', 'desc' => 'Staff training programs to keep your team up-to-date with the latest customs rules.'],
                        ['id' => 6, 'title' => 'Permits & Licenses', 'desc' => 'Assistance obtaining import permits, BOI approvals and special commodity licenses.'],
                    ],
                ],
                'cta_title' => 'Facing complex customs questions?',
                'cta_desc' => 'Our licensed customs house agents can clear your consignments swiftly.',
                'cta_btn_text' => 'Contact Brokerage Team',
                'cta_btn_url' => '/contact',
            ],
            [
                'slug' => 'trade-consultation',
                'page_name' => 'Trade Consultation',
                'hero_tag' => 'Trade Consultation',
                'hero_title' => "Expert Logistics\nConsultation Services",
                'hero_subtitle' => 'A decade of global trade experience working for you — optimizing costs, navigating regulations and streamlining your entire supply chain.',
                'hero_image' => 'https://images.unsplash.com/photo-1578575437130-527eed3abbec?w=1600&q=80',
                'intro_label' => 'A Decade of Experience',
                'intro_title' => 'We Have Been in Your Shoes',
                'intro_description' => "Our team has over 15 years of experience in Global Trade and optimized Logistics Services. We have navigated every challenge — from complex Sri Lanka Customs regulations to international shipping terms, demurrage penalties and regulatory compliance. Now we use this knowledge to help others streamline their logistics department and find ways to optimize the cost of international shipping.",
                'intro_image' => null,
                'stats' => [
                    ['value' => '15+', 'label' => 'Years Experience'],
                    ['value' => '500+', 'label' => 'Clients Served'],
                    ['value' => '100%', 'label' => 'Compliance Rate'],
                    ['value' => '45%', 'label' => 'Average Cost Savings'],
                ],
                'sections_data' => [
                    'services' => [
                        ['id' => 1, 'title' => 'Deal with Local Regulatory Bodies', 'description' => 'Dealing with regulatory bodies is a regular compliance challenge which our team aligns with on a daily basis. We help you with the best methods to comply with different and complex regulations by suggesting various strategies and tactics.', 'icon' => 'regulatory'],
                        ['id' => 2, 'title' => 'Reduce Demurrage, Storage & Penalties', 'description' => 'Planning a consignment from the time you decide to purchase it overseas until it reaches your warehouse is critical to reducing unnecessary charges. Demurrage, storage fees and customs penalties are avoidable with the right planning.', 'icon' => 'demurrage'],
                        ['id' => 3, 'title' => 'Decide the Mode and Term of Shipping', 'description' => 'The trading term should be agreed between buyer and seller at the beginning of commercial engagement and documented in a contract. We specialize in helping you select the best cost-effective shipping mode.', 'icon' => 'shipping'],
                    ],
                    'why_choose_us' => [
                        ['id' => 1, 'title' => 'Hands-On Experience', 'description' => 'Our consultants have personally managed complex global trade operations — not just studied them.'],
                        ['id' => 2, 'title' => 'Sri Lanka Specialists', 'description' => 'Deep expertise in Sri Lanka Customs, port operations and local regulatory requirements.'],
                        ['id' => 3, 'title' => 'Cost-First Mindset', 'description' => 'Every recommendation we make is driven by one goal — reducing your total logistics cost.'],
                        ['id' => 4, 'title' => 'End-to-End Support', 'description' => 'From initial consultation to full implementation — we stay with you through every step.'],
                    ],
                ],
                'cta_title' => 'Book a Strategic Trade Consultation',
                'cta_desc' => 'Schedule an advisory session with our senior trade consultants.',
                'cta_btn_text' => 'Book a Consultation',
                'cta_btn_url' => '/contact',
            ],
            [
                'slug' => 'bdp-partnership',
                'page_name' => 'BDP Partnership',
                'hero_tag' => 'Global Partnership',
                'hero_title' => "Eagle Logistic &\nPSA BDP International",
                'hero_subtitle' => 'Through our strategic alliance with PSA BDP, we connect Sri Lankan businesses to a world-class global logistics network spanning 240 cities across 6 continents.',
                'hero_image' => 'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?w=1600&q=80',
                'intro_label' => 'The Partnership',
                'intro_title' => 'Who is PSA BDP?',
                'intro_description' => "PSA BDP is one of the world's leading providers of globally integrated logistics. With a heritage of over 60 years and operations across 6 continents, PSA BDP moves millions of shipments annually for the world's leading companies in chemicals, retail, consumer goods and technology. As their trusted Sri Lanka partner, Eagle Logistic gives local businesses direct access to this powerful global network.",
                'intro_image' => 'https://images.unsplash.com/photo-1578575437130-527eed3abbec?w=900&q=80',
                'stats' => [
                    ['id' => 1, 'value' => '240+', 'label' => 'Cities Worldwide'],
                    ['id' => 2, 'value' => '6', 'label' => 'Continents Covered'],
                    ['id' => 3, 'value' => '60+', 'label' => 'Years of Heritage'],
                    ['id' => 4, 'value' => '100+', 'label' => 'Countries Connected'],
                ],
                'sections_data' => [
                    'tools' => [
                        [
                            'id' => 1,
                            'name' => 'Risk Monitor',
                            'tag' => 'Supply Chain Resilience',
                            'description' => "Risk Monitor is PSA BDP's proprietary supply chain resilience tool that gives businesses real-time visibility into disruptions, delays and risks across their global supply chain.",
                            'features' => [
                                'Real-time global disruption alerts',
                                'Port congestion and delay monitoring',
                                'Weather and geopolitical risk tracking',
                                'Carrier performance benchmarking',
                            ],
                        ],
                        [
                            'id' => 2,
                            'name' => 'BDP Smart',
                            'tag' => 'Digital Freight Platform',
                            'description' => "BDP Smart is the digital freight management platform that gives clients a single window view of all their shipments globally. Book, track and manage ocean, air and road freight from one intuitive dashboard.",
                            'features' => [
                                'Single dashboard for all shipment modes',
                                'Online freight booking and quoting',
                                'Live shipment tracking and ETA updates',
                                'Document management and storage',
                            ],
                        ],
                    ],
                    'verticals' => [
                        ['id' => 1, 'name' => 'Chemical', 'description' => 'Specialized handling of hazardous materials with full IMDG and IATA compliance.'],
                        ['id' => 2, 'name' => 'Retail', 'description' => 'Time-critical retail logistics with peak season capacity and vendor consolidation.'],
                        ['id' => 3, 'name' => 'Consumer Goods', 'description' => 'End-to-end supply chain solutions for FMCG and consumer goods companies.'],
                    ],
                    'benefits' => [
                        ['id' => 1, 'title' => 'Global Network Access', 'description' => 'Seamless reach to 240+ cities in 100+ countries with local expertise.'],
                        ['id' => 2, 'title' => 'Single Point of Contact', 'description' => 'Manage complex international trade lanes with one dedicated account manager.'],
                        ['id' => 3, 'title' => 'Cutting-Edge Digital Tools', 'description' => 'Leverage PSA BDP proprietary platforms for real-time visibility and risk management.'],
                        ['id' => 4, 'title' => 'Multi-Industry Expertise', 'description' => 'Specialized logistics capabilities spanning chemicals, retail, and pharmaceuticals.'],
                    ],
                ],
                'cta_title' => 'Expand your global trade with Eagle & PSA BDP',
                'cta_desc' => 'Harness the combined power of local excellence and global reach.',
                'cta_btn_text' => 'Contact Our Global Team',
                'cta_btn_url' => '/contact',
            ],
        ];

        foreach ($pages as $page) {
            ServicePage::updateOrCreate(['slug' => $page['slug']], $page);
        }
    }
}

