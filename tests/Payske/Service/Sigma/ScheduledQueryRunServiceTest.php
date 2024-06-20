<?php

namespace Payske\Service\Sigma;

/**
 * @internal
 * @covers \Payske\Service\Sigma\ScheduledQueryRunService
 */
final class ScheduledQueryRunServiceTest extends \PHPUnit\Framework\TestCase
{
    use \Payske\TestHelper;

    const TEST_RESOURCE_ID = 'sqr_123';

    /** @var \Payske\PayskeClient */
    private $client;

    /** @var ScheduledQueryRunService */
    private $service;

    /**
     * @before
     */
    protected function setUpService()
    {
        $this->client = new \Payske\PayskeClient(['api_key' => 'sk_test_123', 'api_base' => MOCK_URL]);
        $this->service = new ScheduledQueryRunService($this->client);
    }

    public function testAll()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/sigma/scheduled_query_runs'
        );
        $resources = $this->service->all();
        static::assertInternalType('array', $resources->data);
        static::assertInstanceOf(\Payske\Sigma\ScheduledQueryRun::class, $resources->data[0]);
    }

    public function testRetrieve()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/sigma/scheduled_query_runs/' . self::TEST_RESOURCE_ID
        );
        $resource = $this->service->retrieve(self::TEST_RESOURCE_ID);
        static::assertInstanceOf(\Payske\Sigma\ScheduledQueryRun::class, $resource);
    }
}
