<?php

namespace App\Providers;

use AmoCRM\OAuth2\Client\Provider\AmoCRMException;
use App\Services\EventLogger;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use AmoCRM\Client\AmoCRMApiClient;
use League\OAuth2\Client\Token\AccessToken;

class AmoCRMClientProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(AmoCRMApiClient::class, function ($app) {
            try {
                $apiClient = new AmoCRMApiClient(
                    config('services.amocrm.client_id'),
                    config('services.amocrm.client_secret'),
                    config('services.amocrm.redirect_uri'),
                );
                $accessToken = new AccessToken([
                    'access_token' => config('services.amocrm.access_token'),
                    'refresh_token' => config('services.amocrm.refresh_token'),
                    'expires_in' => env('AMOCRM_EXPIRES'),
                ]);

                $apiClient->setAccessToken($accessToken)
                    ->setAccountBaseDomain(config('services.amocrm.base_domain'));
            } catch (AmoCRMException $exception) {
                Eventlogger::log('AmoCRM Client Error', 'AmoCRM client error while initializing in service provider',
                    $exception->getMessage());
            }

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
}
