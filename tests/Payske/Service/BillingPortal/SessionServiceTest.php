<?php

namespace Payske\Service\BillingPortal;

/**
 * @internal
 * @covers \Payske\Service\BillingPortal\SessionService
 */
final class SessionServiceTest extends \PHPUnit\Framework\TestCase
{
    use \Payske\TestHelper;

    const TEST_RESOURCE_ID = 'cs_123';

    /** @var \Payske\PayskeClient */
    private $client;

    /** @var SessionService */
    private $service;

    /**
     * @before
     */
    protected function setUpService()
    {
        $this->client = new \Payske\PayskeClient(['api_key' => 'sk_test_123', 'api_base' => MOCK_URL]);
        $this->service = new SessionService($this->client);
    }

    public function testCreate()
    {
        $this->expectsRequest(
            'post',
            '/api/v1/billing_portal/sessions'
        );
        $resource = $this->service->create([
            'customer' => 'cus_123',
            'return_url' => 'https://payske.com/return',
        ]);
        static::assertInstanceOf(\Payske\BillingPortal\Session::class, $resource);
    }
}
