<?php

namespace Payske;

/**
 * @internal
 * @covers \Payske\OrderReturn
 */
final class OrderReturnTest extends \PHPUnit\Framework\TestCase
{
    use TestHelper;

    const TEST_RESOURCE_ID = 'orret_123';

    public function testIsListable()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/order_returns'
        );
        $resources = OrderReturn::all();
        static::assertInternalType('array', $resources->data);
        static::assertInstanceOf(\Payske\OrderReturn::class, $resources->data[0]);
    }

    public function testIsRetrievable()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/order_returns/' . self::TEST_RESOURCE_ID
        );
        $resource = OrderReturn::retrieve(self::TEST_RESOURCE_ID);
        static::assertInstanceOf(\Payske\OrderReturn::class, $resource);
    }
}
