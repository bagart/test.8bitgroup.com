<?php
namespace Bagart\LaravelApiProvider;

interface DataContainerContract
{
    public function fill(array $attr): void;

    public function toArray(): array;
}
