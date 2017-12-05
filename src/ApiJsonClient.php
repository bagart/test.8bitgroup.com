<?php
namespace Bagart\LaravelApiProvider;

use Bagart\LaravelApiProvider\Exceptions;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
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

    /**
     * @param $url
     * @return ResponseInterface|Response
     * @throws Exceptions\LaravelApiProviderException
     */
    protected function getResponseByUrl(string $url): ResponseInterface
    {
        try {
            return $this->client->request('GET', $url);
        } catch (GuzzleException $e) {
            throw new Exceptions\RequestException('request filed: ' . $e->getMessage());
        }
    }

    /**
     * @param ResponseInterface $response
     * @throws Exceptions\LaravelApiProviderException
     */
    protected function checkResponse(ResponseInterface $response): void
    {
        if ($response->getStatusCode() !== 200) {
            throw new Exceptions\ResponseException("Status Code: {$response->getStatusCode()} is not acceptable");
        }

        assert(preg_match('~application/json\b~iu', $response->getHeaderLine('content-type')));
    }

    /**
     * @param ResponseInterface $response
     * @return array|null
     * @throws Exceptions\LaravelApiProviderException
     */
    protected function getData(ResponseInterface $response)
    {
        try {
            $result = \GuzzleHttp\json_decode($response->getBody(), true);
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

    /**
     * @param string $url
     * @return array|null
     * @throws Exceptions\LaravelApiProviderException
     */
    public function request(string $url)
    {
        $response = $this->getResponseByUrl($url);
        $this->checkResponse($response);

        return $this->getData($response);
    }
}
