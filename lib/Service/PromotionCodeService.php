<?php

// File generated from our OpenAPI spec

namespace Payske\Service;

class PromotionCodeService extends \Payske\Service\AbstractService
{
    /**
     * Returns a list of your promotion codes.
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
        return $this->requestCollection('get', '/api/v1/promotion_codes', $params, $opts);
    }

    /**
     * A promotion code points to a coupon. You can optionally restrict the code to a
     * specific customer, redemption limit, and expiration date.
     *
     * @param null|array $params
     * @param null|array|\Payske\Util\RequestOptions $opts
     *
     * @throws \Payske\Exception\ApiErrorException if the request fails
     *
     * @return \Payske\PromotionCode
     */
    public function create($params = null, $opts = null)
    {
        return $this->request('post', '/api/v1/promotion_codes', $params, $opts);
    }

    /**
     * Retrieves the promotion code with the given ID.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Payske\Util\RequestOptions $opts
     *
     * @throws \Payske\Exception\ApiErrorException if the request fails
     *
     * @return \Payske\PromotionCode
     */
    public function retrieve($id, $params = null, $opts = null)
    {
        return $this->request('get', $this->buildPath('/api/v1/promotion_codes/%s', $id), $params, $opts);
    }

    /**
     * Updates the specified promotion code by setting the values of the parameters
     * passed. Most fields are, by design, not editable.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Payske\Util\RequestOptions $opts
     *
     * @throws \Payske\Exception\ApiErrorException if the request fails
     *
     * @return \Payske\PromotionCode
     */
    public function update($id, $params = null, $opts = null)
    {
        return $this->request('post', $this->buildPath('/api/v1/promotion_codes/%s', $id), $params, $opts);
    }
}
