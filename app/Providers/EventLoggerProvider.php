<?php

namespace App\Providers;

use App\Services\EventLogger;
use Illuminate\Support\ServiceProvider;

class EventLoggerProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(EventLogger::class, function () {
            return new EventLogger();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
