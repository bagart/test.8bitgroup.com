<?php
namespace Bagart\LaravelApiProvider;

use Bagart\LaravelApiProvider\DataContainers\Location;
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
        $this->app->singleton(DataContainerTypes::class, function ($app) {
            return new DataContainerTypes;
        });

        $this->app->bind(ApiJsonClient::class, function ($app) {
            return new ApiJsonClient(
                app(Client::class)
            );
        });

        $this->app->bind(DataProvider::class, function ($app) {
            return new DataProvider(
                app(ApiJsonClient::class),
                app(DataContainerTypes::class)
            );
        });

        /**
         * @var DataProvider $data_provider
         */
        $data_provider = app(DataProvider::class);
        dd($data_provider->request('http://dockerhost/example.json', 'locations'));
    }
}
