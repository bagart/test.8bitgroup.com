<?php
namespace Bagart\LaravelApiLocation;

use Bagart\LaravelApiLocation\Exceptions;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class ApiJsonClient implements ApiClientContract
{
    /**
     * @var ClientInterface
     */
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    protected function getResponseByUrl($url): ResponseInterface
    {
        try {
            return $this->client->request('GET', $url);
        } catch (GuzzleException $e) {
            throw new Exceptions\RequestException('request filed: ' . $e->getMessage());
        }
    }

    protected function checkResponse(ResponseInterface $response): void
    {
        if ($response->getStatusCode() !== 200) {
            throw new Exceptions\ResponseException("Status Code: {$response->getStatusCode()} is not acceptable");
        }

        assert(preg_match('~application/json\b~iu', $response->getHeaderLine('content-type')));
    }

    protected function getData(ResponseInterface $response)
    {
        try {
            $result = \GuzzleHttp\json_decode($response->getBody());
        } catch (\InvalidArgumentException $e) {
            throw new Exceptions\ResponseException('response: JSON parse error');
        }

        if (empty($result['success'])) {
            throw new Exceptions\ApiException(
                ($result['data']['message'] ?? 'unknown api error')
                . (isset($result['data']['code']) ? ' with CODE: '. $result['data']['code'] : null)
            );
        }

        return $result['data'] ?? null;
    }

    public function request($url)
    {
        $response = $this->getResponseByUrl($url);
        $response->checkResponse($response);

        return $response->getData($response);
    }
}
