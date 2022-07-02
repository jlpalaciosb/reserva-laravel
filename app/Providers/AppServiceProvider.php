<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
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
        if (App::environment('production')) {
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
        if (App::environment('production')) {
            Log::info('boot con esquema https');
            // URL::forceScheme('https');
            $url->formatScheme('https://');
        } else {
            Log::info('sin esquema https');
        }
    }
}
