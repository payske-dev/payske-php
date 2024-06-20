<?php

// File generated from our OpenAPI spec

namespace Payske\Service;

class TaxCodeService extends \Payske\Service\AbstractService
{
    /**
     * A list of <a href="https://docs.payske.com/docs/tax/tax-codes">all tax codes
     * available</a> to add to Products in order to allow specific tax calculations.
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
        return $this->requestCollection('get', '/api/v1/tax_codes', $params, $opts);
    }

    /**
     * Retrieves the details of an existing tax code. Supply the unique tax code ID and
     * Payske will return the corresponding tax code information.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\Payske\Util\RequestOptions $opts
     *
     * @throws \Payske\Exception\ApiErrorException if the request fails
     *
     * @return \Payske\TaxCode
     */
    public function retrieve($id, $params = null, $opts = null)
    {
        return $this->request('get', $this->buildPath('/api/v1/tax_codes/%s', $id), $params, $opts);
    }
}
