<?php
namespace Bagart\LaravelApiLocation;

use Bagart\LaravelApiLocation\Exceptions;
use Illuminate\Support\Collection;

interface DataProviderContract
{
    public function __construct(ApiJsonContract $client_api);

    /**
     * @param string $url
     * @param string $data_container_class
     * @return Collection|DataContainerContract[]
     * @throws Exceptions\LaravelApiLocationException
     */
    public function request($url, $data_container_class): Collection;
}
