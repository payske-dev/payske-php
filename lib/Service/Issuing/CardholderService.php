<?php

// File generated from our OpenAPI spec

namespace Payske\Service\Issuing;

class CardholderService extends \Payske\Service\AbstractService
{
    /**
     * Returns a list of Issuing <code>Cardholder</code> objects. The objects are
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
        return $this->requestCollection('get', '/api/v1/issuing/cardholders', $params, $opts);
    }

    /**
     * Creates a new Issuing <code>Cardholder</code> object that can be issued cards.
     *
     * @param null|array $params
     * @param null|array|\Payske\Util\RequestOptions $opts
     *
     * @throws \Payske\Exception\ApiErrorException if the request fails
     *
     * @return \Payske\Issuing\Cardholder
     */
    public function create($params = null, $opts = null)
    {
        return $this->request('post', '/api/v1/issuing/cardholders', $params, $opts);
    }

    /**
     * Retrieves an Issuing <code>Cardholder</code> object.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Payske\Util\RequestOptions $opts
     *
     * @throws \Payske\Exception\ApiErrorException if the request fails
     *
     * @return \Payske\Issuing\Cardholder
     */
    public function retrieve($id, $params = null, $opts = null)
    {
        return $this->request('get', $this->buildPath('/api/v1/issuing/cardholders/%s', $id), $params, $opts);
    }

    /**
     * Updates the specified Issuing <code>Cardholder</code> object by setting the
     * values of the parameters passed. Any parameters not provided will be left
     * unchanged.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Payske\Util\RequestOptions $opts
     *
     * @throws \Payske\Exception\ApiErrorException if the request fails
     *
     * @return \Payske\Issuing\Cardholder
     */
    public function update($id, $params = null, $opts = null)
    {
        return $this->request('post', $this->buildPath('/api/v1/issuing/cardholders/%s', $id), $params, $opts);
    }
}
