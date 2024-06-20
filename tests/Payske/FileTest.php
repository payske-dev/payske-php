<?php

namespace Payske;

/**
 * @internal
 * @covers \Payske\File
 */
final class FileTest extends \PHPUnit\Framework\TestCase
{
    use TestHelper;

    const TEST_RESOURCE_ID = 'file_123';

    public function testIsListable()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/files'
        );
        $resources = File::all();
        static::assertInternalType('array', $resources->data);
        static::assertInstanceOf(\Payske\File::class, $resources->data[0]);
    }

    public function testIsRetrievable()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/files/' . self::TEST_RESOURCE_ID
        );
        $resource = File::retrieve(self::TEST_RESOURCE_ID);
        static::assertInstanceOf(\Payske\File::class, $resource);
    }

    public function testDeserializesFromFile()
    {
        $obj = Util\Util::convertToPayskeObject([
            'object' => 'file',
        ], null);
        static::assertInstanceOf(\Payske\File::class, $obj);
    }

    public function testDeserializesFromFileUpload()
    {
        $obj = Util\Util::convertToPayskeObject([
            'object' => 'file_upload',
        ], null);
        static::assertInstanceOf(\Payske\File::class, $obj);
    }
}
