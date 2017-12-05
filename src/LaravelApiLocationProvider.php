<?php
namespace Bagart\LaravelApiLocation;

use Bagart\LaravelApiLocation\Providers\DataProvider;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class LaravelApiLocationProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ApiJsonClient::class, function ($app) {
            return new ApiJsonClient(
                app(Client::class)
            );
        });

        $this->app->bind(DataProvider::class, function ($app) {
            return new DataProvider(
                app(ApiJsonClient::class)
            );
        });
    }
}
