<?php

namespace Payske\ApiOperations;

/**
 * Trait for retrievable resources. Adds a `retrieve()` static method to the
 * class.
 *
 * This trait should only be applied to classes that derive from PayskeObject.
 */
trait Retrieve
{
    /**
     * @param array|string $id the ID of the API resource to retrieve,
     *     or an options array containing an `id` key
     * @param null|array|string $opts
     *
     * @throws \Payske\Exception\ApiErrorException if the request fails
     *
     * @return static
     */
    public static function retrieve($id, $opts = null)
    {
        $opts = \Payske\Util\RequestOptions::parse($opts);
        $instance = new static($id, $opts);
        $instance->refresh();

        return $instance;
    }
}
