<?php

namespace Payske;

/**
 * @internal
 * @covers \Payske\Quote
 */
final class QuoteTest extends \PHPUnit\Framework\TestCase
{
    use TestHelper;

    const TEST_RESOURCE_ID = 'qt_123';

    public function testIsListable()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/quotes'
        );
        $resources = Quote::all();
        static::assertInternalType('array', $resources->data);
        static::assertInstanceOf(\Payske\Quote::class, $resources->data[0]);
    }

    public function testIsRetrievable()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/quotes/' . self::TEST_RESOURCE_ID
        );
        $resource = Quote::retrieve(self::TEST_RESOURCE_ID);
        static::assertInstanceOf(\Payske\Quote::class, $resource);
    }

    public function testIsCreatable()
    {
        $this->expectsRequest(
            'post',
            '/api/v1/quotes'
        );
        $resource = Quote::create([
            'customer' => 'cus_xyz',
            'line_items' => [
                ['price' => 'price_abc', 'quantity' => 5],
                ['price' => 'price_xyz'],
            ],
        ]);
        static::assertInstanceOf(\Payske\Quote::class, $resource);
    }

    public function testIsSaveable()
    {
        $resource = Quote::retrieve(self::TEST_RESOURCE_ID);
        $resource->metadata['key'] = 'value';
        $this->expectsRequest(
            'post',
            '/api/v1/quotes/' . self::TEST_RESOURCE_ID
        );
        $resource->save();
        static::assertInstanceOf(\Payske\Quote::class, $resource);
    }

    public function testIsUpdatable()
    {
        $this->expectsRequest(
            'post',
            '/api/v1/quotes/' . self::TEST_RESOURCE_ID
        );
        $resource = Quote::update(
            self::TEST_RESOURCE_ID,
            [
                'metadata' => ['key' => 'value'],
            ]
        );
        static::assertInstanceOf(\Payske\Quote::class, $resource);
    }

    public function testIsAcceptable()
    {
        $resource = Quote::retrieve(self::TEST_RESOURCE_ID);
        $this->expectsRequest(
            'post',
            '/api/v1/quotes/' . self::TEST_RESOURCE_ID . '/accept'
        );
        $resource->accept();
        static::assertInstanceOf(\Payske\Quote::class, $resource);
    }

    public function testIsCancelable()
    {
        $resource = Quote::retrieve(self::TEST_RESOURCE_ID);
        $this->expectsRequest(
            'post',
            '/api/v1/quotes/' . self::TEST_RESOURCE_ID . '/cancel'
        );
        $resource->cancel();
        static::assertInstanceOf(\Payske\Quote::class, $resource);
    }

    public function testIsFinalizable()
    {
        $resource = Quote::retrieve(self::TEST_RESOURCE_ID);
        $this->expectsRequest(
            'post',
            '/api/v1/quotes/' . self::TEST_RESOURCE_ID . '/finalize'
        );
        $resource->finalizeQuote();
        static::assertInstanceOf(\Payske\Quote::class, $resource);
    }

    public function testCanListLineItems()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/quotes/' . self::TEST_RESOURCE_ID . '/line_items'
        );
        $resources = Quote::allLineItems(self::TEST_RESOURCE_ID);
        static::assertInternalType('array', $resources->data);
    }

    public function testCanPdf()
    {
        $resource = Quote::retrieve(self::TEST_RESOURCE_ID);
        $this->expectsRequestStream(
            'get',
            '/api/v1/quotes/' . self::TEST_RESOURCE_ID . '/pdf',
            null
        );
        $output = '';
        $resource->pdf(function ($chunk) use (&$output) {
            $output .= $chunk;
        });
        static::assertSame('Payske binary response', $output);
    }
}
