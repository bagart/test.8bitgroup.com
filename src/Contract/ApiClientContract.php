<?php
namespace Bagart\LaravelApiProvider;

use GuzzleHttp\ClientInterface;

interface ApiClientContract
{
    public function __construct(ClientInterface $client);

    /**
     * @param $url
     * @return *
     * @throws \Bagart\LaravelApiProvider\Exceptions\LaravelApiProviderException
    */
    public function request($url);
}
