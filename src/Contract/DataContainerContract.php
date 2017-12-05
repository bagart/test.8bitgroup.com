<?php
namespace Bagart\LaravelApiProvider;

interface DataContainerContract
{
    public function fill(array $attr);

    public function toArray(): array;
}
