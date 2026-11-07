<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AboutTimelineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing timeline milestones
        DB::table('about_timeline')->truncate();

        DB::table('about_timeline')->insert([
            [
                'year' => '2011',
                'title' => 'Company Founded',
                'description' => 'Eagle Logistic was established with a small regional office in Colombo, offering primary freight consolidation and local dispatch services.',
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'year' => '2015',
                'title' => 'Air Freight Expansion',
                'description' => 'Launched dedicated air freight routing and digital customs clearance services, securing direct contracts with major commercial airlines.',
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'year' => '2018',
                'title' => 'Asia-Pacific Node',
                'description' => 'Opened our first international corporate branch in Singapore, expanding our freight forwarding capacity across critical maritime corridors.',
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'year' => '2022',
                'title' => 'Smart IoT Cargo Telemetry',
                'description' => 'Integrated advanced IoT tracking devices and custom customer portal APIs, giving cargo owners high-fidelity, real-time telemetry.',
                'sort_order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'year' => '2025',
                'title' => 'Carbon-Offset & Paperless Milestones',
                'description' => 'Achieved 100% paperless customs documentation and launched a green logistics corridor offsetting over 25,000 metric tons of transport emissions.',
                'sort_order' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
