<?php

namespace Payske\Service;

/**
 * @internal
 * @covers \Payske\Service\FileService
 */
final class FileServiceTest extends \PHPUnit\Framework\TestCase
{
    use \Payske\TestHelper;

    const TEST_RESOURCE_ID = 'file_123';

    /** @var \Payske\PayskeClient */
    private $client;

    /** @var FileService */
    private $service;

    /**
     * @before
     */
    protected function setUpService()
    {
        $this->client = new \Payske\PayskeClient(['api_key' => 'sk_test_123', 'api_base' => MOCK_URL]);
        $this->service = new FileService($this->client);
    }

    public function testAll()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/files'
        );
        $resources = $this->service->all();
        static::assertInternalType('array', $resources->data);
        static::assertInstanceOf(\Payske\File::class, $resources->data[0]);
    }

    public function testCreateWithCURLFile()
    {
        $client = new \Payske\PayskeClient(['api_key' => 'sk_test_123', 'files_base' => MOCK_URL]);
        $service = new FileService($client);

        $this->expectsRequest(
            'post',
            '/api/v1/files',
            null,
            ['Content-Type: multipart/form-data'],
            true,
            MOCK_URL
        );
        $curlFile = new \CURLFile(__DIR__ . '/../../data/test.png');
        $resource = $service->create([
            'purpose' => 'dispute_evidence',
            'file' => $curlFile,
            'file_link_data' => ['create' => true],
        ]);
        static::assertInstanceOf(\Payske\File::class, $resource);
    }

    public function testCreateWithFileHandle()
    {
        $client = new \Payske\PayskeClient(['api_key' => 'sk_test_123', 'files_base' => MOCK_URL]);
        $service = new FileService($client);

        $this->expectsRequest(
            'post',
            '/api/v1/files',
            null,
            ['Content-Type: multipart/form-data'],
            true,
            MOCK_URL
        );
        $fp = \fopen(__DIR__ . '/../../data/test.png', 'rb');
        $resource = $service->create([
            'purpose' => 'dispute_evidence',
            'file' => $fp,
            'file_link_data' => ['create' => true],
        ]);
        static::assertInstanceOf(\Payske\File::class, $resource);
    }

    public function testRetrieve()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/files/' . self::TEST_RESOURCE_ID
        );
        $resource = $this->service->retrieve(self::TEST_RESOURCE_ID);
        static::assertInstanceOf(\Payske\File::class, $resource);
    }
}
