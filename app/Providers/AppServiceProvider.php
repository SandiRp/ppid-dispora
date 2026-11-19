<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Vite; // <-- Pastikan ini ter-import

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (app()->isProduction() && (str_starts_with(config('app.url', ''), 'https://') || env('FORCE_HTTPS', false))) {
            URL::forceScheme('https');
        }

        // Arahkan Vite secara presisi jika dikonfigurasi melalui .env (misalnya pada shared hosting/cPanel)
        $customManifest = env('VITE_MANIFEST_PATH');
        if ($customManifest && file_exists($customManifest)) {
            Vite::useManifestFilename($customManifest);
        }
    }
}
