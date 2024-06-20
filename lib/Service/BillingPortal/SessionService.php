<?php

// File generated from our OpenAPI spec

namespace Payske\Service\BillingPortal;

class SessionService extends \Payske\Service\AbstractService
{
    /**
     * Creates a session of the customer portal.
     *
     * @param null|array $params
     * @param null|array|\Payske\Util\RequestOptions $opts
     *
     * @throws \Payske\Exception\ApiErrorException if the request fails
     *
     * @return \Payske\BillingPortal\Session
     */
    public function create($params = null, $opts = null)
    {
        return $this->request('post', '/api/v1/billing_portal/sessions', $params, $opts);
    }
}
