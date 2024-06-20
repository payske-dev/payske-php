<?php

// File generated from our OpenAPI spec

namespace Payske\Service;

class BalanceService extends \Payske\Service\AbstractService
{
    /**
     * Retrieves the current account balance, based on the authentication that was used
     * to make the request.  For a sample request, see <a
     * href="/docs/connect/account-balances#accounting-for-negative-balances">Accounting
     * for negative balances</a>.
     *
     * @param null|array $params
     * @param null|array|\Payske\Util\RequestOptions $opts
     *
     * @throws \Payske\Exception\ApiErrorException if the request fails
     *
     * @return \Payske\Balance
     */
    public function retrieve($params = null, $opts = null)
    {
        return $this->request('get', '/api/v1/balance', $params, $opts);
    }
}
