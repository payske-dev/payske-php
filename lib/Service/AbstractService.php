<?php

namespace Payske\Service;

/**
 * Abstract base class for all services.
 */
abstract class AbstractService
{
    /**
     * @var \Payske\PayskeClientInterface
     */
    protected $client;

    /**
     * @var \Payske\PayskeStreamingClientInterface
     */
    protected $streamingClient;

    /**
     * Initializes a new instance of the {@link AbstractService} class.
     *
     * @param \Payske\PayskeClientInterface $client
     */
    public function __construct($client)
    {
        $this->client = $client;
        $this->streamingClient = $client;
    }

    /**
     * Gets the client used by this service to send requests.
     *
     * @return \Payske\PayskeClientInterface
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Gets the client used by this service to send requests.
     *
     * @return \Payske\PayskeStreamingClientInterface
     */
    public function getStreamingClient()
    {
        return $this->streamingClient;
    }

    /**
     * Translate null values to empty strings. For service methods,
     * we interpret null as a request to unset the field, which
     * corresponds to sending an empty string for the field to the
     * API.
     *
     * @param null|array $params
     */
    private static function formatParams($params)
    {
        if (null === $params) {
            return null;
        }
        \array_walk_recursive($params, function (&$value, $key) {
            if (null === $value) {
                $value = '';
            }
        });

        return $params;
    }

    protected function request($method, $path, $params, $opts)
    {
        return $this->getClient()->request($method, $path, static::formatParams($params), $opts);
    }

    protected function requestStream($method, $path, $readBodyChunkCallable, $params, $opts)
    {
        return $this->getStreamingClient()->requestStream($method, $path, $readBodyChunkCallable, static::formatParams($params), $opts);
    }

    protected function requestCollection($method, $path, $params, $opts)
    {
        return $this->getClient()->requestCollection($method, $path, static::formatParams($params), $opts);
    }

    protected function buildPath($basePath, ...$ids)
    {
        foreach ($ids as $id) {
            if (null === $id || '' === \trim($id)) {
                $msg = 'The resource ID cannot be null or whitespace.';

                throw new \Payske\Exception\InvalidArgumentException($msg);
            }
        }

        return \sprintf($basePath, ...\array_map('\urlencode', $ids));
    }
}
