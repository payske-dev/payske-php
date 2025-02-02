<?php

namespace Payske;

/**
 * @internal
 * @covers \Payske\Plan
 */
final class PlanTest extends \PHPUnit\Framework\TestCase
{
    use TestHelper;

    const TEST_RESOURCE_ID = 'plan';

    public function testIsListable()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/plans'
        );
        $resources = Plan::all();
        static::assertInternalType('array', $resources->data);
        static::assertInstanceOf(\Payske\Plan::class, $resources->data[0]);
    }

    public function testIsRetrievable()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/plans/' . self::TEST_RESOURCE_ID
        );
        $resource = Plan::retrieve(self::TEST_RESOURCE_ID);
        static::assertInstanceOf(\Payske\Plan::class, $resource);
    }

    public function testIsCreatable()
    {
        $this->expectsRequest(
            'post',
            '/api/v1/plans'
        );
        $resource = Plan::create([
            'amount' => 100,
            'interval' => 'month',
            'currency' => 'usd',
            'nickname' => self::TEST_RESOURCE_ID,
            'id' => self::TEST_RESOURCE_ID,
        ]);
        static::assertInstanceOf(\Payske\Plan::class, $resource);
    }

    public function testIsSaveable()
    {
        $resource = Plan::retrieve(self::TEST_RESOURCE_ID);
        $resource->metadata['key'] = 'value';
        $this->expectsRequest(
            'post',
            '/api/v1/plans/' . $resource->id
        );
        $resource->save();
        static::assertInstanceOf(\Payske\Plan::class, $resource);
    }

    public function testIsUpdatable()
    {
        $this->expectsRequest(
            'post',
            '/api/v1/plans/' . self::TEST_RESOURCE_ID
        );
        $resource = Plan::update(self::TEST_RESOURCE_ID, [
            'metadata' => ['key' => 'value'],
        ]);
        static::assertInstanceOf(\Payske\Plan::class, $resource);
    }

    public function testIsDeletable()
    {
        $resource = Plan::retrieve(self::TEST_RESOURCE_ID);
        $this->expectsRequest(
            'delete',
            '/api/v1/plans/' . $resource->id
        );
        $resource->delete();
        static::assertInstanceOf(\Payske\Plan::class, $resource);
    }
}
