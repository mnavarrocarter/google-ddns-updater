<?php


namespace MNC\GoogDDNSUpdate;

use Amp\ByteStream\ClosedException;
use Amp\ByteStream\OutputStream;
use Amp\ByteStream\ResourceOutputStream;
use Amp\ByteStream\StreamException;
use Amp\Promise;
use JsonException;
use RuntimeException;

/**
 * Class Logger
 * @package MNC\GoogDDNSUpdate
 */
class Logger
{
    private OutputStream $stream;

    /**
     * @return Logger
     */
    public static function create(): Logger
    {
        return new self(new ResourceOutputStream(fopen('php://stdout', 'wb')));
    }

    /**
     * Logger constructor.
     * @param OutputStream $stream
     */
    public function __construct(OutputStream $stream)
    {
        $this->stream = $stream;
    }

    /**
     * @param string $message
     * @param array $ctx
     * @return Promise
     * @throws ClosedException
     * @throws StreamException
     */
    public function log(string $message, array $ctx = []): Promise
    {
        $ctx['message'] = $message;
        $ctx['timestamp'] = time();
        $ctx['pid'] = getmypid();
        $ctx['hostname'] = gethostname();
        try {
            $string = json_encode($ctx, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new RuntimeException('Could not format log entry into json', 0, $e);
        }
        return $this->stream->write($string.PHP_EOL);
    }
}