<?php


namespace MNC\GoogDDNSUpdate;

use Amp\Promise;
use function Amp\call;

/**
 * Class LoggerGoogleClient
 * @package MNC\GoogDDNSUpdate
 */
final class LoggerGoogleClient implements GoogleClient
{
    private GoogleClient $client;
    private Logger $logger;
    private string $ip;

    /**
     * LoggerGoogleClient constructor.
     * @param GoogleClient $client
     * @param Logger $logger
     */
    public function __construct(GoogleClient $client, Logger $logger)
    {
        $this->client = $client;
        $this->logger = $logger;
        $this->ip = '';
    }

    /**
     * @return Promise
     */
    public function getIp(): Promise
    {
        return call(function () {
            $this->logger->log('Determining ip address');
            $ip = yield $this->client->getIp();
            $this->logger->log('Ip address has been determined', [
                'ip' => $ip
            ]);
            return $ip;
        });
    }

    /**
     * @param string $ip
     * @return Promise
     */
    public function updateIp(string $ip): Promise
    {
        return call(function () use ($ip) {
            if ($this->ip === $ip) {
                $this->logger->log('Ip address has not changed. Skipping update...');
                return;
            }
            $this->logger->log('Updating ip address');
            yield $this->client->updateIp($ip);
            $this->ip = $ip;
            $this->logger->log('Ip address has been updated', [
                'newIp' => $ip
            ]);
        });
    }
}