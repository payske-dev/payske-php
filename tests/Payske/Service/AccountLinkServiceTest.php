<?php

namespace Payske\Service;

/**
 * @internal
 * @covers \Payske\Service\AccountLinkService
 */
final class AccountLinkServiceTest extends \PHPUnit\Framework\TestCase
{
    use \Payske\TestHelper;

    /** @var \Payske\PayskeClient */
    private $client;

    /** @var AccountLinkService */
    private $service;

    /**
     * @before
     */
    protected function setUpService()
    {
        $this->client = new \Payske\PayskeClient(['api_key' => 'sk_test_123', 'api_base' => MOCK_URL]);
        $this->service = new AccountLinkService($this->client);
    }

    public function testCreate()
    {
        $this->expectsRequest(
            'post',
            '/api/v1/account_links'
        );
        $resource = $this->service->create([
            'account' => 'acct_123',
            'refresh_url' => 'https://payske.com/refresh_url',
            'return_url' => 'https://payske.com/return_url',
            'type' => 'account_onboarding',
        ]);
        static::assertInstanceOf(\Payske\AccountLink::class, $resource);
    }
}