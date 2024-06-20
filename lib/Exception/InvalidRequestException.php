<?php

namespace Payske\Exception;

/**
 * InvalidRequestException is thrown when a request is initiated with invalid
 * parameters.
 */
class InvalidRequestException extends ApiErrorException
{
    protected $PayskeParam;

    /**
     * Creates a new InvalidRequestException exception.
     *
     * @param string $message the exception message
     * @param null|int $httpStatus the HTTP status code
     * @param null|string $httpBody the HTTP body as a string
     * @param null|array $jsonBody the JSON deserialized body
     * @param null|array|\Payske\Util\CaseInsensitiveArray $httpHeaders the HTTP headers array
     * @param null|string $PayskeCode the Payske error code
     * @param null|string $PayskeParam the parameter related to the error
     *
     * @return InvalidRequestException
     */
    public static function factory(
        $message,
        $httpStatus = null,
        $httpBody = null,
        $jsonBody = null,
        $httpHeaders = null,
        $PayskeCode = null,
        $PayskeParam = null
    ) {
        $instance = parent::factory($message, $httpStatus, $httpBody, $jsonBody, $httpHeaders, $PayskeCode);
        $instance->setPayskeParam($PayskeParam);

        return $instance;
    }

    /**
     * Gets the parameter related to the error.
     *
     * @return null|string
     */
    public function getPayskeParam()
    {
        return $this->PayskeParam;
    }

    /**
     * Sets the parameter related to the error.
     *
     * @param null|string $PayskeParam
     */
    public function setPayskeParam($PayskeParam)
    {
        $this->PayskeParam = $PayskeParam;
    }
}
