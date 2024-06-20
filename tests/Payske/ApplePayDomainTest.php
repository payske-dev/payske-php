<?php

namespace Payske;

/**
 * @internal
 * @covers \Payske\ApplePayDomain
 */
final class ApplePayDomainTest extends \PHPUnit\Framework\TestCase
{
    use TestHelper;

    const TEST_RESOURCE_ID = 'apwc_123';

    public function testIsListable()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/apple_pay/domains'
        );
        $resources = ApplePayDomain::all();
        static::assertInternalType('array', $resources->data);
        static::assertInstanceOf(\Payske\ApplePayDomain::class, $resources->data[0]);
    }

    public function testIsRetrievable()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/apple_pay/domains/' . self::TEST_RESOURCE_ID
        );
        $resource = ApplePayDomain::retrieve(self::TEST_RESOURCE_ID);
        static::assertInstanceOf(\Payske\ApplePayDomain::class, $resource);
    }

    public function testIsCreatable()
    {
        $this->expectsRequest(
            'post',
            '/api/v1/apple_pay/domains'
        );
        $resource = ApplePayDomain::create([
            'domain_name' => 'domain',
        ]);
        static::assertInstanceOf(\Payske\ApplePayDomain::class, $resource);
    }

    public function testIsDeletable()
    {
        $resource = ApplePayDomain::retrieve(self::TEST_RESOURCE_ID);
        $this->expectsRequest(
            'delete',
            '/api/v1/apple_pay/domains/' . $resource->id
        );
        $resource->delete();
        static::assertInstanceOf(\Payske\ApplePayDomain::class, $resource);
    }
}
