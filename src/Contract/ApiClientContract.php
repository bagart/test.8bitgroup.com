<?php
namespace Bagart\LaravelApiProvider;

use GuzzleHttp\ClientInterface;

interface ApiClientContract
{
    public function __construct(ClientInterface $client);

    /**
     * @param string $url
     * @return array|null
     * @throws Exceptions\LaravelApiProviderException
     */
    public function request(string $url);
}
