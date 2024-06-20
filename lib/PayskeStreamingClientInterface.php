<?php

namespace Payske;

/**
 * Interface for a Payske client.
 */
interface PayskeStreamingClientInterface extends BasePayskeClientInterface
{
    public function requestStream($method, $path, $readBodyChunkCallable, $params, $opts);
}
