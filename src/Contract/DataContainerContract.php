<?php
namespace Bagart\LaravelApiLocation;

interface DataContainerContract
{
    public function fill(array $attr);

    public function toArray(): array;
}
