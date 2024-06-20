<?php

namespace Payske;

/**
 * @internal
 * @covers \Payske\InvoiceItem
 */
final class InvoiceItemTest extends \PHPUnit\Framework\TestCase
{
    use TestHelper;

    const TEST_RESOURCE_ID = 'ii_123';

    public function testIsListable()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/invoiceitems'
        );
        $resources = InvoiceItem::all();
        static::assertInternalType('array', $resources->data);
        static::assertInstanceOf(\Payske\InvoiceItem::class, $resources->data[0]);
    }

    public function testIsRetrievable()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/invoiceitems/' . self::TEST_RESOURCE_ID
        );
        $resource = InvoiceItem::retrieve(self::TEST_RESOURCE_ID);
        static::assertInstanceOf(\Payske\InvoiceItem::class, $resource);
    }

    public function testIsCreatable()
    {
        $this->expectsRequest(
            'post',
            '/api/v1/invoiceitems'
        );
        $resource = InvoiceItem::create([
            'amount' => 100,
            'currency' => 'usd',
            'customer' => 'cus_123',
        ]);
        static::assertInstanceOf(\Payske\InvoiceItem::class, $resource);
    }

    public function testIsSaveable()
    {
        $resource = InvoiceItem::retrieve(self::TEST_RESOURCE_ID);
        $resource->metadata['key'] = 'value';
        $this->expectsRequest(
            'post',
            '/api/v1/invoiceitems/' . $resource->id
        );
        $resource->save();
        static::assertInstanceOf(\Payske\InvoiceItem::class, $resource);
    }

    public function testIsUpdatable()
    {
        $this->expectsRequest(
            'post',
            '/api/v1/invoiceitems/' . self::TEST_RESOURCE_ID
        );
        $resource = InvoiceItem::update(self::TEST_RESOURCE_ID, [
            'metadata' => ['key' => 'value'],
        ]);
        static::assertInstanceOf(\Payske\InvoiceItem::class, $resource);
    }

    public function testIsDeletable()
    {
        $invoiceItem = InvoiceItem::retrieve(self::TEST_RESOURCE_ID);
        $this->expectsRequest(
            'delete',
            '/api/v1/invoiceitems/' . $invoiceItem->id
        );
        $resource = $invoiceItem->delete();
        static::assertInstanceOf(\Payske\InvoiceItem::class, $resource);
    }
}
