<?php

// File generated from our OpenAPI spec

namespace Payske\Service;

class TopupService extends \Payske\Service\AbstractService
{
    /**
     * Returns a list of top-ups.
     *
     * @param null|array $params
     * @param null|array|\Payske\Util\RequestOptions $opts
     *
     * @throws \Payske\Exception\ApiErrorException if the request fails
     *
     * @return \Payske\Collection
     */
    public function all($params = null, $opts = null)
    {
        return $this->requestCollection('get', '/api/v1/topups', $params, $opts);
    }

    /**
     * Cancels a top-up. Only pending top-ups can be canceled.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Payske\Util\RequestOptions $opts
     *
     * @throws \Payske\Exception\ApiErrorException if the request fails
     *
     * @return \Payske\Topup
     */
    public function cancel($id, $params = null, $opts = null)
    {
        return $this->request('post', $this->buildPath('/api/v1/topups/%s/cancel', $id), $params, $opts);
    }

    /**
     * Top up the balance of an account.
     *
     * @param null|array $params
     * @param null|array|\Payske\Util\RequestOptions $opts
     *
     * @throws \Payske\Exception\ApiErrorException if the request fails
     *
     * @return \Payske\Topup
     */
    public function create($params = null, $opts = null)
    {
        return $this->request('post', '/api/v1/topups', $params, $opts);
    }

    /**
     * Retrieves the details of a top-up that has previously been created. Supply the
     * unique top-up ID that was returned from your previous request, and Payske will
     * return the corresponding top-up information.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Payske\Util\RequestOptions $opts
     *
     * @throws \Payske\Exception\ApiErrorException if the request fails
     *
     * @return \Payske\Topup
     */
    public function retrieve($id, $params = null, $opts = null)
    {
        return $this->request('get', $this->buildPath('/api/v1/topups/%s', $id), $params, $opts);
    }

    /**
     * Updates the metadata of a top-up. Other top-up details are not editable by
     * design.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Payske\Util\RequestOptions $opts
     *
     * @throws \Payske\Exception\ApiErrorException if the request fails
     *
     * @return \Payske\Topup
     */
    public function update($id, $params = null, $opts = null)
    {
        return $this->request('post', $this->buildPath('/api/v1/topups/%s', $id), $params, $opts);
    }
}
