<?php
namespace Bagart\LaravelApiProvider;

use Bagart\LaravelApiProvider\Exceptions;
use Illuminate\Support\Collection;

interface DataProviderContract
{
    public function __construct(ApiClientContract $client_api);

    /**
     * @param string $url
     * @param string $data_container_class
     * @return Collection|DataContainerContract[]
     * @throws Exceptions\LaravelApiProviderException
     */
    public function request($url, $data_container_class): Collection;
}
