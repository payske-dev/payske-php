<?php

namespace Payske;

/**
 * @internal
 * @covers \Payske\PaymentMethod
 */
final class PaymentMethodTest extends \PHPUnit\Framework\TestCase
{
    use TestHelper;

    const TEST_RESOURCE_ID = 'pm_123';

    public function testIsListable()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/payment_methods'
        );
        $resources = PaymentMethod::all([
            'customer' => 'cus_123',
            'type' => 'card',
        ]);
        static::assertInternalType('array', $resources->data);
        static::assertInstanceOf(\Payske\PaymentMethod::class, $resources->data[0]);
    }

    public function testIsRetrievable()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/payment_methods/' . self::TEST_RESOURCE_ID
        );
        $resource = PaymentMethod::retrieve(self::TEST_RESOURCE_ID);
        static::assertInstanceOf(\Payske\PaymentMethod::class, $resource);
    }

    public function testIsCreatable()
    {
        $this->expectsRequest(
            'post',
            '/api/v1/payment_methods'
        );
        $resource = PaymentMethod::create([
            'type' => 'card',
        ]);
        static::assertInstanceOf(\Payske\PaymentMethod::class, $resource);
    }

    public function testIsSaveable()
    {
        $resource = PaymentMethod::retrieve(self::TEST_RESOURCE_ID);
        $resource->metadata['key'] = 'value';
        $this->expectsRequest(
            'post',
            '/api/v1/payment_methods/' . $resource->id
        );
        $resource->save();
        static::assertInstanceOf(\Payske\PaymentMethod::class, $resource);
    }

    public function testIsUpdatable()
    {
        $this->expectsRequest(
            'post',
            '/api/v1/payment_methods/' . self::TEST_RESOURCE_ID
        );
        $resource = PaymentMethod::update(self::TEST_RESOURCE_ID, [
            'metadata' => ['key' => 'value'],
        ]);
        static::assertInstanceOf(\Payske\PaymentMethod::class, $resource);
    }

    public function testCanAttach()
    {
        $resource = PaymentMethod::retrieve(self::TEST_RESOURCE_ID);
        $this->expectsRequest(
            'post',
            '/api/v1/payment_methods/' . $resource->id . '/attach'
        );
        $resource = $resource->attach([
            'customer' => 'cus_123',
        ]);
        static::assertInstanceOf(\Payske\PaymentMethod::class, $resource);
        static::assertSame($resource, $resource);
    }

    public function testCanDetach()
    {
        $resource = PaymentMethod::retrieve(self::TEST_RESOURCE_ID);
        $this->expectsRequest(
            'post',
            '/api/v1/payment_methods/' . $resource->id . '/detach'
        );
        $resource = $resource->detach();
        static::assertInstanceOf(\Payske\PaymentMethod::class, $resource);
        static::assertSame($resource, $resource);
    }
}
