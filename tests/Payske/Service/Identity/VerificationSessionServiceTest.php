<?php

namespace Payske\Service\Identity;

/**
 * @internal
 * @covers \Payske\Service\Identity\VerificationSessionService
 */
final class VerificationSessionServiceTest extends \PHPUnit\Framework\TestCase
{
    use \Payske\TestHelper;

    const TEST_RESOURCE_ID = 'vs_123';

    /** @var \Payske\PayskeClient */
    private $client;

    /** @var VerificationSessionService */
    private $service;

    /**
     * @before
     */
    protected function setUpService()
    {
        $this->client = new \Payske\PayskeClient(['api_key' => 'sk_test_123', 'api_base' => MOCK_URL]);
        $this->service = new VerificationSessionService($this->client);
    }

    public function testAll()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/identity/verification_sessions'
        );
        $resources = $this->service->all();
        static::assertInternalType('array', $resources->data);
        static::assertInstanceOf(\Payske\Identity\VerificationSession::class, $resources->data[0]);
    }

    public function testCreate()
    {
        $this->expectsRequest(
            'post',
            '/api/v1/identity/verification_sessions'
        );
        $resource = $this->service->create([
            'type' => 'id_number',
        ]);
        static::assertInstanceOf(\Payske\Identity\VerificationSession::class, $resource);
    }

    public function testUpdate()
    {
        $this->expectsRequest(
            'post',
            '/api/v1/identity/verification_sessions/' . self::TEST_RESOURCE_ID
        );
        $resource = $this->service->update(self::TEST_RESOURCE_ID, [
            'metadata' => ['key' => 'value'],
        ]);
        static::assertInstanceOf(\Payske\Identity\VerificationSession::class, $resource);
    }

    public function testCancel()
    {
        $this->expectsRequest(
            'post',
            '/api/v1/identity/verification_sessions/' . self::TEST_RESOURCE_ID . '/cancel'
        );
        $resource = $this->service->cancel(self::TEST_RESOURCE_ID);
        static::assertInstanceOf(\Payske\Identity\VerificationSession::class, $resource);
    }

    public function testRedact()
    {
        $this->expectsRequest(
            'post',
            '/api/v1/identity/verification_sessions/' . self::TEST_RESOURCE_ID . '/redact'
        );
        $resource = $this->service->redact(self::TEST_RESOURCE_ID);
        static::assertInstanceOf(\Payske\Identity\VerificationSession::class, $resource);
    }
}
