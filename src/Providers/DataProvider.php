<?php
namespace Bagart\LaravelApiProvider\Providers;

use Bagart\LaravelApiProvider\ApiClientContract;
use Bagart\LaravelApiProvider\DataContainerContract;
use Bagart\LaravelApiProvider\DataContainers\Location;
use Bagart\LaravelApiProvider\Exceptions;
use Bagart\LaravelApiProvider\DataProviderContract;
use Illuminate\Support\Collection;

class DataProvider implements DataProviderContract
{
    private $client_api;

    public function __construct(ApiClientContract $client_api)
    {
        $this->client_api = $client_api;
    }

    /**
     * @todo request empty logic and API empty format
     * @param $data
     * @throws Exceptions\ResponseException
     */
    public function checkApiData($data): void
    {
        if (!$data || !is_array($data) || !is_array(current($data))) {
            throw new Exceptions\ResponseException('API response: no data');
        }
        if (empty(current($data)['name'])) {
            throw new Exceptions\ResponseException('API response: wrong format - no name in first location');
        }
    }

    /**
     * @param string $url
     * @param string $data_container_class
     * @return Collection|DataContainerContract[]
     * @throws Exceptions\LaravelApiProviderException
     */
    public function request($url, $data_container_class): Collection
    {
        $data = $this->client_api->request($url);
        $this->checkApiData($data);

        $collection = new Collection();

        foreach ($data as $locationArr) {
            $location = app($data_container_class);
            $location->fill($locationArr);
            $collection->push($location);
        }

        return $collection;
    }
}
