<?php

namespace Payske;

/**
 * Interface for a Payske client.
 */
interface PayskeClientInterface extends BasePayskeClientInterface
{
    /**
     * Sends a request to Payske's API.
     *
     * @param string $method the HTTP method
     * @param string $path the path of the request
     * @param array $params the parameters of the request
     * @param array|\Payske\Util\RequestOptions $opts the special modifiers of the request
     *
     * @return \Payske\PayskeObject the object returned by Payske's API
     */
    public function request($method, $path, $params, $opts);
}
