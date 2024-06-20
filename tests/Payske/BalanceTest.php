<?php

namespace Payske;

/**
 * @internal
 * @covers \Payske\Balance
 */
final class BalanceTest extends \PHPUnit\Framework\TestCase
{
    use TestHelper;

    public function testIsRetrievable()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/balance'
        );
        $resource = Balance::retrieve();
        static::assertInstanceOf(\Payske\Balance::class, $resource);
    }
}
