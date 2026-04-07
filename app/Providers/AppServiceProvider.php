<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

if (! function_exists('csp_nonce')) {
    function csp_nonce(): ?string
    {
        return app()->has('csp-nonce') ? app('csp-nonce') : null;
    }
}

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}