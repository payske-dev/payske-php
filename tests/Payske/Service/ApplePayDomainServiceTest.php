<?php

namespace Payske\Service;

/**
 * @internal
 * @covers \Payske\Service\ApplePayDomainService
 */
final class ApplePayDomainServiceTest extends \PHPUnit\Framework\TestCase
{
    use \Payske\TestHelper;

    const TEST_RESOURCE_ID = 'apwc_123';

    /** @var \Payske\PayskeClient */
    private $client;

    /** @var ApplePayDomainService */
    private $service;

    /**
     * @before
     */
    protected function setUpService()
    {
        $this->client = new \Payske\PayskeClient(['api_key' => 'sk_test_123', 'api_base' => MOCK_URL]);
        $this->service = new ApplePayDomainService($this->client);
    }

    public function testAll()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/apple_pay/domains'
        );
        $resources = $this->service->all();
        static::assertInternalType('array', $resources->data);
        static::assertInstanceOf(\Payske\ApplePayDomain::class, $resources->data[0]);
    }

    public function testCreate()
    {
        $this->expectsRequest(
            'post',
            '/api/v1/apple_pay/domains'
        );
        $resource = $this->service->create([
            'domain_name' => 'domain',
        ]);
        static::assertInstanceOf(\Payske\ApplePayDomain::class, $resource);
    }

    public function testDelete()
    {
        $this->expectsRequest(
            'delete',
            '/api/v1/apple_pay/domains/' . self::TEST_RESOURCE_ID
        );
        $resource = $this->service->delete(self::TEST_RESOURCE_ID);
        static::assertInstanceOf(\Payske\ApplePayDomain::class, $resource);
    }

    public function testRetrieve()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/apple_pay/domains/' . self::TEST_RESOURCE_ID
        );
        $resource = $this->service->retrieve(self::TEST_RESOURCE_ID);
        static::assertInstanceOf(\Payske\ApplePayDomain::class, $resource);
    }
}
