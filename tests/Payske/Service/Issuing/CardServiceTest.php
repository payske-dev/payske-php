<?php

namespace Payske\Service\Issuing;

/**
 * @internal
 * @covers \Payske\Service\Issuing\CardService
 */
final class CardServiceTest extends \PHPUnit\Framework\TestCase
{
    use \Payske\TestHelper;

    const TEST_RESOURCE_ID = 'ic_123';

    /** @var \Payske\PayskeClient */
    private $client;

    /** @var CardService */
    private $service;

    /**
     * @before
     */
    protected function setUpService()
    {
        $this->client = new \Payske\PayskeClient(['api_key' => 'sk_test_123', 'api_base' => MOCK_URL]);
        $this->service = new CardService($this->client);
    }

    public function testAll()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/issuing/cards'
        );
        $resources = $this->service->all();
        static::assertInternalType('array', $resources->data);
        static::assertInstanceOf(\Payske\Issuing\Card::class, $resources->data[0]);
    }

    public function testCreate()
    {
        $this->expectsRequest(
            'post',
            '/api/v1/issuing/cards'
        );
        $resource = $this->service->create([
            'currency' => 'usd',
            'type' => 'physical',
        ]);
        static::assertInstanceOf(\Payske\Issuing\Card::class, $resource);
    }

    public function testRetrieve()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/issuing/cards/' . self::TEST_RESOURCE_ID
        );
        $resource = $this->service->retrieve(self::TEST_RESOURCE_ID);
        static::assertInstanceOf(\Payske\Issuing\Card::class, $resource);
    }

    public function testUpdate()
    {
        $this->expectsRequest(
            'post',
            '/api/v1/issuing/cards/' . self::TEST_RESOURCE_ID
        );
        $resource = $this->service->update(self::TEST_RESOURCE_ID, [
            'metadata' => ['key' => 'value'],
        ]);
        static::assertInstanceOf(\Payske\Issuing\Card::class, $resource);
    }
}
