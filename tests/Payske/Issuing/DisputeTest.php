<?php

namespace Payske\Issuing;

/**
 * @internal
 * @covers \Payske\Issuing\Dispute
 */
final class DisputeTest extends \PHPUnit\Framework\TestCase
{
    use \Payske\TestHelper;

    const TEST_RESOURCE_ID = 'idp_123';

    public function testIsCreatable()
    {
        $params = [
            'transaction' => 'ipi_123',
        ];

        $this->expectsRequest(
            'post',
            '/api/v1/issuing/disputes',
            $params
        );
        $resource = Dispute::create($params);
        static::assertInstanceOf(\Payske\Issuing\Dispute::class, $resource);
    }

    public function testIsListable()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/issuing/disputes'
        );
        $resources = Dispute::all();
        static::assertInternalType('array', $resources->data);
        static::assertInstanceOf(\Payske\Issuing\Dispute::class, $resources->data[0]);
    }

    public function testIsRetrievable()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/issuing/disputes/' . self::TEST_RESOURCE_ID
        );
        $resource = Dispute::retrieve(self::TEST_RESOURCE_ID);
        static::assertInstanceOf(\Payske\Issuing\Dispute::class, $resource);
    }

    public function testIsUpdatable()
    {
        $this->expectsRequest(
            'post',
            '/api/v1/issuing/disputes/' . self::TEST_RESOURCE_ID,
            []
        );
        $resource = Dispute::update(self::TEST_RESOURCE_ID, []);
        static::assertInstanceOf(\Payske\Issuing\Dispute::class, $resource);
    }

    public function testIsSubmittable()
    {
        $resource = Dispute::retrieve(self::TEST_RESOURCE_ID);
        $this->expectsRequest(
            'post',
            '/api/v1/issuing/disputes/' . self::TEST_RESOURCE_ID . '/submit'
        );
        $resource->submit();
        static::assertInstanceOf(\Payske\Issuing\Dispute::class, $resource);
    }
}
