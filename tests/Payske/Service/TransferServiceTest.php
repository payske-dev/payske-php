<?php

namespace Payske\Service;

/**
 * @internal
 * @covers \Payske\Service\TransferService
 */
final class TransferServiceTest extends \PHPUnit\Framework\TestCase
{
    use \Payske\TestHelper;

    const TEST_RESOURCE_ID = 'tr_123';
    const TEST_REVERSAL_ID = 'trr_123';

    /** @var \Payske\PayskeClient */
    private $client;

    /** @var TransferService */
    private $service;

    /**
     * @before
     */
    protected function setUpService()
    {
        $this->client = new \Payske\PayskeClient(['api_key' => 'sk_test_123', 'api_base' => MOCK_URL]);
        $this->service = new TransferService($this->client);
    }

    public function testAll()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/transfers'
        );
        $resources = $this->service->all();
        static::assertInternalType('array', $resources->data);
        static::assertInstanceOf(\Payske\Transfer::class, $resources->data[0]);
    }

    public function testAllReversals()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/transfers/' . self::TEST_RESOURCE_ID . '/reversals'
        );
        $resources = $this->service->allReversals(self::TEST_RESOURCE_ID);
        static::assertInternalType('array', $resources->data);
        static::assertInstanceOf(\Payske\TransferReversal::class, $resources->data[0]);
    }

    public function testCancel()
    {
        // Payske-mock does not support this anymore so we stub it
        $this->stubRequest(
            'post',
            '/api/v1/transfers/' . self::TEST_RESOURCE_ID . '/cancel',
            [],
            null,
            false,
            [
                'object' => 'transfer',
            ]
        );
        $resource = $this->service->cancel(self::TEST_RESOURCE_ID);
        static::assertInstanceOf(\Payske\Transfer::class, $resource);
    }

    public function testCreate()
    {
        $this->expectsRequest(
            'post',
            '/api/v1/transfers'
        );
        $resource = $this->service->create([
            'amount' => 100,
            'currency' => 'usd',
            'destination' => 'acct_123',
        ]);
        static::assertInstanceOf(\Payske\Transfer::class, $resource);
    }

    public function testCreateReversal()
    {
        $this->expectsRequest(
            'post',
            '/api/v1/transfers/' . self::TEST_RESOURCE_ID . '/reversals'
        );
        $resource = $this->service->createReversal(self::TEST_RESOURCE_ID);
        static::assertInstanceOf(\Payske\TransferReversal::class, $resource);
    }

    public function testRetrieve()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/transfers/' . self::TEST_RESOURCE_ID
        );
        $resource = $this->service->retrieve(self::TEST_RESOURCE_ID);
        static::assertInstanceOf(\Payske\Transfer::class, $resource);
    }

    public function testRetrieveReversal()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/transfers/' . self::TEST_RESOURCE_ID . '/reversals/' . self::TEST_REVERSAL_ID
        );
        $resource = $this->service->retrieveReversal(self::TEST_RESOURCE_ID, self::TEST_REVERSAL_ID);
        static::assertInstanceOf(\Payske\TransferReversal::class, $resource);
    }

    public function testUpdate()
    {
        $this->expectsRequest(
            'post',
            '/api/v1/transfers/' . self::TEST_RESOURCE_ID
        );
        $resource = $this->service->update(self::TEST_RESOURCE_ID, [
            'metadata' => ['key' => 'value'],
        ]);
        static::assertInstanceOf(\Payske\Transfer::class, $resource);
    }

    public function testUpdateReversal()
    {
        $this->expectsRequest(
            'post',
            '/api/v1/transfers/' . self::TEST_RESOURCE_ID . '/reversals/' . self::TEST_REVERSAL_ID
        );
        $resource = $this->service->updateReversal(
            self::TEST_RESOURCE_ID,
            self::TEST_REVERSAL_ID,
            [
                'metadata' => ['key' => 'value'],
            ]
        );
        static::assertInstanceOf(\Payske\TransferReversal::class, $resource);
    }
}
