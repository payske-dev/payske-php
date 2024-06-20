<?php

// File generated from our OpenAPI spec

namespace Payske\Service;

class ReviewService extends \Payske\Service\AbstractService
{
    /**
     * Returns a list of <code>Review</code> objects that have <code>open</code> set to
     * <code>true</code>. The objects are sorted in descending order by creation date,
     * with the most recently created object appearing first.
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
        return $this->requestCollection('get', '/api/v1/reviews', $params, $opts);
    }

    /**
     * Approves a <code>Review</code> object, closing it and removing it from the list
     * of reviews.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Payske\Util\RequestOptions $opts
     *
     * @throws \Payske\Exception\ApiErrorException if the request fails
     *
     * @return \Payske\Review
     */
    public function approve($id, $params = null, $opts = null)
    {
        return $this->request('post', $this->buildPath('/api/v1/reviews/%s/approve', $id), $params, $opts);
    }

    /**
     * Retrieves a <code>Review</code> object.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Payske\Util\RequestOptions $opts
     *
     * @throws \Payske\Exception\ApiErrorException if the request fails
     *
     * @return \Payske\Review
     */
    public function retrieve($id, $params = null, $opts = null)
    {
        return $this->request('get', $this->buildPath('/api/v1/reviews/%s', $id), $params, $opts);
    }
}
