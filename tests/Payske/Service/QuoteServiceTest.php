<?php

namespace Payske\Service;

/**
 * @internal
 * @covers \Payske\Service\QuoteService
 */
final class QuoteServiceTest extends \PHPUnit\Framework\TestCase
{
    use \Payske\TestHelper;

    const TEST_RESOURCE_ID = 'qt_123';

    /** @var \Payske\PayskeClient */
    private $client;

    /** @var QuoteService */
    private $service;

    /**
     * @before
     */
    protected function setUpService()
    {
        $this->client = new \Payske\PayskeClient(['api_key' => 'sk_test_123', 'api_base' => MOCK_URL, 'files_base' => MOCK_URL]);
        $this->service = new QuoteService($this->client);
    }

    public function testAll()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/quotes'
        );
        $resources = $this->service->all();
        static::assertInternalType('array', $resources->data);
        static::assertInstanceOf(\Payske\Quote::class, $resources->data[0]);
    }

    public function testCreate()
    {
        $this->expectsRequest(
            'post',
            '/api/v1/quotes'
        );
        $resource = $this->service->create([
            'customer' => 'cus_123',
        ]);
        static::assertInstanceOf(\Payske\Quote::class, $resource);
    }

    public function testRetrieve()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/quotes/' . self::TEST_RESOURCE_ID
        );
        $resource = $this->service->retrieve(self::TEST_RESOURCE_ID);
        static::assertInstanceOf(\Payske\Quote::class, $resource);
    }

    public function testUpdate()
    {
        $this->expectsRequest(
            'post',
            '/api/v1/quotes/' . self::TEST_RESOURCE_ID
        );
        $resource = $this->service->update(self::TEST_RESOURCE_ID, [
            'metadata' => ['key' => 'value'],
        ]);
        static::assertInstanceOf(\Payske\Quote::class, $resource);
    }

    public function testFinalizeQuote()
    {
        $this->expectsRequest(
            'post',
            '/api/v1/quotes/' . self::TEST_RESOURCE_ID . '/finalize'
        );
        $resource = $this->service->finalizeQuote(self::TEST_RESOURCE_ID);
        static::assertInstanceOf(\Payske\Quote::class, $resource);
    }

    public function testCancel()
    {
        $this->expectsRequest(
            'post',
            '/api/v1/quotes/' . self::TEST_RESOURCE_ID . '/cancel'
        );
        $resource = $this->service->cancel(self::TEST_RESOURCE_ID);
        static::assertInstanceOf(\Payske\Quote::class, $resource);
    }

    public function testAccept()
    {
        $this->expectsRequest(
            'post',
            '/api/v1/quotes/' . self::TEST_RESOURCE_ID . '/cancel'
        );
        $resource = $this->service->cancel(self::TEST_RESOURCE_ID);
        static::assertInstanceOf(\Payske\Quote::class, $resource);
    }

    public function testAllLines()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/quotes/' . self::TEST_RESOURCE_ID . '/line_items'
        );
        $resources = $this->service->allLineItems(self::TEST_RESOURCE_ID);
        static::assertInternalType('array', $resources->data);
    }

    public function testPdf()
    {
        $this->expectsRequestStream(
            'get',
            '/api/v1/quotes/' . self::TEST_RESOURCE_ID . '/pdf'
        );
        $output = '';
        $resources = $this->service->pdf(self::TEST_RESOURCE_ID, function ($chunk) use (&$output) {
            $output .= $chunk;
        });
        static::assertSame('Payske binary response', $output);
    }
}
