<?php

namespace Payske;

/**
 * @internal
 * @covers \Payske\PayskeClient
 */
final class PayskeClientTest extends \PHPUnit\Framework\TestCase
{
    public function testExposesPropertiesForServices()
    {
        $client = new PayskeClient('sk_test_123');
        static::assertInstanceOf(\Payske\Service\CouponService::class, $client->coupons);
        static::assertInstanceOf(\Payske\Service\Issuing\IssuingServiceFactory::class, $client->issuing);
        static::assertInstanceOf(\Payske\Service\Issuing\CardService::class, $client->issuing->cards);
    }
}
