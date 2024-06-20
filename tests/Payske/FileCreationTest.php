<?php

namespace Payske;

/**
 * @internal
 * @covers \Payske\File
 */
final class FileCreationTest extends \PHPUnit\Framework\TestCase
{
    // These tests should really be part of `FileTest`, but because the file creation requests use a
    // different host, the tests for these methods need their own setup and teardown methods.

    use TestHelper;

    /** @var null|string */
    private $origApiUploadBase;

    /** @before */
    public function setUpUploadBase()
    {
        $this->origApiBase = Payske::$apiBase;
        $this->origApiUploadBase = Payske::$apiUploadBase;

        Payske::$apiUploadBase = \defined('MOCK_URL') ? MOCK_URL : 'http://localhost:12111';
        Payske::$apiBase = null;
    }

    /** @after */
    public function tearDownUploadBase()
    {
        Payske::$apiBase = $this->origApiBase;
        Payske::$apiUploadBase = $this->origApiUploadBase;
    }

    public function testIsCreatableWithFileHandle()
    {
        $this->expectsRequest(
            'post',
            '/api/v1/files',
            null,
            ['Content-Type: multipart/form-data'],
            true,
            Payske::$apiUploadBase
        );
        $fp = \fopen(__DIR__ . '/../data/test.png', 'rb');
        $resource = File::create([
            'purpose' => 'dispute_evidence',
            'file' => $fp,
            'file_link_data' => ['create' => true],
        ]);
        static::assertInstanceOf(\Payske\File::class, $resource);
    }

    public function testIsCreatableWithCURLFile()
    {
        $this->expectsRequest(
            'post',
            '/api/v1/files',
            null,
            ['Content-Type: multipart/form-data'],
            true,
            Payske::$apiUploadBase
        );
        $curlFile = new \CURLFile(__DIR__ . '/../data/test.png');
        $resource = File::create([
            'purpose' => 'dispute_evidence',
            'file' => $curlFile,
            'file_link_data' => ['create' => true],
        ]);
        static::assertInstanceOf(\Payske\File::class, $resource);
    }
}
