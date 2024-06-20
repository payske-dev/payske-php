<?php

// File generated from our OpenAPI spec

namespace Payske\Service\Terminal;

class ConnectionTokenService extends \Payske\Service\AbstractService
{
    /**
     * To connect to a reader the Payske Terminal SDK needs to retrieve a short-lived
     * connection token from Payske, proxied through your server. On your backend, add
     * an endpoint that creates and returns a connection token.
     *
     * @param null|array $params
     * @param null|array|\Payske\Util\RequestOptions $opts
     *
     * @throws \Payske\Exception\ApiErrorException if the request fails
     *
     * @return \Payske\Terminal\ConnectionToken
     */
    public function create($params = null, $opts = null)
    {
        return $this->request('post', '/api/v1/terminal/connection_tokens', $params, $opts);
    }
}
