<?php
namespace Bagart\LaravelApiProvider;

use Bagart\LaravelApiProvider\DataContainers\Location;
use Bagart\LaravelApiProvider\Exceptions\LaravelApiProviderException;

class DataContainerTypes
{
    /**
     * @var DataContainerContract[]
     */
    private $data_containers_by_type = [
        'locations' => Location::class,
    ];


    public function addType(string $type, string $class): void
    {
        $this->data_containers_by_type[$type] = $class;
    }

    /**
     * @param string $type
     * @return string
     * @throws LaravelApiProviderException
     */
    public function getDataContainerNameByType(string $type): string
    {
        if (empty($this->data_containers_by_type[$type])) {
            throw new LaravelApiProviderException("type of data container is not defined: $type");
        }

        return $this->data_containers_by_type[$type];
    }

    /**
     * @param string $type
     * @return DataContainerContract
     * @throws LaravelApiProviderException
     */
    public function getInstanceByType(string $type): DataContainerContract
    {
        $class_name = $this->getDataContainerNameByType($type);

        return app($class_name);
    }
}
