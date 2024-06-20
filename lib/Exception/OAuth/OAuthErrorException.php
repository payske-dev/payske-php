<?php

namespace Payske\Exception\OAuth;

/**
 * Implements properties and methods common to all (non-SPL) Payske OAuth
 * exceptions.
 */
abstract class OAuthErrorException extends \Payske\Exception\ApiErrorException
{
    protected function constructErrorObject()
    {
        if (null === $this->jsonBody) {
            return null;
        }

        return \Payske\OAuthErrorObject::constructFrom($this->jsonBody);
    }
}
