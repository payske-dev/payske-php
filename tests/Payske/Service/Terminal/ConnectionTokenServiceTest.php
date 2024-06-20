<?php

namespace Payske\Service\Terminal;

/**
 * @internal
 * @covers \Payske\Service\Terminal\ConnectionTokenService
 */
final class ConnectionTokenServiceTest extends \PHPUnit\Framework\TestCase
{
    use \Payske\TestHelper;

    /** @var \Payske\PayskeClient */
    private $client;

    /** @var ConnectionTokenService */
    private $service;

    /**
     * @before
     */
    protected function setUpService()
    {
        $this->client = new \Payske\PayskeClient(['api_key' => 'sk_test_123', 'api_base' => MOCK_URL]);
        $this->service = new ConnectionTokenService($this->client);
    }

    public function testCreate()
    {
        $this->expectsRequest(
            'post',
            '/api/v1/terminal/connection_tokens'
        );
        $resource = $this->service->create();
        static::assertInstanceOf(\Payske\Terminal\ConnectionToken::class, $resource);
    }
}
