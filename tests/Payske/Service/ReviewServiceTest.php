<?php

namespace Payske\Service;

/**
 * @internal
 * @covers \Payske\Service\ReviewService
 */
final class ReviewServiceTest extends \PHPUnit\Framework\TestCase
{
    use \Payske\TestHelper;

    const TEST_RESOURCE_ID = 'prv_123';

    /** @var \Payske\PayskeClient */
    private $client;

    /** @var ReviewService */
    private $service;

    /**
     * @before
     */
    protected function setUpService()
    {
        $this->client = new \Payske\PayskeClient(['api_key' => 'sk_test_123', 'api_base' => MOCK_URL]);
        $this->service = new ReviewService($this->client);
    }

    public function testAll()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/reviews'
        );
        $resources = $this->service->all();
        static::assertInternalType('array', $resources->data);
        static::assertInstanceOf(\Payske\Review::class, $resources->data[0]);
    }

    public function testApprove()
    {
        $this->expectsRequest(
            'post',
            '/api/v1/reviews/' . self::TEST_RESOURCE_ID . '/approve'
        );
        $resource = $this->service->approve(self::TEST_RESOURCE_ID);
        static::assertInstanceOf(\Payske\Review::class, $resource);
    }

    public function testRetrieve()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/reviews/' . self::TEST_RESOURCE_ID
        );
        $resource = $this->service->retrieve(self::TEST_RESOURCE_ID);
        static::assertInstanceOf(\Payske\Review::class, $resource);
    }
}
