<?php

namespace Payske;

/**
 * Helper trait for Payske test cases.
 */
trait TestHelper
{
    /** @var null|string original API base URL */
    protected $origApiBase;

    /** @var null|string original API key */
    protected $origApiKey;

    /** @var null|string original client ID */
    protected $origClientId;

    /** @var null|string original API version */
    protected $origApiVersion;

    /** @var null|string original account ID */
    protected $origAccountId;

    /** @var \PHPUnit_Framework_MockObject_MockObject HTTP client mocker */
    protected $clientMock;

    /** @var \PHPUnit_Framework_MockObject_MockObject HTTP client mocker */
    protected $streamingClientMock;

    /** @before */
    protected function setUpConfig()
    {
        // Save original values so that we can restore them after running tests
        $this->origApiBase = Payske::$apiBase;
        $this->origApiKey = Payske::getApiKey();
        $this->origClientId = Payske::getClientId();
        $this->origApiVersion = Payske::getApiVersion();
        $this->origAccountId = Payske::getAccountId();

        // Set up host and credentials for Payske-mock
        Payske::$apiBase = \defined('MOCK_URL') ? MOCK_URL : 'http://localhost:12111';
        Payske::$apiUploadBase = \defined('MOCK_URL') ? MOCK_URL : 'http://localhost:12111';
        Payske::setApiKey('sk_test_123');
        Payske::setClientId('ca_123');
        Payske::setApiVersion(null);
        Payske::setAccountId(null);

        // Set up the HTTP client mocker
        $this->clientMock = $this->createMock('\Payske\HttpClient\ClientInterface');
        $this->streamingClientMock = $this->createMock('\Payske\HttpClient\StreamingClientInterface');

        // By default, use the real HTTP client
        ApiRequestor::setHttpClient(HttpClient\CurlClient::instance());
        ApiRequestor::setStreamingHttpClient(HttpClient\CurlClient::instance());
    }

    /** @after */
    protected function tearDownConfig()
    {
        // Restore original values
        Payske::$apiBase = $this->origApiBase;
        Payske::setEnableTelemetry(false);
        Payske::setApiKey($this->origApiKey);
        Payske::setClientId($this->origClientId);
        Payske::setApiVersion($this->origApiVersion);
        Payske::setAccountId($this->origAccountId);
    }

    /**
     * Sets up a request expectation with the provided parameters. The request
     * will actually go through and be emitted.
     *
     * @param string $method HTTP method (e.g. 'post', 'get', etc.)
     * @param string $path relative path (e.g. '/api/v1/charges')
     * @param null|array $params array of parameters. If null, parameters will
     *   not be checked.
     * @param null|string[] $headers array of headers. Does not need to be
     *   exhaustive. If null, headers are not checked.
     * @param bool $hasFile Whether the request parameters contains a file.
     *   Defaults to false.
     * @param null|string $base base URL (e.g. 'https://api.payske.com')
     */
    protected function expectsRequest(
        $method,
        $path,
        $params = null,
        $headers = null,
        $hasFile = false,
        $base = null
    ) {
        ApiRequestor::setHttpClient($this->clientMock);
        $this->prepareRequestMock($method, $path, $params, $headers, $hasFile, $base)
            ->willReturnCallback(
                function ($method, $absUrl, $headers, $params, $hasFile) {
                    $curlClient = HttpClient\CurlClient::instance();
                    ApiRequestor::setHttpClient($curlClient);

                    return $curlClient->request($method, $absUrl, $headers, $params, $hasFile);
                }
            );
    }

    /**
     * Sets up a request expectation with the provided parameters. The request
     * will actually go through and be emitted.
     *
     * @param string $method HTTP method (e.g. 'post', 'get', etc.)
     * @param string $path relative path (e.g. '/api/v1/charges')
     * @param null|array $params array of parameters. If null, parameters will
     *   not be checked.
     * @param null|string[] $headers array of headers. Does not need to be
     *   exhaustive. If null, headers are not checked.
     * @param bool $hasFile Whether the request parameters contains a file.
     *   Defaults to false.
     * @param null|string $base base URL (e.g. 'https://api.payske.com')
     */
    protected function expectsRequestStream(
        $method,
        $path,
        $params = null,
        $headers = null,
        $hasFile = false,
        $base = null
    ) {
        ApiRequestor::setStreamingHttpClient($this->streamingClientMock);
        $this->prepareRequestStreamMock($method, $path, $params, $headers, $hasFile, $base)
            ->willReturnCallback(
                function ($method, $absUrl, $readBodyChunkCallable, $headers, $params, $hasFile) {
                    $curlClient = HttpClient\CurlClient::instance();
                    ApiRequestor::setStreamingHttpClient($curlClient);

                    return $curlClient->requestStream($method, $absUrl, $readBodyChunkCallable, $headers, $params, $hasFile);
                }
            );
    }

    /**
     * Sets up a request expectation with the provided parameters. The request
     * will not actually be emitted, instead the provided response parameters
     * will be returned.
     *
     * @param string $method HTTP method (e.g. 'post', 'get', etc.)
     * @param string $path relative path (e.g. '/api/v1/charges')
     * @param null|array $params array of parameters. If null, parameters will
     *   not be checked.
     * @param null|string[] $headers array of headers. Does not need to be
     *   exhaustive. If null, headers are not checked.
     * @param bool $hasFile Whether the request parameters contains a file.
     *   Defaults to false.
     * @param array $response
     * @param int $rcode
     * @param null|string $base
     *
     * @return array
     */
    protected function stubRequest(
        $method,
        $path,
        $params = null,
        $headers = null,
        $hasFile = false,
        $response = [],
        $rcode = 200,
        $base = null
    ) {
        $this->prepareRequestMock($method, $path, $params, $headers, $hasFile, $base)
            ->willReturn([\json_encode($response), $rcode, []]);
    }

    /**
     * Prepares the client mocker for an invocation of the `request` method.
     * This helper method is used by both `expectsRequest` and `stubRequest` to
     * prepare the client mocker to expect an invocation of the `request` method
     * with the provided arguments.
     *
     * @param string $method HTTP method (e.g. 'post', 'get', etc.)
     * @param string $path relative path (e.g. '/api/v1/charges')
     * @param null|array $params array of parameters. If null, parameters will
     *   not be checked.
     * @param null|string[] $headers array of headers. Does not need to be
     *   exhaustive. If null, headers are not checked.
     * @param bool $hasFile Whether the request parameters contains a file.
     *   Defaults to false.
     * @param null|string $base base URL (e.g. 'https://api.payske.com')
     *
     * @return \PHPUnit_Framework_MockObject_Builder_InvocationMocker
     */
    private function prepareRequestMock(
        $method,
        $path,
        $params = null,
        $headers = null,
        $hasFile = false,
        $base = null
    ) {
        ApiRequestor::setHttpClient($this->clientMock);

        if (null === $base) {
            $base = Payske::$apiBase;
        }
        $absUrl = $base . $path;

        return $this->clientMock
            ->expects(static::once())
            ->method('request')
            ->with(
                static::identicalTo(\strtolower($method)),
                static::identicalTo($absUrl),
                // for headers, we only check that all of the headers provided in $headers are
                // present in the list of headers of the actual request
                null === $headers ? static::anything() : static::callback(function ($array) use ($headers) {
                    foreach ($headers as $header) {
                        if (!\in_array($header, $array, true)) {
                            return false;
                        }
                    }

                    return true;
                }),
                null === $params ? static::anything() : static::identicalTo($params),
                static::identicalTo($hasFile)
            );
    }

    /**
     * Prepares the client mocker for an invocation of the `request` method.
     * This helper method is used by both `expectsRequest` and `stubRequest` to
     * prepare the client mocker to expect an invocation of the `request` method
     * with the provided arguments.
     *
     * @param string $method HTTP method (e.g. 'post', 'get', etc.)
     * @param string $path relative path (e.g. '/api/v1/charges')
     * @param null|array $params array of parameters. If null, parameters will
     *   not be checked.
     * @param null|string[] $headers array of headers. Does not need to be
     *   exhaustive. If null, headers are not checked.
     * @param bool $hasFile Whether the request parameters contains a file.
     *   Defaults to false.
     * @param null|string $base base URL (e.g. 'https://api.payske.com')
     * @param string $requestMethod name of the method on httpclient to mock - 'request' or 'requestStream'
     *
     * @return \PHPUnit_Framework_MockObject_Builder_InvocationMocker
     */
    private function prepareRequestStreamMock(
        $method,
        $path,
        $params = null,
        $headers = null,
        $hasFile = false,
        $base = null
    ) {
        ApiRequestor::setStreamingHttpClient($this->streamingClientMock);
        if (null === $base) {
            $base = Payske::$apiBase;
        }
        $absUrl = $base . $path;

        return $this->streamingClientMock
            ->expects(static::once())
            ->method('requestStream')
            ->with(
                static::identicalTo(\strtolower($method)),
                static::identicalTo($absUrl),
                // for headers, we only check that all of the headers provided in $headers are
                // present in the list of headers of the actual request
                null === $headers ? static::anything() : static::callback(function ($array) use ($headers) {
                    foreach ($headers as $header) {
                        if (!\in_array($header, $array, true)) {
                            return false;
                        }
                    }

                    return true;
                }),
                null === $params ? static::anything() : static::identicalTo($params),
                static::identicalTo($hasFile),
                static::anything()
            );
    }
}
