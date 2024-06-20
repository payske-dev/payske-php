<?php

// File generated from our OpenAPI spec

namespace Payske\Service;

class AccountLinkService extends \Payske\Service\AbstractService
{
    /**
     * Creates an AccountLink object that includes a single-use Payske URL that the
     * platform can redirect their user to in order to take them through the Connect
     * Onboarding flow.
     *
     * @param null|array $params
     * @param null|array|\Payske\Util\RequestOptions $opts
     *
     * @throws \Payske\Exception\ApiErrorException if the request fails
     *
     * @return \Payske\AccountLink
     */
    public function create($params = null, $opts = null)
    {
        return $this->request('post', '/api/v1/account_links', $params, $opts);
    }
}
