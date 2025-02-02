<?php

namespace Payske;

/**
 * @internal
 * @covers \Payske\CreditNote
 */
final class CreditNoteTest extends \PHPUnit\Framework\TestCase
{
    use TestHelper;

    const TEST_RESOURCE_ID = 'cn_123';

    public function testIsListable()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/credit_notes'
        );
        $resources = CreditNote::all();
        static::assertInternalType('array', $resources->data);
        static::assertInstanceOf(\Payske\CreditNote::class, $resources->data[0]);
    }

    public function testIsRetrievable()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/credit_notes/' . self::TEST_RESOURCE_ID
        );
        $resource = CreditNote::retrieve(self::TEST_RESOURCE_ID);
        static::assertInstanceOf(\Payske\CreditNote::class, $resource);
    }

    public function testIsCreatable()
    {
        $this->expectsRequest(
            'post',
            '/api/v1/credit_notes'
        );
        $resource = CreditNote::create([
            'amount' => 100,
            'invoice' => 'in_132',
            'reason' => 'duplicate',
        ]);
        static::assertInstanceOf(\Payske\CreditNote::class, $resource);
    }

    public function testIsSaveable()
    {
        $resource = CreditNote::retrieve(self::TEST_RESOURCE_ID);
        $resource->metadata['key'] = 'value';
        $this->expectsRequest(
            'post',
            '/api/v1/credit_notes/' . $resource->id
        );
        $resource->save();
        static::assertInstanceOf(\Payske\CreditNote::class, $resource);
    }

    public function testIsUpdatable()
    {
        $this->expectsRequest(
            'post',
            '/api/v1/credit_notes/' . self::TEST_RESOURCE_ID
        );
        $resource = CreditNote::update(self::TEST_RESOURCE_ID, [
            'metadata' => ['key' => 'value'],
        ]);
        static::assertInstanceOf(\Payske\CreditNote::class, $resource);
    }

    public function testCanPreview()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/credit_notes/preview'
        );
        $resource = CreditNote::preview([
            'amount' => 100,
            'invoice' => 'in_123',
        ]);
        static::assertInstanceOf(\Payske\CreditNote::class, $resource);
    }

    public function testCanVoidCreditNote()
    {
        $creditNote = CreditNote::retrieve(self::TEST_RESOURCE_ID);
        $this->expectsRequest(
            'post',
            '/api/v1/credit_notes/' . $creditNote->id . '/void'
        );
        $resource = $creditNote->voidCreditNote();
        static::assertInstanceOf(\Payske\CreditNote::class, $resource);
        static::assertSame($resource, $creditNote);
    }

    public function testCanListLines()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/credit_notes/' . self::TEST_RESOURCE_ID . '/lines'
        );
        $resources = CreditNote::allLines(self::TEST_RESOURCE_ID);
        static::assertInternalType('array', $resources->data);
    }
}
