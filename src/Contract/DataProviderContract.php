<?php
namespace Bagart\LaravelApiProvider;

use Bagart\LaravelApiProvider\Exceptions;
use Illuminate\Support\Collection;

interface DataProviderContract
{

    public function __construct(ApiClientContract $client_api, DataContainerTypes $data_container_types);

    /**
     * @param string $url
     * @param string $data_type
     * @return Collection|DataContainerContract[]
     * @throws Exceptions\LaravelApiProviderException
     */
    public function request(string $url, string $data_type): Collection;
}
