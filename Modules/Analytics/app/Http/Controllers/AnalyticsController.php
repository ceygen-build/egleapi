<?php

namespace Modules\Analytics\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Modules\Analytics\Models\SiteVisitor;

class AnalyticsController extends Controller
{
    /**
     * Country name map for common ISO codes
     */
    protected static array $countryNames = [
        'LK' => 'Sri Lanka',
        'US' => 'United States',
        'GB' => 'United Kingdom',
        'CA' => 'Canada',
        'AU' => 'Australia',
        'AE' => 'United Arab Emirates',
        'SG' => 'Singapore',
        'IN' => 'India',
        'DE' => 'Germany',
        'FR' => 'France',
        'IT' => 'Italy',
        'JP' => 'Japan',
        'CN' => 'China',
        'QA' => 'Qatar',
        'SA' => 'Saudi Arabia',
        'MY' => 'Malaysia',
        'MV' => 'Maldives',
        'NZ' => 'New Zealand',
    ];

    /**
     * Record a site visit (public endpoint, non-blocking)
     */
    public function track(Request $request)
    {
        $validated = $request->validate([
            'session_id' => 'nullable|string|max:100',
            'page_url' => 'required|string|max:500',
            'page_title' => 'nullable|string|max:255',
            'referrer' => 'nullable|string|max:500',
            'screen_resolution' => 'nullable|string|max:30',
            'device_type' => 'nullable|string|max:30',
        ]);

        $pageUrl = $validated['page_url'];

        // Ignore admin pages
        if (str_contains($pageUrl, '/admin')) {
            return response()->json(['status' => 'ignored', 'reason' => 'admin_page']);
        }

        $sessionId = $validated['session_id'] ?: 'anon_' . substr(md5($request->ip() . $request->userAgent()), 0, 16);
        $userAgent = $request->userAgent() ?: '';

        // Prevent duplicate logs within 3 seconds for the same session and page
        $cacheKey = 'visit_recent_' . md5($sessionId . '_' . $pageUrl);
        if (Cache::has($cacheKey)) {
            return response()->json(['status' => 'cached']);
        }
        Cache::put($cacheKey, 1, 3);

        // Detect IP
        $ip = $this->resolveClientIp($request);

        // Detect Country & City
        $geo = $this->resolveGeoLocation($ip, $request);

        // Parse User Agent
        $uaInfo = $this->parseUserAgent($userAgent);
        $deviceType = !empty($validated['device_type']) ? strtolower($validated['device_type']) : $uaInfo['device_type'];

        try {
            SiteVisitor::create([
                'session_id' => $sessionId,
                'ip_address' => $ip,
                'country' => $geo['country'],
                'country_code' => strtoupper($geo['country_code']),
                'city' => $geo['city'],
                'region' => $geo['region'],
                'page_url' => $pageUrl,
                'page_title' => $validated['page_title'] ?? null,
                'referrer' => $validated['referrer'] ?? null,
                'device_type' => $deviceType,
                'browser' => $uaInfo['browser'],
                'os' => $uaInfo['os'],
                'screen_resolution' => $validated['screen_resolution'] ?? null,
                'user_agent' => substr($userAgent, 0, 500),
            ]);

            return response()->json(['status' => 'success']);
        } catch (\Throwable $e) {
            // Fail silently on public tracking so website rendering is never disrupted
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Get aggregated analytics for the admin dashboard
     */
    public function getAnalytics(Request $request)
    {
        $period = $request->query('period', '7d'); // today, 7d, 30d, all

        $now = Carbon::now();
        $startDate = match ($period) {
            'today' => Carbon::today(),
            '30d' => Carbon::now()->subDays(29)->startOfDay(),
            'all' => Carbon::createFromTimestamp(0),
            default => Carbon::now()->subDays(6)->startOfDay(), // 7d default
        };

        $baseQuery = SiteVisitor::query();
        if ($period !== 'all') {
            $baseQuery->where('created_at', '>=', $startDate);
        }

        $totalViews = (clone $baseQuery)->count();
        $uniqueVisitors = (clone $baseQuery)->distinct('session_id')->count('session_id');

        $todayViews = SiteVisitor::whereDate('created_at', Carbon::today())->count();
        $todayUniques = SiteVisitor::whereDate('created_at', Carbon::today())->distinct('session_id')->count('session_id');

        // Top Country
        $topCountryRow = (clone $baseQuery)
            ->select('country', 'country_code', DB::raw('COUNT(*) as total'))
            ->groupBy('country', 'country_code')
            ->orderByDesc('total')
            ->first();

        // Top City
        $topCityRow = (clone $baseQuery)
            ->where('city', '!=', 'Unknown')
            ->whereNotNull('city')
            ->select('city', 'country', DB::raw('COUNT(*) as total'))
            ->groupBy('city', 'country')
            ->orderByDesc('total')
            ->first();

        // Top Device
        $topDeviceRow = (clone $baseQuery)
            ->select('device_type', DB::raw('COUNT(*) as total'))
            ->groupBy('device_type')
            ->orderByDesc('total')
            ->first();

        // Summary Cards
        $summary = [
            'total_views' => $totalViews,
            'unique_visitors' => $uniqueVisitors,
            'today_views' => $todayViews,
            'today_uniques' => $todayUniques,
            'top_country' => $topCountryRow ? [
                'country' => $topCountryRow->country,
                'country_code' => $topCountryRow->country_code,
                'count' => (int) $topCountryRow->total,
                'percentage' => $totalViews > 0 ? round(($topCountryRow->total / $totalViews) * 100, 1) : 0,
            ] : null,
            'top_city' => $topCityRow ? [
                'city' => $topCityRow->city,
                'country' => $topCityRow->country,
                'count' => (int) $topCityRow->total,
            ] : null,
            'top_device' => $topDeviceRow ? [
                'device_type' => ucfirst($topDeviceRow->device_type),
                'count' => (int) $topDeviceRow->total,
                'percentage' => $totalViews > 0 ? round(($topDeviceRow->total / $totalViews) * 100, 1) : 0,
            ] : null,
        ];

        // Chart Data (Continuous Timeline)
        $chartData = $this->buildChartTimeline($period, $startDate, $now);

        // Top Countries (up to 8)
        $topCountries = (clone $baseQuery)
            ->select('country', 'country_code', DB::raw('COUNT(*) as total'), DB::raw('COUNT(DISTINCT session_id) as uniques'))
            ->groupBy('country', 'country_code')
            ->orderByDesc('total')
            ->limit(8)
            ->get()
            ->map(function ($row) use ($totalViews) {
                return [
                    'country' => $row->country,
                    'country_code' => $row->country_code,
                    'views' => (int) $row->total,
                    'uniques' => (int) $row->uniques,
                    'percentage' => $totalViews > 0 ? round(($row->total / $totalViews) * 100, 1) : 0,
                ];
            });

        // Top Cities (up to 8)
        $topCities = (clone $baseQuery)
            ->where('city', '!=', 'Unknown')
            ->whereNotNull('city')
            ->select('city', 'country', 'country_code', DB::raw('COUNT(*) as total'))
            ->groupBy('city', 'country', 'country_code')
            ->orderByDesc('total')
            ->limit(8)
            ->get()
            ->map(function ($row) use ($totalViews) {
                return [
                    'city' => $row->city,
                    'country' => $row->country,
                    'country_code' => $row->country_code,
                    'count' => (int) $row->total,
                    'percentage' => $totalViews > 0 ? round(($row->total / $totalViews) * 100, 1) : 0,
                ];
            });

        // Top Pages (up to 10)
        $topPages = (clone $baseQuery)
            ->select('page_url', 'page_title', DB::raw('COUNT(*) as total'), DB::raw('COUNT(DISTINCT session_id) as uniques'))
            ->groupBy('page_url', 'page_title')
            ->orderByDesc('total')
            ->limit(10)
            ->get()
            ->map(function ($row) use ($totalViews) {
                return [
                    'page_url' => $row->page_url,
                    'page_title' => $row->page_title ?: $row->page_url,
                    'views' => (int) $row->total,
                    'uniques' => (int) $row->uniques,
                    'percentage' => $totalViews > 0 ? round(($row->total / $totalViews) * 100, 1) : 0,
                ];
            });

        // Device Breakdown
        $devices = (clone $baseQuery)
            ->select('device_type', DB::raw('COUNT(*) as total'))
            ->groupBy('device_type')
            ->orderByDesc('total')
            ->get()
            ->map(function ($row) use ($totalViews) {
                return [
                    'name' => ucfirst($row->device_type ?: 'Desktop'),
                    'count' => (int) $row->total,
                    'percentage' => $totalViews > 0 ? round(($row->total / $totalViews) * 100, 1) : 0,
                ];
            });

        // Browser Breakdown
        $browsers = (clone $baseQuery)
            ->select('browser', DB::raw('COUNT(*) as total'))
            ->groupBy('browser')
            ->orderByDesc('total')
            ->limit(6)
            ->get()
            ->map(function ($row) use ($totalViews) {
                return [
                    'name' => $row->browser ?: 'Other',
                    'count' => (int) $row->total,
                    'percentage' => $totalViews > 0 ? round(($row->total / $totalViews) * 100, 1) : 0,
                ];
            });

        // OS Breakdown
        $osList = (clone $baseQuery)
            ->select('os', DB::raw('COUNT(*) as total'))
            ->groupBy('os')
            ->orderByDesc('total')
            ->limit(6)
            ->get()
            ->map(function ($row) use ($totalViews) {
                return [
                    'name' => $row->os ?: 'Other',
                    'count' => (int) $row->total,
                    'percentage' => $totalViews > 0 ? round(($row->total / $totalViews) * 100, 1) : 0,
                ];
            });

        $payload = [
            'status' => 'success',
            'period' => $period,
            'summary' => $summary,
            'chart_data' => $chartData,
            'top_countries' => $topCountries,
            'top_cities' => $topCities,
            'top_pages' => $topPages,
            'devices' => $devices,
            'browsers' => $browsers,
            'os' => $osList,
        ];
        $payload['data'] = $payload;

        return response()->json($payload);
    }

    /**
     * Get paginated visitor log entries
     */
    public function getLogs(Request $request)
    {
        $perPage = min((int) $request->query('per_page', 15), 100);
        $search = trim((string) $request->query('search', ''));
        $country = trim((string) $request->query('country', ''));
        $device = trim((string) $request->query('device', ''));

        $query = SiteVisitor::query()->latest();

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('ip_address', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('country', 'like', "%{$search}%")
                  ->orWhere('page_url', 'like', "%{$search}%")
                  ->orWhere('page_title', 'like', "%{$search}%")
                  ->orWhere('browser', 'like', "%{$search}%")
                  ->orWhere('os', 'like', "%{$search}%");
            });
        }

        if ($country !== '' && $country !== 'all') {
            $query->where('country_code', strtoupper($country));
        }

        if ($device !== '' && $device !== 'all') {
            $query->where('device_type', strtolower($device));
        }

        $logs = $query->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => $logs->items(),
            'current_page' => $logs->currentPage(),
            'last_page' => $logs->lastPage(),
            'per_page' => $logs->perPage(),
            'total' => $logs->total(),
        ]);
    }

    /**
     * Clear visitor logs
     */
    public function clearLogs(Request $request)
    {
        SiteVisitor::truncate();

        return response()->json([
            'status' => 'success',
            'message' => 'Visitor logs have been cleared successfully.',
        ]);
    }

    /**
     * Build continuous timeline for charts
     */
    protected function buildChartTimeline(string $period, Carbon $startDate, Carbon $now): array
    {
        if ($period === 'today') {
            // Hourly buckets for today (00:00 to current hour)
            $hourlyData = SiteVisitor::whereDate('created_at', Carbon::today())
                ->select(
                    DB::raw('HOUR(created_at) as hour_num'),
                    DB::raw('COUNT(*) as views'),
                    DB::raw('COUNT(DISTINCT session_id) as uniques')
                )
                ->groupBy('hour_num')
                ->get()
                ->keyBy('hour_num');

            $result = [];
            $currentHour = (int) $now->format('G');
            for ($h = 0; $h <= $currentHour; $h++) {
                $hourStr = str_pad((string) $h, 2, '0', STR_PAD_LEFT) . ':00';
                $row = $hourlyData->get($h);
                $result[] = [
                    'date' => $now->format('Y-m-d') . ' ' . $hourStr,
                    'label' => $hourStr,
                    'views' => $row ? (int) $row->views : 0,
                    'uniques' => $row ? (int) $row->uniques : 0,
                ];
            }
            return $result;
        }

        // Daily buckets
        $numDays = match ($period) {
            '30d' => 30,
            'all' => 30,
            default => 7,
        };

        $dailyStats = SiteVisitor::where('created_at', '>=', $now->copy()->subDays($numDays - 1)->startOfDay())
            ->select(
                DB::raw('DATE(created_at) as visit_date'),
                DB::raw('COUNT(*) as views'),
                DB::raw('COUNT(DISTINCT session_id) as uniques')
            )
            ->groupBy('visit_date')
            ->get()
            ->keyBy('visit_date');

        $result = [];
        for ($i = $numDays - 1; $i >= 0; $i--) {
            $day = $now->copy()->subDays($i);
            $dayKey = $day->format('Y-m-d');
            $row = $dailyStats->get($dayKey);

            $result[] = [
                'date' => $dayKey,
                'label' => $day->format('M d'),
                'views' => $row ? (int) $row->views : 0,
                'uniques' => $row ? (int) $row->uniques : 0,
            ];
        }

        return $result;
    }

    /**
     * Resolve client IP from request and proxy headers
     */
    protected function resolveClientIp(Request $request): string
    {
        $headers = [
            'cf-connecting-ip',
            'x-real-ip',
            'x-forwarded-for',
        ];

        foreach ($headers as $header) {
            $val = $request->header($header);
            if ($val) {
                // Handle comma-separated list in X-Forwarded-For
                $parts = explode(',', $val);
                $ip = trim($parts[0]);
                if (filter_var($ip, FILTER_VALIDATE_IP)) {
                    return $ip;
                }
            }
        }

        return $request->ip() ?: '127.0.0.1';
    }

    /**
     * Resolve Geo-Location (Country, City, Region)
     */
    protected function resolveGeoLocation(string $ip, Request $request): array
    {
        // 1. Check Cloudflare headers first
        $cfCountry = $request->header('cf-ipcountry');
        $cfCity = $request->header('cf-ipcity');
        $cfRegion = $request->header('cf-region');

        if (!empty($cfCountry) && strlen($cfCountry) === 2 && strtoupper($cfCountry) !== 'XX') {
            $code = strtoupper($cfCountry);
            $name = self::$countryNames[$code] ?? $code;
            return [
                'country' => $name,
                'country_code' => $code,
                'city' => !empty($cfCity) ? urldecode($cfCity) : 'Unknown',
                'region' => !empty($cfRegion) ? urldecode($cfRegion) : null,
            ];
        }

        // 2. Local / Private IPs: provide realistic default for local development
        $isLocal = in_array($ip, ['127.0.0.1', '::1', 'localhost'])
            || str_starts_with($ip, '192.168.')
            || str_starts_with($ip, '10.')
            || str_starts_with($ip, '172.');

        if ($isLocal) {
            return [
                'country' => 'Sri Lanka',
                'country_code' => 'LK',
                'city' => 'Colombo',
                'region' => 'Western Province',
            ];
        }

        // 3. Public IP: Lookup via ip-api.com with 24-hour cache
        $cacheKey = 'ip_geo_v1_' . md5($ip);
        return Cache::remember($cacheKey, 86400, function () use ($ip) {
            try {
                $response = Http::timeout(1.5)->get("http://ip-api.com/json/{$ip}?fields=status,country,countryCode,regionName,city");
                if ($response->successful()) {
                    $data = $response->json();
                    if (($data['status'] ?? '') === 'success') {
                        return [
                            'country' => $data['country'] ?? 'Unknown',
                            'country_code' => strtoupper($data['countryCode'] ?? 'XX'),
                            'city' => $data['city'] ?? 'Unknown',
                            'region' => $data['regionName'] ?? null,
                        ];
                    }
                }
            } catch (\Throwable $e) {
                // Silently fallback on timeout/network issue
            }

            return [
                'country' => 'Unknown',
                'country_code' => 'XX',
                'city' => 'Unknown',
                'region' => null,
            ];
        });
    }

    /**
     * Parse User Agent into Device, Browser, and OS
     */
    protected function parseUserAgent(string $ua): array
    {
        $deviceType = 'desktop';
        if (preg_match('/(tablet|ipad|playbook|silk)|(android(?!.*mobi))/i', $ua)) {
            $deviceType = 'tablet';
        } elseif (preg_match('/(mobi|iphone|ipod|blackberry|opera mini|iemobile|mobile)/i', $ua)) {
            $deviceType = 'mobile';
        }

        // Browser
        $browser = 'Other';
        if (preg_match('/edg/i', $ua)) {
            $browser = 'Edge';
        } elseif (preg_match('/opr|opera/i', $ua)) {
            $browser = 'Opera';
        } elseif (preg_match('/samsungbrowser/i', $ua)) {
            $browser = 'Samsung Internet';
        } elseif (preg_match('/chrome|crios/i', $ua)) {
            $browser = 'Chrome';
        } elseif (preg_match('/firefox|fxios/i', $ua)) {
            $browser = 'Firefox';
        } elseif (preg_match('/safari/i', $ua)) {
            $browser = 'Safari';
        }

        // OS
        $os = 'Other';
        if (preg_match('/windows nt 10/i', $ua)) {
            $os = 'Windows 10/11';
        } elseif (preg_match('/windows/i', $ua)) {
            $os = 'Windows';
        } elseif (preg_match('/android/i', $ua)) {
            $os = 'Android';
        } elseif (preg_match('/iphone|ipad|ipod/i', $ua)) {
            $os = 'iOS';
        } elseif (preg_match('/macintosh|mac os x/i', $ua)) {
            $os = 'macOS';
        } elseif (preg_match('/linux/i', $ua)) {
            $os = 'Linux';
        }

        return [
            'device_type' => $deviceType,
            'browser' => $browser,
            'os' => $os,
        ];
    }
}
