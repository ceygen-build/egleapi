<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Ensure the default Admin user is present and correct
        DB::table('users')->updateOrInsert(
            ['email' => 'admin@eaglelogistic.com'],
            [
                'name' => 'Eagle Logistic Admin',
                'password' => Hash::make('admin123'),
                'role' => 'Administrator',
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // 2. Truncate/Clear all other tables to avoid conflicts
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('hero_slides')->truncate();
        DB::table('services')->truncate();
        DB::table('team_members')->truncate();
        DB::table('about_data')->truncate();
        DB::table('blogs')->truncate();
        DB::table('events')->truncate();
        DB::table('gallery_items')->truncate();
        DB::table('vacancies')->truncate();
        DB::table('faqs')->truncate();
        DB::table('contact_details')->truncate();
        DB::table('settings')->truncate();
        DB::table('partners')->truncate();
        DB::table('industries')->truncate();
        DB::table('testimonials')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 3. Seed hero_slides
        DB::table('hero_slides')->insert([
            [
                'is_active' => true,
                'target_page' => '/',
                'is_multiple' => false,
                'image' => '/images/slider_ocean_cargo.png',
                'title' => 'Sovereign Ocean Freight\\nDelivering Across Continents',
                'subtitle' => 'Global Maritime Logistics',
                'description' => 'Optimize your global supply chains with guaranteed vessel space, direct carrier partnerships, and AI-enabled route telemetry. Serving 120+ countries with absolute cargo protection.',
                'cta_label' => 'Explore Services',
                'cta_href' => '#services',
                'stat_value' => '100%',
                'stat_label' => 'Guarantee',
                'category' => 'Ocean',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'is_active' => true,
                'target_page' => '/',
                'is_multiple' => false,
                'image' => '/images/slider_air_cargo.png',
                'title' => 'Next-Flight-Out Service\\nFor Critical Cargo Assets',
                'subtitle' => 'Priority Air Express',
                'description' => 'Expedited global air freight pathways with custom charters, digital customs brokerage, and real-time flight tracking. Safely transit high-value components anywhere in the world.',
                'cta_label' => 'Book Air Cargo',
                'cta_href' => '#contact',
                'stat_value' => '24-48h',
                'stat_label' => 'Transit Speed',
                'category' => 'Air',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'is_active' => true,
                'target_page' => '/',
                'is_multiple' => false,
                'image' => '/images/slider_warehouse_logistics.png',
                'title' => 'Automated Fulfillment\\nPowered by 4PL Intelligence',
                'subtitle' => 'Smart Contract Logistics',
                'description' => 'Secure temperature-controlled storage, automated inventory tracking, and seamless cross-docking operations. Real-time telemetry reporting for every pallet in our network.',
                'cta_label' => 'Request Quote',
                'cta_href' => '#contact',
                'stat_value' => '99.9%',
                'stat_label' => 'Inventory Accuracy',
                'category' => 'Road',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'is_active' => true,
                'target_page' => '/about',
                'is_multiple' => false,
                'image' => '/images/slider_ocean_cargo.png',
                'title' => 'Smart Freight Forwarding\\nWith Global Control Towers',
                'subtitle' => 'About Our Enterprise',
                'description' => 'Founded with a vision to redefine commercial logistics. We operate as a dedicated multi-carrier proxy broker to guarantee vessel space, secure spot pricing, and craft custom routing strategies.',
                'cta_label' => 'Meet Our Team',
                'cta_href' => '#team',
                'stat_value' => '15+ Years',
                'stat_label' => 'Logistics Excellence',
                'category' => 'Ocean',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'is_active' => true,
                'target_page' => '/services',
                'is_multiple' => false,
                'image' => '/images/slider_warehouse_logistics.png',
                'title' => 'Multi-Modal Freight Solutions\\nConnecting Global Markets',
                'subtitle' => 'Integrated Logistics Services',
                'description' => 'From priority air express cargo to full-scale container shipping and contract warehousing. We handle custom clearance, route telemetry and security at every trade corridor.',
                'cta_label' => 'Get a Custom Quote',
                'cta_href' => '#contact',
                'stat_value' => '24/7',
                'stat_label' => 'Monitoring Control',
                'category' => 'Ocean',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'is_active' => true,
                'target_page' => '/blogs',
                'is_multiple' => false,
                'image' => '/images/slider_ocean_cargo.png',
                'title' => 'Maritime Insights & Supply Chain\\nGlobal Freight Trends Analysis',
                'subtitle' => 'Logistics Intelligence & News',
                'description' => 'Read the latest updates, market trends, and expert insights on international maritime, air freight, customs legislation and logistics innovations.',
                'cta_label' => 'Read Articles',
                'cta_href' => '#featured',
                'stat_value' => 'Weekly',
                'stat_label' => 'Market Analysis',
                'category' => 'Ocean',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'is_active' => true,
                'target_page' => '/events',
                'is_multiple' => false,
                'image' => '/images/slider_air_cargo.png',
                'title' => 'Trade & Industry Conventions\\nGlobal Operations Seminars',
                'subtitle' => 'Corporate Logistics Events',
                'description' => 'Join Eagle Logistic at our upcoming trade conventions, cargo network summits, and digital supply chain masterclasses. Register to secure your seat.',
                'cta_label' => 'Browse Events',
                'cta_href' => '#upcoming',
                'stat_value' => 'Global',
                'stat_label' => 'Events Hub',
                'category' => 'Ocean',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'is_active' => true,
                'target_page' => '/gallery',
                'is_multiple' => false,
                'image' => '/images/slider_ocean_cargo.png',
                'title' => 'Visual Fleet Portfolio\\nGlobal Logistical Operations',
                'subtitle' => 'Media & Gallery Showcase',
                'description' => 'Explore high-resolution media captures of our active maritime vessels, air cargo freighters, heavy haulage fleets, and 3PL bonded facilities.',
                'cta_label' => 'Browse Gallery',
                'cta_href' => '#gallery',
                'stat_value' => '100%',
                'stat_label' => 'Visual Transparency',
                'category' => 'Ocean',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'is_active' => true,
                'target_page' => '/career',
                'is_multiple' => false,
                'image' => '/images/slider_warehouse_logistics.png',
                'title' => 'Build the Future of Logistics\\nJoin Our Global Network',
                'subtitle' => 'Careers at Eagle Logistic',
                'description' => 'Explore rewarding job opportunities, management traineeships, and expert roles in supply chain planning, customer experience, and international freight brokerage.',
                'cta_label' => 'View Careers',
                'cta_href' => '#positions',
                'stat_value' => 'Join Us',
                'stat_label' => 'Open Vacancies',
                'category' => 'Ocean',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'is_active' => true,
                'target_page' => '/contact',
                'is_multiple' => false,
                'image' => '/images/slider_air_cargo.png',
                'title' => 'Global Logistics Support\\n24/7 Operations Help Desk',
                'subtitle' => 'Get In Touch',
                'description' => 'Contact our regional offices, sales desks, or customer care specialists today. Submit an inquiry for customized logistics planning and quotation updates.',
                'cta_label' => 'Submit Inquiry',
                'cta_href' => '#inquiry-form',
                'stat_value' => '24/7',
                'stat_label' => 'Active Support',
                'category' => 'Ocean',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // 4. Seed services (6 items)
        DB::table('services')->insert([
            [
                'slug' => 'ocean-freight',
                'title' => 'Ocean Freight Forwarding',
                'subtitle' => 'Full Container & Shared Shipping Solutions',
                'description' => 'Reliable global ocean freight corridors covering key commercial trade lanes. offering both Full Container Load (FCL) and Less than Container Load (LCL) consolidation services.',
                'icon_name' => 'Ship',
                'category' => 'Ocean Freight',
                'image' => '/images/news_ocean_cargo.png',
                'overview' => 'We provide complete sea freight services for commercial enterprises, moving cargo across continents with absolute transparency.',
                'key_benefits' => json_encode(['Guaranteed vessel space allotment', 'Real-time satellite GPS tracking', 'Customs clearance paperwork handled']),
                'capabilities' => json_encode([
                    ['title' => 'FCL Shipping', 'desc' => 'Full container cargo shipping with flexible scheduling.'],
                    ['title' => 'LCL Consolidation', 'desc' => 'Cost-effective shared container spaces for smaller shipments.']
                ]),
                'process' => json_encode([
                    ['step' => '1', 'title' => 'Booking & Schedule', 'desc' => 'Select shipping route and secure space allocation.'],
                    ['step' => '2', 'title' => 'Customs clearance', 'desc' => 'Process local port documentation before vessel departure.']
                ]),
                'specifications' => json_encode([
                    ['label' => 'Max Weight', 'value' => '28,000 kg per container'],
                    ['label' => 'Average Transit', 'value' => '15 - 35 days depending on corridor']
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'air-freight',
                'title' => 'Air Freight Services',
                'subtitle' => 'Expedited Cargo Solutions',
                'description' => 'Priority shipping for time-sensitive cargo assets. custom air charters and regular commercial schedule options.',
                'icon_name' => 'Plane',
                'category' => 'Air Freight',
                'image' => '/images/news_air_cargo.png',
                'overview' => 'Our global air freight network connects main hubs globally, ensuring rapid transit with zero downtime.',
                'key_benefits' => json_encode(['Express next-flight-out departures', 'Dedicated charter availability', 'Specialized cold chain cargo management']),
                'capabilities' => json_encode([
                    ['title' => 'Express Freight', 'desc' => 'Guaranteed delivery within 24-72 hours.'],
                    ['title' => 'Charter Services', 'desc' => 'Full cargo plane rentals for oversized items.']
                ]),
                'process' => json_encode([
                    ['step' => '1', 'title' => 'Cargo Drop & Inspection', 'desc' => 'Weighing and airport security inspection.'],
                    ['step' => '2', 'title' => 'Flight Transit', 'desc' => 'Fastest routing directly to destination airfield.']
                ]),
                'specifications' => json_encode([
                    ['label' => 'Speed', 'value' => '24-72 hours transit'],
                    ['label' => 'Coverage', 'value' => '220+ international airports']
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'bonded-warehousing',
                'title' => '3PL Bonded Warehousing',
                'subtitle' => 'Inventory Management & Storage',
                'description' => 'Temperature-controlled storage facilities with integrated inventory management systems and customs duty deferment.',
                'icon_name' => 'Warehouse',
                'category' => 'Warehousing',
                'image' => '/images/news_warehouse_logistics.png',
                'overview' => 'Secure storage solutions for commercial goods with digital telemetry tracking and pick-pack automation.',
                'key_benefits' => json_encode(['Temperature range control', 'Cross-docking operations', '24/7 security monitoring']),
                'capabilities' => json_encode([
                    ['title' => 'Inventory Control', 'desc' => 'Real-time pallet tracking and digital logs.'],
                    ['title' => 'Customs Bonded', 'desc' => 'Deferred duty payment storage facilities.']
                ]),
                'process' => json_encode([
                    ['step' => '1', 'title' => 'Receiving & Scanning', 'desc' => 'Pallet barcoding and digital cataloging.'],
                    ['step' => '2', 'title' => 'Fulfillment', 'desc' => 'Order pick-and-pack logistics with telemetry.']
                ]),
                'specifications' => json_encode([
                    ['label' => 'Space', 'value' => '120,000 sq ft capacity'],
                    ['label' => 'Fulfillment', 'value' => '99.9% pick-pack accuracy']
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'overland-trucking',
                'title' => 'Overland Trucking & Haulage',
                'subtitle' => 'Regional Cross-Border Transport',
                'description' => 'Comprehensive overland trucking covering key domestic and regional border corridors with GPS-guided fleets.',
                'icon_name' => 'Truck',
                'category' => 'Land Transport',
                'image' => '/images/news_warehouse_logistics.png',
                'overview' => 'Flexible door-to-door ground haulage for dry van, flatbed, and oversized heavy cargo loads.',
                'key_benefits' => json_encode(['Door-to-door delivery transit', 'Cross-border clearance handling', 'Heavy haulage license compliance']),
                'capabilities' => json_encode([
                    ['title' => 'LTL trucking', 'desc' => 'Less than truckload regional courier consolidation.'],
                    ['title' => 'FTL trucking', 'desc' => 'Dedicated full truckload point-to-point delivery.']
                ]),
                'process' => json_encode([
                    ['step' => '1', 'title' => 'Routing Map', 'desc' => 'Dispatch planning and vehicle scheduling.'],
                    ['step' => '2', 'title' => 'Overland Transit', 'desc' => 'Continuous telemetry updates until final drop.']
                ]),
                'specifications' => json_encode([
                    ['label' => 'Fleet Size', 'value' => '150+ Heavy haul vehicles'],
                    ['label' => 'Max Payload', 'value' => '45,000 kg per truckload']
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'customs-brokerage',
                'title' => 'Customs Brokerage & Compliance',
                'subtitle' => 'Hassle-free Import / Export Clearing',
                'description' => 'Fast-track customs clearance at all major airports and sea harbors managed by certified brokers.',
                'icon_name' => 'Shield',
                'category' => 'Customs & Trade',
                'image' => '/images/news_ocean_cargo.png',
                'overview' => 'We handle complex tariff calculations, harmonized system codes, and local port compliance reports.',
                'key_benefits' => json_encode(['HS tariff code classification', 'Bonded transfer documentation', 'Duty assessment filing']),
                'capabilities' => json_encode([
                    ['title' => 'Import Filing', 'desc' => 'Electronic entry filing with local port authorities.'],
                    ['title' => 'Broker Support', 'desc' => 'In-person customs examinations representation.']
                ]),
                'process' => json_encode([
                    ['step' => '1', 'title' => 'Audit & Classification', 'desc' => 'Verify cargo parameters and classify HS tariff codes.'],
                    ['step' => '2', 'title' => 'Customs Clearing', 'desc' => 'Submit electronic declarations for port clearance.']
                ]),
                'specifications' => json_encode([
                    ['label' => 'Processing Time', 'value' => 'Under 4 hours electronic clearing'],
                    ['label' => 'Compliance Rate', 'value' => '99.98% audit pass rate']
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'cold-chain-logistics',
                'title' => 'Cold Chain Logistics',
                'subtitle' => 'Temperature Sensitive Cargo Routing',
                'description' => 'Active temperature-controlled transport loops for pharmaceutical, biotech, and perishable food products.',
                'icon_name' => 'Globe',
                'category' => 'Specialized Cargo',
                'image' => '/images/news_air_cargo.png',
                'overview' => 'We ensure absolute temperature stability from origin loading to final recipient delivery.',
                'key_benefits' => json_encode(['Continuous temperature logging', 'Reefer container fleet allocation', 'Strict WHO/GDP compliance standards']),
                'capabilities' => json_encode([
                    ['title' => 'Reefer Transport', 'desc' => 'Active cooling container shipping and trucking.'],
                    ['title' => 'Biotech Handling', 'desc' => 'Dry ice and liquid nitrogen deep-freeze routing.']
                ]),
                'process' => json_encode([
                    ['step' => '1', 'title' => 'Thermal Mapping', 'desc' => 'Pre-cool equipment and calibrate active telemetry sensors.'],
                    ['step' => '2', 'title' => 'Monitored Transit', 'desc' => 'Real-time temperature alarms via control tower.']
                ]),
                'specifications' => json_encode([
                    ['label' => 'Temp Range', 'value' => '-80°C to +25°C active monitoring'],
                    ['label' => 'Equipment', 'value' => 'WHO-certified active reefer units']
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // 5. Seed team_members (6 items)
        DB::table('team_members')->insert([
            [
                'name' => 'Inosh Perera',
                'role' => 'Chief Executive Officer',
                'image' => '/images/ceo.png',
                'order_index' => 1,
                'linkedin' => 'https://linkedin.com',
                'twitter' => 'https://twitter.com',
                'email' => 'ceo@eaglelogistic.com',
                'education' => json_encode(['MBA in International Trade', 'BSc in Logistics Management']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Samantha Silva',
                'role' => 'Director of Global Operations',
                'image' => '/images/ceo.png',
                'order_index' => 2,
                'linkedin' => 'https://linkedin.com',
                'twitter' => 'https://twitter.com',
                'email' => 'operations@eaglelogistic.com',
                'education' => json_encode(['MSc in Supply Chain Management']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ravi Fernando',
                'role' => 'Head of Air Cargo Logistics',
                'image' => '/images/ceo.png',
                'order_index' => 3,
                'linkedin' => 'https://linkedin.com',
                'twitter' => null,
                'email' => 'ravi@eaglelogistic.com',
                'education' => json_encode(['IATA Cargo Professional Certificate']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Priyantha Jayasinghe',
                'role' => 'Lead Customs Compliance Advisor',
                'image' => '/images/ceo.png',
                'order_index' => 4,
                'linkedin' => 'https://linkedin.com',
                'twitter' => null,
                'email' => 'compliance@eaglelogistic.com',
                'education' => json_encode(['Licensed Customs House Agent (CHA)']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Nilushi Alwis',
                'role' => 'Director of Client Relations',
                'image' => '/images/ceo.png',
                'order_index' => 5,
                'linkedin' => 'https://linkedin.com',
                'twitter' => null,
                'email' => 'nilushi@eaglelogistic.com',
                'education' => json_encode(['BA in Public Relations', 'Chartered Marketer (CIM)']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dilshan Mendis',
                'role' => 'Warehouse & Inventory Manager',
                'image' => '/images/ceo.png',
                'order_index' => 6,
                'linkedin' => 'https://linkedin.com',
                'twitter' => null,
                'email' => 'dilshan@eaglelogistic.com',
                'education' => json_encode(['Diploma in Warehouse Operations & 3PL Logistics']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // 6. Seed about_data
        DB::table('about_data')->insert([
            'hero_title' => 'Smart Freight Forwarding\\nWith Global Control Towers',
            'hero_subtitle' => 'About Our Enterprise',
            'hero_image' => '/images/slider_ocean_cargo.png',
            'company_title' => 'Pioneering Smart Logistics & Smart Trade Route Solutions',
            'company_subtitle' => 'About Eagle Logistic',
            'company_desc1' => 'At Eagle Logistic, we bridge the gap between businesses and global trade routes. Using advanced supply chain intelligence, digital customs clearance, and high-fidelity real-time tracking, we transport your cargo seamlessly.',
            'company_desc2' => 'Our dedicated teams operate 24/7 to secure spot rates, guarantee container space, and optimize multi-modal routes for ultimate speed and cost-effectiveness.',
            'ceo_message_title' => 'Leading With Customer Trust and Technological Precision',
            'ceo_message_subtitle' => 'Message From Our CEO',
            'ceo_message_quote' => 'Our goal is to build long-term trust by delivering commercial cargo with absolute predictability.',
            'ceo_message_body' => 'Every shipment represents a business relationship. We treat every cargo container and parcel with the utmost dedication, harnessing state-of-the-art dispatch software and cargo tracking arrays to keep your logistics chain strong.',
            'ceo_name' => 'Inosh Perera',
            'ceo_title' => 'Chief Executive Officer',
            'ceo_image' => '/images/ceo.png',
            'vision_title' => 'Our Vision',
            'vision_desc' => 'To be the most reliable and technology-driven logistics partner in the Indian Ocean region, connecting commerce seamlessly.',
            'mission_title' => 'Our Mission',
            'mission_desc' => 'To deploy custom freight forwarding, customs clearance, and warehouse fulfillment strategies that optimize client supply chain performance.',
            'values_title' => 'Core Values',
            'values_desc' => 'Integrity, absolute transparency, continuous innovation, and dedicated client-first customer support.',
            'motivation_title' => 'Our Motivations',
            'motivation_desc' => 'Empowering global trade and helping enterprises expand their market presence with hassle-free freight corridors.',
            'youtube_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 7. Seed blogs (6 items)
        DB::table('blogs')->insert([
            [
                'id' => 'ocean-freight-trends-2026',
                'title' => 'Global Ocean Freight Trends in 2026',
                'excerpt' => 'Explore how port automations, route optimization algorithms, and global container allocations are shaping maritime trade.',
                'category' => 'Maritime & Shipping',
                'author' => 'Inosh Perera',
                'author_role' => 'CEO',
                'author_avatar' => '/images/ceo.png',
                'date' => '2026-08-01',
                'read_time' => '5 min read',
                'image' => '/images/news_ocean_cargo.png',
                'featured' => true,
                'content' => json_encode([
                    'The maritime sector is experiencing a monumental transformation driven by AI dispatching and automated port terminals. In 2026, container routing algorithms are reducing empty-container runs by up to 25%.',
                    'Furthermore, regional shipping alliances are negotiating direct spot prices, offering medium enterprises more stable freight contracts. Read-only control towers are also providing clients with real-time GPS telemetry.'
                ]),
                'key_takeaways' => json_encode([
                    'AI route optimization cuts fuel use by 15%',
                    'Spot prices are stabilizing for FCL shipments',
                    'Satellite tracking is now standard for ocean freight'
                ]),
                'tags' => json_encode(['Ocean Freight', 'Supply Chain', 'AI']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'air-cargo-customs-telemetry',
                'title' => 'Speeding Up Air Cargo Customs Telemetry',
                'excerpt' => 'How digital brokerage integrations and cloud clearing are reducing airfield delays to less than 2 hours.',
                'category' => 'Air Freight',
                'author' => 'Samantha Silva',
                'author_role' => 'Director of Operations',
                'author_avatar' => '/images/ceo.png',
                'date' => '2026-08-05',
                'read_time' => '4 min read',
                'image' => '/images/news_air_cargo.png',
                'featured' => false,
                'content' => json_encode([
                    'Air cargo is highly sensitive to airfield clearance delays. Modern digital customs pipelines allow brokerages to pre-clear air freight manifest files while the plane is still in transit.',
                    'This pre-clearance process has reduced ground processing times at major airports from 12 hours to less than 120 minutes.'
                ]),
                'key_takeaways' => json_encode([
                    'Pre-clearance saves hours of customs holding',
                    'Digital paperwork reduces manual errors by 90%'
                ]),
                'tags' => json_encode(['Air Freight', 'Customs', 'Telemetry']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'decarbonizing-supply-chains-2026',
                'title' => 'Decarbonizing Supply Chains: Green Corridors',
                'excerpt' => 'An analysis of carbon taxation compliance and eco-friendly route optimizations for global logistics networks.',
                'category' => 'Sustainability',
                'author' => 'Inosh Perera',
                'author_role' => 'CEO',
                'author_avatar' => '/images/ceo.png',
                'date' => '2026-08-08',
                'read_time' => '6 min read',
                'image' => '/images/news_ocean_cargo.png',
                'featured' => false,
                'content' => json_encode([
                    'Decarbonization is no longer optional for international trade. European and North American ports are introducing strict carbon taxation programs.',
                    'Logistics managers are leveraging hybrid route architectures, pairing rail transit with green-hydrogen container shipping lines to meet compliance targets.'
                ]),
                'key_takeaways' => json_encode([
                    'Green corridors reduce carbon penalties by 40%',
                    'Alternative fuels adoption is scaling up'
                ]),
                'tags' => json_encode(['Green Logistics', 'Sustainability', 'Trade Laws']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'role-of-4pl-cold-chain',
                'title' => 'The Role of 4PL in Cold Chain Reliability',
                'excerpt' => 'Ensuring cold-chain asset protection using remote telemetry sensors and automated dispatch alerts.',
                'category' => 'Specialized Cargo',
                'author' => 'Samantha Silva',
                'author_role' => 'Director of Operations',
                'author_avatar' => '/images/ceo.png',
                'date' => '2026-08-10',
                'read_time' => '7 min read',
                'image' => '/images/news_air_cargo.png',
                'featured' => false,
                'content' => json_encode([
                    'Cold chain shipping cannot tolerate temperature excursions. By integrating 4PL telemetry, cargo containers communicate status logs hourly.',
                    'Automatic alerts are dispatched immediately if a temperature threshold is breached, triggering remote compressor calibrations.'
                ]),
                'key_takeaways' => json_encode([
                    '4PL monitoring prevents cargo loss by 95%',
                    'GDP regulations demand strict temperature logs'
                ]),
                'tags' => json_encode(['Cold Chain', '4PL', 'Smart Sensors']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'navigating-customs-tariffs',
                'title' => 'Navigating Customs Tariffs in South Asia',
                'excerpt' => 'Understanding bilateral trade agreements, regional tariff codes, and duty exemption categories.',
                'category' => 'Customs & Trade',
                'author' => 'Priyantha Jayasinghe',
                'author_role' => 'Lead Customs Compliance Advisor',
                'author_avatar' => '/images/ceo.png',
                'date' => '2026-08-12',
                'read_time' => '5 min read',
                'image' => '/images/news_ocean_cargo.png',
                'featured' => false,
                'content' => json_encode([
                    'Bilateral agreements in South Asia offer significant duty exemptions, yet many importers classify cargo incorrectly, paying excessive tariffs.',
                    'This guide simplifies import entry filing processes, explaining how certified brokers fast-track port customs clearings.'
                ]),
                'key_takeaways' => json_encode([
                    'Bilateral codes save up to 12% in duty fees',
                    'Accurate HS code audit prevents holding delays'
                ]),
                'tags' => json_encode(['Customs', 'Tariffs', 'South Asia']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'warehouse-automation-robotics',
                'title' => 'Warehouse Automation: Robotics & Telemetry',
                'excerpt' => 'How 3PL facilities are optimizing pallet fulfillment speeds using automated highbay racking and picking robots.',
                'category' => 'Warehousing',
                'author' => 'Dilshan Mendis',
                'author_role' => 'Warehouse Manager',
                'author_avatar' => '/images/ceo.png',
                'date' => '2026-08-14',
                'read_time' => '6 min read',
                'image' => '/images/news_warehouse_logistics.png',
                'featured' => false,
                'content' => json_encode([
                    'Pallet retrieval speed dictates supply chain performance. High-density highbay racking combined with smart sorting robots ensures rapid fulfillment.',
                    'Our 3PL bonded warehouse now operates with 99.9% inventory accuracy under automated telemetry tracking.'
                ]),
                'key_takeaways' => json_encode([
                    'Automated picking speeds up fulfillment by 50%',
                    'Robotic telemetry prevents inventory mismatch'
                ]),
                'tags' => json_encode(['Warehousing', 'Robotics', 'Fulfillment']),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // 8. Seed events (6 items)
        DB::table('events')->insert([
            [
                'id' => 'logistics-summit-2026',
                'title' => 'Global Logistics & Supply Chain Summit 2026',
                'category' => 'Industry Conference',
                'date' => '2026-09-15',
                'time' => '09:00 AM - 05:00 PM',
                'location' => 'Kingsbury Hotel Grand Ballroom',
                'city' => 'Colombo',
                'image' => '/images/news_ocean_cargo.png',
                'description' => 'An elite conference gathering leading supply chain experts, fleet managers, and customs brokers to discuss post-pandemic maritime routes and regional 4PL innovations.',
                'speakers' => json_encode(['Inosh Perera (CEO, Eagle Logistic)', 'Dr. Alan Mercer (Supply Chain Theorist)']),
                'status' => 'Registration Open',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'customs-clearance-webinar',
                'title' => 'Demystifying Customs Clearance Procedures',
                'category' => 'Virtual Webinar',
                'date' => '2026-10-02',
                'time' => '03:00 PM - 04:30 PM',
                'location' => 'Zoom Video Broadcast',
                'city' => 'Virtual',
                'image' => '/images/news_warehouse_logistics.png',
                'description' => 'A comprehensive online training session covering import/export compliance guidelines, harmonized system codes, and local duty assessment calculations.',
                'speakers' => json_encode(['Samantha Silva (Operations Director)', 'Ravi Perera (Customs Broker)']),
                'status' => 'Registration Open',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'cold-chain-masterclass',
                'title' => 'Cold Chain Excellence Masterclass',
                'category' => 'Training Workshop',
                'date' => '2026-10-20',
                'time' => '10:00 AM - 04:00 PM',
                'location' => 'Eagle Logistic Regional Hub',
                'city' => 'Colombo',
                'image' => '/images/news_air_cargo.png',
                'description' => 'Hands-on workshop covering thermal packaging calibrator setup, GDP audit preparations, and active telemetry sensor monitoring.',
                'speakers' => json_encode(['Samantha Silva (Operations Director)', 'Nilushi Alwis (Client Relations)']),
                'status' => 'Registration Open',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'air-cargo-security-seminar',
                'title' => 'Air Cargo Security & Compliance Seminar',
                'category' => 'Industry Conference',
                'date' => '2026-11-05',
                'time' => '09:00 AM - 01:00 PM',
                'location' => 'Bandaranaike Memorial Conference Hall (BMICH)',
                'city' => 'Colombo',
                'image' => '/images/news_air_cargo.png',
                'description' => 'Discussing IATA security policies, hazardous cargo declarations, and screening procedures at main international airports.',
                'speakers' => json_encode(['Ravi Fernando (Head of Air Cargo)', 'Priyantha Jayasinghe (Lead Customs Advisor)']),
                'status' => 'Registration Open',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'maritime-route-optimization-forum',
                'title' => 'Maritime Trade Route Optimizations Forum',
                'category' => 'Exhibition',
                'date' => '2026-11-18',
                'time' => '02:00 PM - 06:00 PM',
                'location' => 'Port City Exhibition Center',
                'city' => 'Colombo',
                'image' => '/images/news_ocean_cargo.png',
                'description' => 'Showcasing AI route dispatching softwares, green hydrogen shipping vessels, and container port automations.',
                'speakers' => json_encode(['Inosh Perera (CEO, Eagle Logistic)', 'Dilshan Mendis (Warehouse Manager)']),
                'status' => 'Registration Open',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'trainee-operations-open-day',
                'title' => 'Trainee Operations Open Day 2026',
                'category' => 'Training Workshop',
                'date' => '2026-12-05',
                'time' => '10:00 AM - 03:00 PM',
                'location' => 'Eagle Logistic Headquarters',
                'city' => 'Colombo',
                'image' => '/images/news_warehouse_logistics.png',
                'description' => 'A career orientation and recruitment workshop for management trainees interested in regional cargo forwarding operations.',
                'speakers' => json_encode(['Nilushi Alwis (Client Relations)', 'Dilshan Mendis (Warehouse Manager)']),
                'status' => 'Registration Open',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // 9. Seed gallery_items (6 items)
        DB::table('gallery_items')->insert([
            [
                'title' => 'Maritime Fleet Operations',
                'subtitle' => 'High-resolution photographs of our active cargo vessels and port loadings.',
                'images' => json_encode([
                    ['id' => 'm1', 'imageTitle' => 'Ocean Vessel Loading', 'imageUrl' => '/images/news_ocean_cargo.png'],
                    ['id' => 'm2', 'imageTitle' => 'Container Port Crane', 'imageUrl' => '/images/slider_ocean_cargo.png']
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Distribution Hubs & Warehouses',
                'subtitle' => 'Fulfillment and bonded storage operations at our state-of-the-art warehouses.',
                'images' => json_encode([
                    ['id' => 'd1', 'imageTitle' => 'Warehouse Highbay Racks', 'imageUrl' => '/images/news_warehouse_logistics.png'],
                    ['id' => 'd2', 'imageTitle' => 'Forklift Pallet Loading', 'imageUrl' => '/images/slider_warehouse_logistics.png']
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Air Cargo & Charter Flights',
                'subtitle' => 'Visual captures of expedited air cargo handling and airport operations.',
                'images' => json_encode([
                    ['id' => 'a1', 'imageTitle' => 'Freighter Aircraft Loading', 'imageUrl' => '/images/news_air_cargo.png'],
                    ['id' => 'a2', 'imageTitle' => 'Runway Cargo Dispatch', 'imageUrl' => '/images/slider_air_cargo.png']
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Overland Trucking & Ground Fleet',
                'subtitle' => 'Our regional trucking network and FTL transport operations.',
                'images' => json_encode([
                    ['id' => 't1', 'imageTitle' => 'FTL Ground Haulage Truck', 'imageUrl' => '/images/news_warehouse_logistics.png'],
                    ['id' => 't2', 'imageTitle' => 'Cross-Docking Delivery', 'imageUrl' => '/images/slider_warehouse_logistics.png']
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Port Terminal Logistics',
                'subtitle' => 'Operations at container terminals and port security setups.',
                'images' => json_encode([
                    ['id' => 'p1', 'imageTitle' => 'Port Container Storage Yard', 'imageUrl' => '/images/news_ocean_cargo.png'],
                    ['id' => 'p2', 'imageTitle' => 'Vessel Mooring Port Operations', 'imageUrl' => '/images/slider_ocean_cargo.png']
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Cold Chain Telemetry Center',
                'subtitle' => 'Sensory calibrations and WHO compliant active cooling transport processing.',
                'images' => json_encode([
                    ['id' => 'c1', 'imageTitle' => 'Reefer Telemetry Calibration', 'imageUrl' => '/images/news_air_cargo.png'],
                    ['id' => 'c2', 'imageTitle' => 'WHO cold chain storage unit', 'imageUrl' => '/images/slider_air_cargo.png']
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // 10. Seed vacancies (6 items)
        DB::table('vacancies')->insert([
            [
                'id' => 'logistics-planner',
                'title' => 'Senior Logistics Planner',
                'department' => 'Supply Chain Operations',
                'location' => 'Colombo Head Office',
                'type' => 'Full-time',
                'experience' => '3 - 5 Years',
                'description' => 'We are looking for a Senior Logistics Planner to orchestrate container routing, coordinate with maritime cargo alliances, and optimize transport schedules for large commercial clients.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'customs-broker',
                'title' => 'Licensed Customs Broker',
                'department' => 'Compliance & Clearance',
                'location' => 'Katunayake Airport Branch',
                'type' => 'Full-time',
                'experience' => '2+ Years',
                'description' => 'Prepare customs manifest declarations, calculate duty tariffs, and represent clients during customs examinations at main air and sea ports.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'warehouse-coordinator',
                'title' => 'Warehouse Operations Coordinator',
                'department' => 'Fulfillment & Storage',
                'location' => 'Colombo Port Warehouse',
                'type' => 'Full-time',
                'experience' => '1 - 3 Years',
                'description' => 'Orchestrate cargo check-ins, oversee packing lists, manage sorting robots, and ensure prompt FTL cargo dispatches.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'air-freight-specialist',
                'title' => 'Air Freight Operations Specialist',
                'department' => 'Supply Chain Operations',
                'location' => 'Colombo Head Office',
                'type' => 'Full-time',
                'experience' => '2 - 4 Years',
                'description' => 'Manage next-flight-out express bookings, coordinate priority air charter dispatches, and verify hazardous cargo declarations.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'business-dev-executive',
                'title' => 'Business Development Executive (Logistics)',
                'department' => 'Sales & Business Relations',
                'location' => 'Colombo Head Office',
                'type' => 'Full-time',
                'experience' => '2+ Years',
                'description' => 'Secure logistics contracts, pitch 4PL solutions to commercial importers, and negotiate ocean carrier spot freight rates.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'cold-chain-qa',
                'title' => 'Cold Chain Quality Assurance Inspector',
                'department' => 'Compliance & Quality Control',
                'location' => 'Colombo Regional Logistics Hub',
                'type' => 'Full-time',
                'experience' => '3+ Years',
                'description' => 'Ensure cold chain WHO compliance, monitor thermal mapping telemetry sensors, and run quality audits for pharmaceutical shipments.',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // 11. Seed faqs (6 items)
        DB::table('faqs')->insert([
            [
                'question' => 'How do I request a custom freight forwarding quotation?',
                'answer' => 'You can use the \'Get a Quote\' button or contact our sales team at sales@eaglelogistic.com. We require details on cargo dimensions, weight, origin, and destination.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'Do you provide cargo insurance for high-value components?',
                'answer' => 'Yes, we offer comprehensive cargo insurance coverage from point of receipt to point of delivery, shielding against damages, port delays, and maritime emergencies.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'Can you manage temperature-sensitive pharmaceutical shipments?',
                'answer' => 'Absolutely. We have specialized cold-chain logistics protocols with active temperature monitoring for maritime and air shipments, combined with thermal warehouse zones.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'What is the average transit time for ocean freight to Europe?',
                'answer' => 'Average transit time from the Port of Colombo to main European hubs (e.g. Rotterdam, Hamburg) is 18 to 22 days via Suez Canal routes.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'Do you handle dangerous goods (DG) cargo?',
                'answer' => 'Yes, our certified hazardous materials planners manage Class 1-9 dangerous cargo shipments under strict IMO/IMDG sea transit and IATA air security compliance.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'How does real-time telemetry tracking work?',
                'answer' => 'We deploy battery-powered smart sensors inside your container space that send telemetry logs (temperature, humidity, shock, location) directly to our control tower hourly.',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // 12. Seed contact_details
        DB::table('contact_details')->insert([
            'phone' => '+94 115 743 743',
            'email' => 'info@eaglelogistic.com',
            'sales_email' => 'sales@eaglelogistic.com',
            'careers_email' => 'careers@eaglelogistic.com',
            'address' => 'No 281, R. A. De Mel Mawatha, Colombo 03, Sri Lanka.',
            'india_address' => 'Regus Trade Tower, Level 4, Chennai, India.',
            'maldives_address' => 'H. Majeedhi Way, Malé, Maldives.',
            'map_iframe_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.7984670830495!2d79.84976471477284!3d6.914677995003882!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae25942548cd7ef%3A0x6b8eb7c7b2cc89fd!2sRegus%20-%20Colombo%2C%20Sri%20Lanka!5e0!3m2!1sen!2slk!4v1628318900000!5m2!1sen!2slk',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 13. Seed settings
        DB::table('settings')->insert([
            'facebook_page_id' => 'EagleLogistic',
            'facebook_access_token' => 'EAACEdEose0cBA...',
            'website_logo' => '/images/logo.png',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 14. Seed partners (6 items)
        DB::table('partners')->insert([
            [
                'name' => 'Maersk Line',
                'logo_path' => '/images/logo.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'MSC Shipping',
                'logo_path' => '/images/logo.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'CMA CGM',
                'logo_path' => '/images/logo.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Hapag-Lloyd',
                'logo_path' => '/images/logo.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'COSCO Shipping',
                'logo_path' => '/images/logo.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ocean Network Express (ONE)',
                'logo_path' => '/images/logo.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // 15. Seed industries (6 items)
        DB::table('industries')->insert([
            [
                'name' => 'Manufacturing',
                'description' => 'Just-In-Time parts delivery, raw material haulage, and assembly-line logistics.',
                'image' => '/images/about_logistics.png',
                'icon_name' => 'Factory',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Healthcare',
                'description' => 'Temperature-controlled medical logistics, pharma warehousing, and compliance clearing.',
                'image' => '/images/hero_cargo_plane.png',
                'icon_name' => 'HeartPulse',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Retail & Consumer',
                'description' => 'Global retail consolidations, stock distribution management, and peak season options.',
                'image' => '/images/hero_cargo_ship.png',
                'icon_name' => 'ShoppingBag',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Automotive Logistics',
                'description' => 'KD kit shipping, finished vehicle transport, and Tier-1 component integrations.',
                'image' => '/images/hero_cargo_truck.png',
                'icon_name' => 'Car',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Textile & Apparel',
                'description' => 'Fashion speed-to-market shipping, garment-on-hanger ocean freight, and warehousing.',
                'image' => '/images/hero_cargo_warehouse.png',
                'icon_name' => 'Shirt',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'E-Commerce',
                'description' => 'Direct api-to-warehouse integrations, quick bulk imports, and returns processing.',
                'image' => '/images/news_air_cargo.png',
                'icon_name' => 'ShoppingCart',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // 13. Seed testimonials
        DB::table('testimonials')->insert([
            [
                'name' => 'Elena Rostova',
                'role' => 'VP of Global Supply Chain',
                'company' => 'Apex Tech Electronics',
                'feedback' => 'Eagle Logistic has completely transformed our supply chain logistics. Their digital tracking dashboard cut our transit inquiries down to zero, saving our team hours of manual email updates every single week.',
                'rating' => 5,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Marcus Vane',
                'role' => 'Director of Operations',
                'company' => 'BioPharma Allied',
                'feedback' => 'We require strict temperature controls and absolute border compliance for our pharmaceutical consignments. Eagle Logistic cleared our customs at Rotterdam port in record time without any cargo delays.',
                'rating' => 5,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Amina Al-Mansoor',
                'role' => 'Logistics Lead',
                'company' => 'Nova Threads Fashion',
                'feedback' => "During peak retail holidays, vessel space is notoriously tight. Eagle Logistic's multi-carrier ocean freight contracts guaranteed our containers got loaded, keeping our winter collections in stock.",
                'rating' => 5,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jonathan Miller',
                'role' => 'Director of Procurement',
                'company' => 'Stellar Automotive',
                'feedback' => 'Their heavy-haulage capabilities and just-in-time delivery of machinery parts kept our assembly line running without a single minute of downtime. Exceptional service!',
                'rating' => 5,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sophie Dubois',
                'role' => 'Global Logistics Manager',
                'company' => 'Luxe Cosmetics',
                'feedback' => 'WMS tracking and climate-controlled warehousing solutions are top-notch. Our products are fully traceable and handled with extreme care from lab to counter.',
                'rating' => 5,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Rohan de Silva',
                'role' => 'Supply Chain Analyst',
                'company' => 'EcoFood Distributors',
                'feedback' => 'Sustainable transport solutions are crucial for our company branding. Eagle Logistic rail-intermodal network reduced our long-haul emissions by 60% while staying fully on-time.',
                'rating' => 5,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
