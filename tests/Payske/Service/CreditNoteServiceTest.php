<?php

namespace Payske\Service;

/**
 * @internal
 * @covers \Payske\Service\CreditNoteService
 */
final class CreditNoteServiceTest extends \PHPUnit\Framework\TestCase
{
    use \Payske\TestHelper;

    const TEST_RESOURCE_ID = 'cn_123';

    /** @var \Payske\PayskeClient */
    private $client;

    /** @var CreditNoteService */
    private $service;

    /**
     * @before
     */
    protected function setUpService()
    {
        $this->client = new \Payske\PayskeClient(['api_key' => 'sk_test_123', 'api_base' => MOCK_URL]);
        $this->service = new CreditNoteService($this->client);
    }

    public function testAll()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/credit_notes'
        );
        $resources = $this->service->all();
        static::assertInternalType('array', $resources->data);
        static::assertInstanceOf(\Payske\CreditNote::class, $resources->data[0]);
    }

    public function testAllLines()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/credit_notes/' . self::TEST_RESOURCE_ID . '/lines'
        );
        $resources = $this->service->allLines(self::TEST_RESOURCE_ID);
        static::assertInternalType('array', $resources->data);
        static::assertInstanceOf(\Payske\CreditNoteLineItem::class, $resources->data[0]);
    }

    public function testCreate()
    {
        $this->expectsRequest(
            'post',
            '/api/v1/credit_notes'
        );
        $resource = $this->service->create([
            'amount' => 100,
            'invoice' => 'in_132',
            'reason' => 'duplicate',
        ]);
        static::assertInstanceOf(\Payske\CreditNote::class, $resource);
    }

    public function testPreview()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/credit_notes/preview'
        );
        $resource = $this->service->preview([
            'amount' => 100,
            'invoice' => 'in_123',
        ]);
        static::assertInstanceOf(\Payske\CreditNote::class, $resource);
    }

    public function testPreviewLines()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/credit_notes/preview/lines'
        );
        $resources = $this->service->previewLines([
            'amount' => 100,
            'invoice' => 'in_123',
        ]);
        static::assertInternalType('array', $resources->data);
        static::assertInstanceOf(\Payske\CreditNoteLineItem::class, $resources->data[0]);
    }

    public function testRetrieve()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/credit_notes/' . self::TEST_RESOURCE_ID
        );
        $resource = $this->service->retrieve(self::TEST_RESOURCE_ID);
        static::assertInstanceOf(\Payske\CreditNote::class, $resource);
    }

    public function testUpdate()
    {
        $this->expectsRequest(
            'post',
            '/api/v1/credit_notes/' . self::TEST_RESOURCE_ID
        );
        $resource = $this->service->update(self::TEST_RESOURCE_ID, [
            'metadata' => ['key' => 'value'],
        ]);
        static::assertInstanceOf(\Payske\CreditNote::class, $resource);
    }

    public function testVoidCreditNote()
    {
        $this->expectsRequest(
            'post',
            '/api/v1/credit_notes/' . self::TEST_RESOURCE_ID . '/void'
        );
        $resource = $this->service->voidCreditNote(self::TEST_RESOURCE_ID);
        static::assertInstanceOf(\Payske\CreditNote::class, $resource);
    }
}
