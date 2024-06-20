<?php

namespace Payske;

class BasePayskeClient implements PayskeClientInterface, PayskeStreamingClientInterface
{
    /** @var string default base URL for Payske's API */
    const DEFAULT_API_BASE = 'https://api.payske.com';

    /** @var string default base URL for Payske's OAuth API */
    const DEFAULT_CONNECT_BASE = '';

    /** @var string default base URL for Payske's Files API */
    const DEFAULT_FILES_BASE = '';

    /** @var array<string, mixed> */
    private $config;

    /** @var \Payske\Util\RequestOptions */
    private $defaultOpts;

    /**
     * Initializes a new instance of the {@link BasePayskeClient} class.
     *
     * The constructor takes a single argument. The argument can be a string, in which case it
     * should be the API key. It can also be an array with various configuration settings.
     *
     * Configuration settings include the following options:
     *
     * - api_key (null|string): the Payske API key, to be used in regular API requests.
     * - client_id (null|string): the Payske client ID, to be used in OAuth requests.
     * - Payske_account (null|string): a Payske account ID. If set, all requests sent by the client
     *   will automatically use the {@code Payske-Account} header with that account ID.
     * - Payske_version (null|string): a Payske API verion. If set, all requests sent by the client
     *   will include the {@code Payske-Version} header with that API version.
     *
     * The following configuration settings are also available, though setting these should rarely be necessary
     * (only useful if you want to send requests to a mock server like Payske-mock):
     *
     * - api_base (string): the base URL for regular API requests. Defaults to
     *   {@link DEFAULT_API_BASE}.
     * - connect_base (string): the base URL for OAuth requests. Defaults to
     *   {@link DEFAULT_CONNECT_BASE}.
     * - files_base (string): the base URL for file creation requests. Defaults to
     *   {@link DEFAULT_FILES_BASE}.
     *
     * @param array<string, mixed>|string $config the API key as a string, or an array containing
     *   the client configuration settings
     */
    public function __construct($config = [])
    {
        if (\is_string($config)) {
            $config = ['api_key' => $config];
        } elseif (!\is_array($config)) {
            throw new \Payske\Exception\InvalidArgumentException('$config must be a string or an array');
        }

        $config = \array_merge($this->getDefaultConfig(), $config);
        $this->validateConfig($config);

        $this->config = $config;

        $this->defaultOpts = \Payske\Util\RequestOptions::parse([
            'Payske_account' => $config['Payske_account'],
            'Payske_version' => $config['Payske_version'],
        ]);
    }

    /**
     * Gets the API key used by the client to send requests.
     *
     * @return null|string the API key used by the client to send requests
     */
    public function getApiKey()
    {
        return $this->config['api_key'];
    }

    /**
     * Gets the client ID used by the client in OAuth requests.
     *
     * @return null|string the client ID used by the client in OAuth requests
     */
    public function getClientId()
    {
        return $this->config['client_id'];
    }

    /**
     * Gets the base URL for Payske's API.
     *
     * @return string the base URL for Payske's API
     */
    public function getApiBase()
    {
        return $this->config['api_base'];
    }

    /**
     * Gets the base URL for Payske's OAuth API.
     *
     * @return string the base URL for Payske's OAuth API
     */
    public function getConnectBase()
    {
        return $this->config['connect_base'];
    }

    /**
     * Gets the base URL for Payske's Files API.
     *
     * @return string the base URL for Payske's Files API
     */
    public function getFilesBase()
    {
        return $this->config['files_base'];
    }

    /**
     * Sends a request to Payske's API.
     *
     * @param string $method the HTTP method
     * @param string $path the path of the request
     * @param array $params the parameters of the request
     * @param array|\Payske\Util\RequestOptions $opts the special modifiers of the request
     *
     * @return \Payske\PayskeObject the object returned by Payske's API
     */
    public function request($method, $path, $params, $opts)
    {
        $opts = $this->defaultOpts->merge($opts, true);
        $baseUrl = $opts->apiBase ?: $this->getApiBase();
        $requestor = new \Payske\ApiRequestor($this->apiKeyForRequest($opts), $baseUrl);
        list($response, $opts->apiKey) = $requestor->request($method, $path, $params, $opts->headers);
        $opts->discardNonPersistentHeaders();
        $obj = \Payske\Util\Util::convertToPayskeObject($response->json, $opts);
        $obj->setLastResponse($response);

        return $obj;
    }

    /**
     * Sends a request to Payske's API, passing chunks of the streamed response
     * into a user-provided $readBodyChunkCallable callback.
     *
     * @param string $method the HTTP method
     * @param string $path the path of the request
     * @param callable $readBodyChunkCallable a function that will be called
     * @param array $params the parameters of the request
     * @param array|\Payske\Util\RequestOptions $opts the special modifiers of the request
     * with chunks of bytes from the body if the request is successful
     */
    public function requestStream($method, $path, $readBodyChunkCallable, $params, $opts)
    {
        $opts = $this->defaultOpts->merge($opts, true);
        $baseUrl = $opts->apiBase ?: $this->getApiBase();
        $requestor = new \Payske\ApiRequestor($this->apiKeyForRequest($opts), $baseUrl);
        list($response, $opts->apiKey) = $requestor->requestStream($method, $path, $readBodyChunkCallable, $params, $opts->headers);
    }

    /**
     * Sends a request to Payske's API.
     *
     * @param string $method the HTTP method
     * @param string $path the path of the request
     * @param array $params the parameters of the request
     * @param array|\Payske\Util\RequestOptions $opts the special modifiers of the request
     *
     * @return \Payske\Collection of ApiResources
     */
    public function requestCollection($method, $path, $params, $opts)
    {
        $obj = $this->request($method, $path, $params, $opts);
        if (!($obj instanceof \Payske\Collection)) {
            $received_class = \get_class($obj);
            $msg = "Expected to receive `Payske\\Collection` object from Payske API. Instead received `{$received_class}`.";

            throw new \Payske\Exception\UnexpectedValueException($msg);
        }
        $obj->setFilters($params);

        return $obj;
    }

    /**
     * @param \Payske\Util\RequestOptions $opts
     *
     * @throws \Payske\Exception\AuthenticationException
     *
     * @return string
     */
    private function apiKeyForRequest($opts)
    {
        $apiKey = $opts->apiKey ?: $this->getApiKey();

        if (null === $apiKey) {
            $msg = 'No API key provided. Set your API key when constructing the '
                . 'PayskeClient instance, or provide it on a per-request basis '
                . 'using the `api_key` key in the $opts argument.';

            throw new \Payske\Exception\AuthenticationException($msg);
        }

        return $apiKey;
    }

    /**
     * TODO: replace this with a private constant when we drop support for PHP < 5.
     *
     * @return array<string, mixed>
     */
    private function getDefaultConfig()
    {
        return [
            'api_key' => null,
            'client_id' => null,
            'Payske_account' => null,
            'Payske_version' => null,
            'api_base' => self::DEFAULT_API_BASE,
            'connect_base' => self::DEFAULT_CONNECT_BASE,
            'files_base' => self::DEFAULT_FILES_BASE,
        ];
    }

    /**
     * @param array<string, mixed> $config
     *
     * @throws \Payske\Exception\InvalidArgumentException
     */
    private function validateConfig($config)
    {
        // api_key
        if (null !== $config['api_key'] && !\is_string($config['api_key'])) {
            throw new \Payske\Exception\InvalidArgumentException('api_key must be null or a string');
        }

        if (null !== $config['api_key'] && ('' === $config['api_key'])) {
            $msg = 'api_key cannot be the empty string';

            throw new \Payske\Exception\InvalidArgumentException($msg);
        }

        if (null !== $config['api_key'] && (\preg_match('/\s/', $config['api_key']))) {
            $msg = 'api_key cannot contain whitespace';

            throw new \Payske\Exception\InvalidArgumentException($msg);
        }

        // client_id
        if (null !== $config['client_id'] && !\is_string($config['client_id'])) {
            throw new \Payske\Exception\InvalidArgumentException('client_id must be null or a string');
        }

        // Payske_account
        if (null !== $config['Payske_account'] && !\is_string($config['Payske_account'])) {
            throw new \Payske\Exception\InvalidArgumentException('Payske_account must be null or a string');
        }

        // Payske_version
        if (null !== $config['Payske_version'] && !\is_string($config['Payske_version'])) {
            throw new \Payske\Exception\InvalidArgumentException('Payske_version must be null or a string');
        }

        // api_base
        if (!\is_string($config['api_base'])) {
            throw new \Payske\Exception\InvalidArgumentException('api_base must be a string');
        }

        // connect_base
        if (!\is_string($config['connect_base'])) {
            throw new \Payske\Exception\InvalidArgumentException('connect_base must be a string');
        }

        // files_base
        if (!\is_string($config['files_base'])) {
            throw new \Payske\Exception\InvalidArgumentException('files_base must be a string');
        }

        // check absence of extra keys
        $extraConfigKeys = \array_diff(\array_keys($config), \array_keys($this->getDefaultConfig()));
        if (!empty($extraConfigKeys)) {
            // Wrap in single quote to more easily catch trailing spaces errors
            $invalidKeys = "'" . \implode("', '", $extraConfigKeys) . "'";

            throw new \Payske\Exception\InvalidArgumentException('Found unknown key(s) in configuration array: ' . $invalidKeys);
        }
    }
}
