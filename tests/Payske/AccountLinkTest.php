<?php

namespace Payske;

/**
 * @internal
 * @covers \Payske\AccountLink
 */
final class AccountLinkTest extends \PHPUnit\Framework\TestCase
{
    use TestHelper;

    public function testIsCreatable()
    {
        $this->expectsRequest(
            'post',
            '/api/v1/account_links'
        );
        $resource = AccountLink::create([
            'account' => 'acct_123',
            'refresh_url' => 'https://payske.com/refresh_url',
            'return_url' => 'https://payske.com/return_url',
            'type' => 'account_onboarding',
        ]);
        static::assertInstanceOf(\Payske\AccountLink::class, $resource);
    }
}
