<?php

namespace Payske\Issuing;

/**
 * @internal
 * @covers \Payske\Issuing\Card
 */
final class CardTest extends \PHPUnit\Framework\TestCase
{
    use \Payske\TestHelper;

    const TEST_RESOURCE_ID = 'ic_123';

    public function testIsListable()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/issuing/cards'
        );
        $resources = Card::all();
        static::assertInternalType('array', $resources->data);
        static::assertInstanceOf(\Payske\Issuing\Card::class, $resources->data[0]);
    }

    public function testIsRetrievable()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/issuing/cards/' . self::TEST_RESOURCE_ID
        );
        $resource = Card::retrieve(self::TEST_RESOURCE_ID);
        static::assertInstanceOf(\Payske\Issuing\Card::class, $resource);
    }

    public function testIsSaveable()
    {
        $resource = Card::retrieve(self::TEST_RESOURCE_ID);
        $resource->metadata['key'] = 'value';

        $this->expectsRequest(
            'post',
            '/api/v1/issuing/cards/' . self::TEST_RESOURCE_ID
        );
        $resource->save();
        static::assertInstanceOf(\Payske\Issuing\Card::class, $resource);
    }

    public function testIsUpdatable()
    {
        $this->expectsRequest(
            'post',
            '/api/v1/issuing/cards/' . self::TEST_RESOURCE_ID,
            ['metadata' => ['key' => 'value']]
        );
        $resource = Card::update(self::TEST_RESOURCE_ID, [
            'metadata' => ['key' => 'value'],
        ]);
        static::assertInstanceOf(\Payske\Issuing\Card::class, $resource);
    }

    public function testCanRetrieveDetails()
    {
        $resource = Card::retrieve(self::TEST_RESOURCE_ID);

        // Payske-mock does not support this anymore so we stub it
        $this->stubRequest(
            'get',
            '/api/v1/issuing/cards/' . self::TEST_RESOURCE_ID . '/details',
            [],
            null,
            false,
            ['object' => 'issuing.card_details']
        );

        $details = $resource->details();
        static::assertInstanceOf(\Payske\Issuing\CardDetails::class, $details);
    }
}
