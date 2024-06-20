<?php

namespace Payske\Service;

/**
 * @internal
 * @covers \Payske\Service\BalanceService
 */
final class BalanceServiceTest extends \PHPUnit\Framework\TestCase
{
    use \Payske\TestHelper;

    /** @var \Payske\PayskeClient */
    private $client;

    /** @var BalanceService */
    private $service;

    /**
     * @before
     */
    protected function setUpService()
    {
        $this->client = new \Payske\PayskeClient(['api_key' => 'sk_test_123', 'api_base' => MOCK_URL]);
        $this->service = new BalanceService($this->client);
    }

    public function testRetrieve()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/balance'
        );
        $resource = $this->service->retrieve();
        static::assertInstanceOf(\Payske\Balance::class, $resource);
    }
}
