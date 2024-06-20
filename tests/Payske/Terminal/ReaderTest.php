<?php

namespace Payske\Terminal;

/**
 * @internal
 * @covers \Payske\Terminal\Reader
 */
final class ReaderTest extends \PHPUnit\Framework\TestCase
{
    use \Payske\TestHelper;

    const TEST_RESOURCE_ID = 'rdr_123';

    public function testIsListable()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/terminal/readers'
        );
        $resources = Reader::all();
        static::assertInternalType('array', $resources->data);
        static::assertInstanceOf(\Payske\Terminal\Reader::class, $resources->data[0]);
    }

    public function testIsRetrievable()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/terminal/readers/' . self::TEST_RESOURCE_ID
        );
        $resource = Reader::retrieve(self::TEST_RESOURCE_ID);
        static::assertInstanceOf(\Payske\Terminal\Reader::class, $resource);
    }

    public function testIsSaveable()
    {
        $resource = Reader::retrieve(self::TEST_RESOURCE_ID);
        $resource->label = 'new-name';

        $this->expectsRequest(
            'post',
            '/api/v1/terminal/readers/' . self::TEST_RESOURCE_ID
        );
        $resource->save();
        static::assertInstanceOf(\Payske\Terminal\Reader::class, $resource);
    }

    public function testIsUpdatable()
    {
        $this->expectsRequest(
            'post',
            '/api/v1/terminal/readers/' . self::TEST_RESOURCE_ID,
            ['label' => 'new-name']
        );
        $resource = Reader::update(self::TEST_RESOURCE_ID, [
            'label' => 'new-name',
        ]);
        static::assertInstanceOf(\Payske\Terminal\Reader::class, $resource);
    }

    public function testIsCreatable()
    {
        $this->expectsRequest(
            'post',
            '/api/v1/terminal/readers',
            ['registration_code' => 'a-b-c']
        );
        $resource = Reader::create(['registration_code' => 'a-b-c']);
        static::assertInstanceOf(\Payske\Terminal\Reader::class, $resource);
    }

    public function testIsDeletable()
    {
        $resource = Reader::retrieve(self::TEST_RESOURCE_ID);
        $this->expectsRequest(
            'delete',
            '/api/v1/terminal/readers/' . self::TEST_RESOURCE_ID
        );
        $resource->delete();
        static::assertInstanceOf(\Payske\Terminal\Reader::class, $resource);
    }
}
