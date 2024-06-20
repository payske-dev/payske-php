<?php

namespace Payske;

/**
 * Interface for a Payske client.
 */
interface BasePayskeClientInterface
{
    /**
     * Gets the API key used by the client to send requests.
     *
     * @return null|string the API key used by the client to send requests
     */
    public function getApiKey();

    /**
     * Gets the client ID used by the client in OAuth requests.
     *
     * @return null|string the client ID used by the client in OAuth requests
     */
    public function getClientId();

    /**
     * Gets the base URL for Payske's API.
     *
     * @return string the base URL for Payske's API
     */
    public function getApiBase();

    /**
     * Gets the base URL for Payske's OAuth API.
     *
     * @return string the base URL for Payske's OAuth API
     */
    public function getConnectBase();

    /**
     * Gets the base URL for Payske's Files API.
     *
     * @return string the base URL for Payske's Files API
     */
    public function getFilesBase();
}
