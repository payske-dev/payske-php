<?php

namespace Payske;

/**
 * @internal
 * @covers \Payske\leLink
 */
final class FileLinkTest extends \PHPUnit\Framework\TestCase
{
    use TestHelper;

    const TEST_RESOURCE_ID = 'link_123';

    public function testIsListable()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/file_links'
        );
        $resources = FileLink::all();
        static::assertInternalType('array', $resources->data);
        static::assertInstanceOf(\Payske\leLink::class, $resources->data[0]);
    }

    public function testIsRetrievable()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/file_links/' . self::TEST_RESOURCE_ID
        );
        $resource = FileLink::retrieve(self::TEST_RESOURCE_ID);
        static::assertInstanceOf(\Payske\leLink::class, $resource);
    }

    public function testIsCreatable()
    {
        $this->expectsRequest(
            'post',
            '/api/v1/file_links'
        );
        $resource = FileLink::create([
            'file' => 'file_123',
        ]);
        static::assertInstanceOf(\Payske\leLink::class, $resource);
    }

    public function testIsSaveable()
    {
        $resource = FileLink::retrieve(self::TEST_RESOURCE_ID);
        $resource->metadata['key'] = 'value';
        $this->expectsRequest(
            'post',
            '/api/v1/file_links/' . $resource->id
        );
        $resource->save();
        static::assertInstanceOf(\Payske\leLink::class, $resource);
    }

    public function testIsUpdatable()
    {
        $this->expectsRequest(
            'post',
            '/api/v1/file_links/' . self::TEST_RESOURCE_ID
        );
        $resource = FileLink::update(self::TEST_RESOURCE_ID, [
            'metadata' => ['key' => 'value'],
        ]);
        static::assertInstanceOf(\Payske\leLink::class, $resource);
    }
}
