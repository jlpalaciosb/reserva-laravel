<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;
use Illuminate\Routing\UrlGenerator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (env('REDIRECT_HTTPS')) {
            Log::info('register con esquema https');
            $this->app['request']->server->set('HTTPS', true);
        } else {
            Log::info('register sin esquema https');
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(UrlGenerator $url)
    {
        if (env('REDIRECT_HTTPS')) {
            Log::info('boot con esquema https');
            $url->formatScheme('https://');
        } else {
            Log::info('sin esquema https');
        }
    }
}
