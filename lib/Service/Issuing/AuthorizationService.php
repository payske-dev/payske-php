<?php

// File generated from our OpenAPI spec

namespace Payske\Service\Issuing;

class AuthorizationService extends \Payske\Service\AbstractService
{
    /**
     * Returns a list of Issuing <code>Authorization</code> objects. The objects are
     * sorted in descending order by creation date, with the most recently created
     * object appearing first.
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
        return $this->requestCollection('get', '/api/v1/issuing/authorizations', $params, $opts);
    }

    /**
     * Approves a pending Issuing <code>Authorization</code> object. This request
     * should be made within the timeout window of the <a
     * href="/docs/issuing/controls/real-time-authorizations">real-time
     * authorization</a> flow.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Payske\Util\RequestOptions $opts
     *
     * @throws \Payske\Exception\ApiErrorException if the request fails
     *
     * @return \Payske\Issuing\Authorization
     */
    public function approve($id, $params = null, $opts = null)
    {
        return $this->request('post', $this->buildPath('/api/v1/issuing/authorizations/%s/approve', $id), $params, $opts);
    }

    /**
     * Declines a pending Issuing <code>Authorization</code> object. This request
     * should be made within the timeout window of the <a
     * href="/docs/issuing/controls/real-time-authorizations">real time
     * authorization</a> flow.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Payske\Util\RequestOptions $opts
     *
     * @throws \Payske\Exception\ApiErrorException if the request fails
     *
     * @return \Payske\Issuing\Authorization
     */
    public function decline($id, $params = null, $opts = null)
    {
        return $this->request('post', $this->buildPath('/api/v1/issuing/authorizations/%s/decline', $id), $params, $opts);
    }

    /**
     * Retrieves an Issuing <code>Authorization</code> object.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Payske\Util\RequestOptions $opts
     *
     * @throws \Payske\Exception\ApiErrorException if the request fails
     *
     * @return \Payske\Issuing\Authorization
     */
    public function retrieve($id, $params = null, $opts = null)
    {
        return $this->request('get', $this->buildPath('/api/v1/issuing/authorizations/%s', $id), $params, $opts);
    }

    /**
     * Updates the specified Issuing <code>Authorization</code> object by setting the
     * values of the parameters passed. Any parameters not provided will be left
     * unchanged.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Payske\Util\RequestOptions $opts
     *
     * @throws \Payske\Exception\ApiErrorException if the request fails
     *
     * @return \Payske\Issuing\Authorization
     */
    public function update($id, $params = null, $opts = null)
    {
        return $this->request('post', $this->buildPath('/api/v1/issuing/authorizations/%s', $id), $params, $opts);
    }
}
