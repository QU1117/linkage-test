<?php

namespace App\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use AmoCRM\Client\AmoCRMApiClient;

class AmoCRMClientProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(AmoCRMApiClient::class, function () {
            $apiClient = new AmoCRMApiClient(
                config('services.amocrm.client_id'),
                config('services.amocrm.client_secret'),
                config('services.amocrm.redirect_uri'),
            );
            $apiClient->setAccessToken(config('services.amocrm.access_token'))
                ->setAccountBaseDomain(config('services.amocrm.base_domain'));

            return $apiClient;
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    public function provides(): array
    {
        return [AmoCRMApiClient::class];
    }
}
