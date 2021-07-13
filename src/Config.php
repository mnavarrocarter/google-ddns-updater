<?php


namespace MNC\GoogDDNSUpdate;

/**
 * Class Env
 * @package MNC\GoogDDNSUpdate
 */
class Config
{
    private string $hostname;
    private string $username;
    private string $password;
    private int $interval;

    /**
     * @return Config
     */
    public static function fromEnv(): Config
    {
        $hostname = getenv('GOOGLE_DDNS_HOSTNAME');
        $username = getenv('GOOGLE_DDNS_USERNAME');
        $password = getenv('GOOGLE_DDNS_PASSWORD');
        $interval = getenv('GOOGLE_DDNS_INTERVAL');

        if (!is_string($interval) || $interval === '') {
            $interval = '30';
        }

        if (!is_string($hostname) || $hostname === '') {
            exit('GOOGLE_DDNS_HOSTNAME environment variable is required');
        }
        if (!is_string($username) || $username === '') {
            exit('GOOGLE_DDNS_USERNAME environment variable is required');
        }
        if (!is_string($password) || $password === '') {
            exit('GOOGLE_DDNS_PASSWORD environment variable is required');
        }
        return new self($hostname, $username, $password, (int) $interval);
    }

    /**
     * Env constructor.
     * @param string $hostname
     * @param string $username
     * @param string $password
     * @param int $interval
     */
    public function __construct(string $hostname, string $username, string $password, int $interval)
    {
        $this->hostname = $hostname;
        $this->username = $username;
        $this->password = $password;
        $this->interval = $interval;
    }

    /**
     * @return int
     */
    public function getInterval(): int
    {
        return $this->interval;
    }

    /**
     * @return string
     */
    public function getHostname(): string
    {
        return $this->hostname;
    }

    /**
     * @return string
     */
    public function getAuthorization(): string
    {
        return base64_encode($this->username.':'.$this->password);
    }
}