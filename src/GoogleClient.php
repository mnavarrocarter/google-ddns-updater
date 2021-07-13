<?php


namespace MNC\GoogDDNSUpdate;

use Amp\Promise;

/**
 * Interface GoogleClient
 * @package MNC\GoogDDNSUpdate
 */
interface GoogleClient
{
    /**
     * @return Promise<string>
     */
    public function getIp(): Promise;

    /**
     * @param string $ip
     * @return Promise<void>
     */
    public function updateIp(string $ip): Promise;
}