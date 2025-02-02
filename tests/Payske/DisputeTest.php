<?php

namespace Payske;

/**
 * @internal
 * @covers \Payske\Dispute
 */
final class DisputeTest extends \PHPUnit\Framework\TestCase
{
    use TestHelper;

    const TEST_RESOURCE_ID = 'dp_123';

    public function testIsListable()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/disputes'
        );
        $resources = Dispute::all();
        static::assertInternalType('array', $resources->data);
        static::assertInstanceOf(\Payske\Dispute::class, $resources->data[0]);
    }

    public function testIsRetrievable()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/disputes/' . self::TEST_RESOURCE_ID
        );
        $resource = Dispute::retrieve(self::TEST_RESOURCE_ID);
        static::assertInstanceOf(\Payske\Dispute::class, $resource);
    }

    public function testIsSaveable()
    {
        $resource = Dispute::retrieve(self::TEST_RESOURCE_ID);
        $resource->metadata['key'] = 'value';
        $this->expectsRequest(
            'post',
            '/api/v1/disputes/' . $resource->id
        );
        $resource->save();
        static::assertInstanceOf(\Payske\Dispute::class, $resource);
    }

    public function testIsUpdatable()
    {
        $this->expectsRequest(
            'post',
            '/api/v1/disputes/' . self::TEST_RESOURCE_ID
        );
        $resource = Dispute::update(self::TEST_RESOURCE_ID, [
            'metadata' => ['key' => 'value'],
        ]);
        static::assertInstanceOf(\Payske\Dispute::class, $resource);
    }

    public function testIsClosable()
    {
        $dispute = Dispute::retrieve(self::TEST_RESOURCE_ID);
        $this->expectsRequest(
            'post',
            '/api/v1/disputes/' . $dispute->id . '/close'
        );
        $resource = $dispute->close();
        static::assertInstanceOf(\Payske\Dispute::class, $resource);
        static::assertSame($resource, $dispute);
    }
}
