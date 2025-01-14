<?php

namespace Payske;

/**
 * @internal
 * @covers \Payske\Event
 */
final class EventTest extends \PHPUnit\Framework\TestCase
{
    use TestHelper;

    const TEST_RESOURCE_ID = 'evt_123';

    public function testIsListable()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/events'
        );
        $resources = Event::all();
        static::assertInternalType('array', $resources->data);
        static::assertInstanceOf(\Payske\Event::class, $resources->data[0]);
    }

    public function testIsRetrievable()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/events/' . self::TEST_RESOURCE_ID
        );
        $resource = Event::retrieve(self::TEST_RESOURCE_ID);
        static::assertInstanceOf(\Payske\Event::class, $resource);
    }
}
