<?php

namespace Payske;

/**
 * @internal
 * @covers \Payske\Refund
 */
final class RefundTest extends \PHPUnit\Framework\TestCase
{
    use TestHelper;

    const TEST_RESOURCE_ID = 're_123';

    public function testIsListable()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/refunds'
        );
        $resources = Refund::all();
        static::assertInternalType('array', $resources->data);
        static::assertInstanceOf(\Payske\Refund::class, $resources->data[0]);
    }

    public function testIsRetrievable()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/refunds/' . self::TEST_RESOURCE_ID
        );
        $resource = Refund::retrieve(self::TEST_RESOURCE_ID);
        static::assertInstanceOf(\Payske\Refund::class, $resource);
    }

    public function testIsCreatable()
    {
        $this->expectsRequest(
            'post',
            '/api/v1/refunds'
        );
        $resource = Refund::create([
            'charge' => 'ch_123',
        ]);
        static::assertInstanceOf(\Payske\Refund::class, $resource);
    }

    public function testIsSaveable()
    {
        $resource = Refund::retrieve(self::TEST_RESOURCE_ID);
        $resource->metadata['key'] = 'value';
        $this->expectsRequest(
            'post',
            '/api/v1/refunds/' . $resource->id
        );
        $resource->save();
        static::assertInstanceOf(\Payske\Refund::class, $resource);
    }

    public function testIsUpdatable()
    {
        $this->expectsRequest(
            'post',
            '/api/v1/refunds/' . self::TEST_RESOURCE_ID
        );
        $resource = Refund::update(self::TEST_RESOURCE_ID, [
            'metadata' => ['key' => 'value'],
        ]);
        static::assertInstanceOf(\Payske\Refund::class, $resource);
    }
}
