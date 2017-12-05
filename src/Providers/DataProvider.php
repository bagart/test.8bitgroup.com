<?php
namespace Bagart\LaravelApiProvider\Providers;

use Bagart\LaravelApiProvider\ApiClientContract;
use Bagart\LaravelApiProvider\DataContainerContract;
use Bagart\LaravelApiProvider\DataContainerTypes;
use Bagart\LaravelApiProvider\Exceptions;
use Bagart\LaravelApiProvider\DataProviderContract;
use Illuminate\Support\Collection;

class DataProvider implements DataProviderContract
{
    private $client_api;
    private $data_container_types;

    public function __construct(ApiClientContract $client_api, DataContainerTypes $data_container_types)
    {
        $this->client_api = $client_api;
        $this->data_container_types = $data_container_types;
    }

    /**
     * @todo request empty logic and API empty format
     * @param array|null $data
     * @throws Exceptions\LaravelApiProviderException
     */
    protected function checkApiData($data, string $data_type): void
    {
        if (!$data || !is_array($data) || !is_array(current($data))) {
            throw new Exceptions\ResponseException('API response: no data');
        }
        if (!isset($data[$data_type])) {
            throw new Exceptions\ResponseException("no data '{$data_type}' type in response");
        }
    }

    /**
     * @param string $url
     * @param string $data_type
     * @return Collection|DataContainerContract[]
     * @throws Exceptions\LaravelApiProviderException
     */
    public function request(string $url, string $data_type): Collection
    {
        $data = $this->client_api->request($url);

        $this->checkApiData($data, $data_type);

        return $this->getCollectionFromExternalFormat($data, $data_type);
    }

    /**
     * @param array $data
     * @param string $data_type
     * @return Collection|DataContainerContract[]
     * @throws Exceptions\LaravelApiProviderException
     */
    protected function getCollectionFromExternalFormat(array $data, string $data_type): Collection
    {
        /**
         * @var DataContainerTypes $data_container_types
         */
        $collection = new Collection();

        foreach ($data[$data_type] as $dcArr) {
            $data_container = $this->data_container_types->getInstanceByType($data_type);
            $data_container->fill($dcArr);
            $collection->push($data_container);
        }

        return $collection;
    }
}
