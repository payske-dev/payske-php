<?php

namespace Payske;

/**
 * @internal
 * @covers \Payske\Review
 */
final class ReviewTest extends \PHPUnit\Framework\TestCase
{
    use \Payske\TestHelper;

    const TEST_RESOURCE_ID = 'prv_123';

    public function testIsApprovable()
    {
        $resource = Review::retrieve(self::TEST_RESOURCE_ID);
        $this->expectsRequest(
            'post',
            '/api/v1/reviews/' . self::TEST_RESOURCE_ID . '/approve'
        );
        $resource->approve();
        static::assertInstanceOf(\Payske\Review::class, $resource);
    }

    public function testIsListable()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/reviews'
        );
        $resources = Review::all();
        static::assertInternalType('array', $resources->data);
        static::assertInstanceOf(\Payske\Review::class, $resources->data[0]);
    }

    public function testIsRetrievable()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/reviews/' . self::TEST_RESOURCE_ID
        );
        $resource = Review::retrieve(self::TEST_RESOURCE_ID);
        static::assertInstanceOf(\Payske\Review::class, $resource);
    }
}
