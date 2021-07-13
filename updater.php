<?php

require_once __DIR__.'/vendor/autoload.php';

use Amp\Http\Client\HttpClientBuilder;
use MNC\GoogDDNSUpdate\AmpGoogleClient;
use MNC\GoogDDNSUpdate\Config;
use MNC\GoogDDNSUpdate\Logger;
use MNC\GoogDDNSUpdate\LoggerGoogleClient;

$client = HttpClientBuilder::buildDefault();
$env = Config::fromEnv();
$logger = Logger::create();
$google = new AmpGoogleClient($client, $env);
$google = new LoggerGoogleClient($google, $logger);

Amp\Loop::repeat($env->getInterval() * 1000, static function () use ($google) {
    $newIp = yield $google->getIp();
    $google->updateIp($newIp);
});

Amp\Loop::run(static function () use ($logger) {
    $logger->log('Daemon has started');
});