<?php


namespace MNC\GoogDDNSUpdate;

use Amp\Http\Client\HttpClient;
use Amp\Http\Client\Request;
use Amp\Http\Client\Response;
use Amp\Promise;
use function Amp\call;

/**
 * Class AmpGoogleClient
 * @package MNC\GoogDDNSUpdate
 */
class AmpGoogleClient implements GoogleClient
{
    private HttpClient $client;
    private Config $env;

    /**
     * AmpGoogleClient constructor.
     * @param HttpClient $client
     * @param Config $env
     */
    public function __construct(HttpClient $client, Config $env)
    {
        $this->client = $client;
        $this->env = $env;
    }

    /**
     * @return Promise
     */
    public function getIp(): Promise
    {
        return call(function () {
            /** @var Response $response */
            $response = yield $this->client->request(new Request('https://domains.google.com/checkip'));
            return $response->getBody()->buffer();
        });
    }

    /**
     * @param string $ip
     * @return Promise
     */
    public function updateIp(string $ip): Promise
    {
        return call(function () use ($ip) {
            $request = new Request(sprintf(
                'https://domains.google.com/nic/update?hostname=%s&myip=%s',
                $this->env->getHostname(),
                $ip
            ));
            $request->addHeader('Authorization', 'Basic '. $this->env->getAuthorization());
            /** @var Response $response */
            yield $this->client->request($request);
        });
    }
}