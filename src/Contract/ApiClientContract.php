<?php
namespace Bagart\LaravelApiLocation;

use GuzzleHttp\ClientInterface;

interface ApiClientContract
{
    public function __construct(ClientInterface $client);

    /**
     * @param $url
     * @return *
     * @throws \Bagart\LaravelApiLocation\Exceptions\LaravelApiLocationException
    */
    public function request($url);
}
