<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        try {
            if (\Schema::hasTable('settings')) {
                $settings = \DB::table('settings')->first();
                if ($settings) {
                    config([
                        'app.frontend_url' => $settings->website_url ?? 'https://eaglelogistic.com'
                    ]);
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
                }
            }
        } catch (\Exception $e) {
            // Ignore failure before table exists or during migrations
        }
    }
}
