<?php

// File generated from our OpenAPI spec

namespace Payske\Service\Radar;

class ValueListService extends \Payske\Service\AbstractService
{
    /**
     * Returns a list of <code>ValueList</code> objects. The objects are sorted in
     * descending order by creation date, with the most recently created object
     * appearing first.
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
        return $this->requestCollection('get', '/api/v1/radar/value_lists', $params, $opts);
    }

    /**
     * Creates a new <code>ValueList</code> object, which can then be referenced in
     * rules.
     *
     * @param null|array $params
     * @param null|array|\Payske\Util\RequestOptions $opts
     *
     * @throws \Payske\Exception\ApiErrorException if the request fails
     *
     * @return \Payske\Radar\ValueList
     */
    public function create($params = null, $opts = null)
    {
        return $this->request('post', '/api/v1/radar/value_lists', $params, $opts);
    }

    /**
     * Deletes a <code>ValueList</code> object, also deleting any items contained
     * within the value list. To be deleted, a value list must not be referenced in any
     * rules.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Payske\Util\RequestOptions $opts
     *
     * @throws \Payske\Exception\ApiErrorException if the request fails
     *
     * @return \Payske\Radar\ValueList
     */
    public function delete($id, $params = null, $opts = null)
    {
        return $this->request('delete', $this->buildPath('/api/v1/radar/value_lists/%s', $id), $params, $opts);
    }

    /**
     * Retrieves a <code>ValueList</code> object.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Payske\Util\RequestOptions $opts
     *
     * @throws \Payske\Exception\ApiErrorException if the request fails
     *
     * @return \Payske\Radar\ValueList
     */
    public function retrieve($id, $params = null, $opts = null)
    {
        return $this->request('get', $this->buildPath('/api/v1/radar/value_lists/%s', $id), $params, $opts);
    }

    /**
     * Updates a <code>ValueList</code> object by setting the values of the parameters
     * passed. Any parameters not provided will be left unchanged. Note that
     * <code>item_type</code> is immutable.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Payske\Util\RequestOptions $opts
     *
     * @throws \Payske\Exception\ApiErrorException if the request fails
     *
     * @return \Payske\Radar\ValueList
     */
    public function update($id, $params = null, $opts = null)
    {
        return $this->request('post', $this->buildPath('/api/v1/radar/value_lists/%s', $id), $params, $opts);
    }
}
