<?php

namespace Payske\Service;

/**
 * @internal
 * @covers \Payske\Service\SetupAttemptService
 */
final class SetupAttemptServiceTest extends \PHPUnit\Framework\TestCase
{
    use \Payske\TestHelper;

    /** @var \Payske\PayskeClient */
    private $client;

    /** @var SetupAttemptService */
    private $service;

    /**
     * @before
     */
    protected function setUpService()
    {
        $this->client = new \Payske\PayskeClient(['api_key' => 'sk_test_123', 'api_base' => MOCK_URL]);
        $this->service = new SetupAttemptService($this->client);
    }

    public function testAll()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/setup_attempts'
        );
        $resources = $this->service->all([
            'setup_intent' => 'si_123',
        ]);
        static::assertInternalType('array', $resources->data);
        static::assertInstanceOf(\Payske\SetupAttempt::class, $resources->data[0]);
    }
}
