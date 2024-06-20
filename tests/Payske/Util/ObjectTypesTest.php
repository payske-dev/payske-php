<?php

namespace Payske\Util;

/**
 * @internal
 * @covers \Payske\Util\ObjectTypes
 */
final class ObjectTypesTest extends \PHPUnit\Framework\TestCase
{
    use \Payske\TestHelper;

    public function testMapping()
    {
        static::assertSame(\Payske\Util\ObjectTypes::mapping['charge'], \Payske\Charge::class);
        static::assertSame(\Payske\Util\ObjectTypes::mapping['checkout.session'], \Payske\Checkout\Session::class);
    }
}
