<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

// SocialiteProviders event class name
use SocialiteProviders\Manager\SocialiteWasCalled;

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
        // Register SocialiteProviders Microsoft listener so the provider is available
        // when using the Socialite 'microsoft' driver.
        Event::listen(
            SocialiteWasCalled::class,
            'SocialiteProviders\\Microsoft\\MicrosoftExtendSocialite@handle'
        );
    }
}
