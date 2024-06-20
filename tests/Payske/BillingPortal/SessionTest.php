<?php

namespace Payske\BillingPortal;

/**
 * @internal
 * @covers \Payske\BillingPortal\Session
 */
final class SessionTest extends \PHPUnit\Framework\TestCase
{
    use \Payske\TestHelper;

    const TEST_RESOURCE_ID = 'pts_123';

    public function testIsCreatable()
    {
        $this->expectsRequest(
            'post',
            '/api/v1/billing_portal/sessions'
        );
        $resource = Session::create([
            'customer' => 'cus_123',
            'return_url' => 'https://payske.com/return',
        ]);
        static::assertInstanceOf(\Payske\BillingPortal\Session::class, $resource);
    }
}
