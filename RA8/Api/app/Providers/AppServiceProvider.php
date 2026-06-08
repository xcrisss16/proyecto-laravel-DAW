<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        URL::forceRootUrl('https://cautious-space-enigma-7vqxp7qppj6vhxpvx-8000.app.github.dev');
        URL::forceScheme('https');
    }
}