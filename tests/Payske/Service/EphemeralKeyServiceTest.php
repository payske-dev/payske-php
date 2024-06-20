<?php

namespace Payske\Service;

/**
 * @internal
 * @covers \Payske\Service\EphemeralKeyService
 */
final class EphemeralKeyServiceTest extends \PHPUnit\Framework\TestCase
{
    use \Payske\TestHelper;

    const TEST_RESOURCE_ID = 'ek_123';

    /** @var \Payske\PayskeClient */
    private $client;

    /** @var EphemeralKeyService */
    private $service;

    /**
     * @before
     */
    protected function setUpService()
    {
        $this->client = new \Payske\PayskeClient(['api_key' => 'sk_test_123', 'api_base' => MOCK_URL]);
        $this->service = new EphemeralKeyService($this->client);
    }

    public function testCreate()
    {
        $this->expectsRequest(
            'post',
            '/api/v1/ephemeral_keys',
            null,
            ['Payske-Version: 2017-05-25']
        );
        $resource = $this->service->create([
            'customer' => 'cus_123',
        ], ['Payske_version' => '2017-05-25']);
        static::assertInstanceOf(\Payske\EphemeralKey::class, $resource);
    }

    public function testCreateWithoutExplicitApiVersion()
    {
        $this->expectException(\InvalidArgumentException::class);

        $resource = $this->service->create([
            'customer' => 'cus_123',
        ]);
    }

    public function testDelete()
    {
        $this->expectsRequest(
            'delete',
            '/api/v1/ephemeral_keys/' . self::TEST_RESOURCE_ID
        );
        $resource = $this->service->delete(self::TEST_RESOURCE_ID);
        static::assertInstanceOf(\Payske\EphemeralKey::class, $resource);
    }
}
