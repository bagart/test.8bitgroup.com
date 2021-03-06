<?php
namespace Bagart\LaravelApiProvider\DataContainers;

use Bagart\LaravelApiProvider\DataContainerContract;

class Location implements DataContainerContract
{
    public $name;
    public $lat;
    public $long;

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'coordinates' => [
                'lat' => $this->lat,
                'long' => $this->long,
            ]
        ];
    }

    public function fill(array $attr): void
    {
        if (isset($attr['name'])) {
            $this->name = $attr['name'];
        }

        if (isset($attr['coordinates']['lat'])) {
            $this->lat = $attr['coordinates']['lat'];
        }

        if (isset($attr['coordinates']['long'])) {
            $this->long = $attr['coordinates']['long'];
        }
    }
}
