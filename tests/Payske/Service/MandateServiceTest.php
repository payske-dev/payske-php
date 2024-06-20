<?php

namespace Payske\Service;

/**
 * @internal
 * @covers \Payske\Service\MandateService
 */
final class MandateServiceTest extends \PHPUnit\Framework\TestCase
{
    use \Payske\TestHelper;

    const TEST_RESOURCE_ID = 'mandate_123';

    /** @var \Payske\PayskeClient */
    private $client;

    /** @var MandateService */
    private $service;

    /**
     * @before
     */
    protected function setUpService()
    {
        $this->client = new \Payske\PayskeClient(['api_key' => 'sk_test_123', 'api_base' => MOCK_URL]);
        $this->service = new MandateService($this->client);
    }

    public function testRetrieve()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/mandates/' . self::TEST_RESOURCE_ID
        );
        $resource = $this->service->retrieve(self::TEST_RESOURCE_ID);
        static::assertInstanceOf(\Payske\Mandate::class, $resource);
    }
}
