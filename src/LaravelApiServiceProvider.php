<?php
namespace Bagart\LaravelApiProvider;

use Bagart\LaravelApiProvider\Providers\DataProvider;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class LaravelApiServiceProvider extends ServiceProvider
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
