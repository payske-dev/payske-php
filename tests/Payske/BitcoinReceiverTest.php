<?php

namespace Payske;

/**
 * @internal
 * @covers \Payske\BitcoinReceiver
 */
final class BitcoinReceiverTest extends \PHPUnit\Framework\TestCase
{
    use TestHelper;

    const TEST_RESOURCE_ID = 'btcrcv_123';

    // Because of the wildcard nature of sources, Payske-mock cannot currently
    // reliably return sources of a given type, so we create a fixture manually
    public function createFixture($params = [])
    {
        $base = [
            'id' => self::TEST_RESOURCE_ID,
            'object' => 'bitcoin_receiver',
            'metadata' => [],
        ];

        return BitcoinReceiver::constructFrom(
            \array_merge($params, $base),
            new Util\RequestOptions()
        );
    }

    public function testHasCorrectStandaloneUrl()
    {
        $resource = $this->createFixture();
        static::assertSame(
            '/api/v1/bitcoin/receivers/' . self::TEST_RESOURCE_ID,
            $resource->instanceUrl()
        );
    }

    public function testHasCorrectUrlForCustomer()
    {
        $resource = $this->createFixture(['customer' => 'cus_123']);
        static::assertSame(
            '/api/v1/customers/cus_123/sources/' . self::TEST_RESOURCE_ID,
            $resource->instanceUrl()
        );
    }

    public function testIsListable()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/bitcoin/receivers'
        );
        $resources = BitcoinReceiver::all();
        static::assertInternalType('array', $resources->data);
        static::assertSame(\Payske\BitcoinReceiver::class, \get_class($resources->data[0]));
    }

    public function testIsRetrievable()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/bitcoin/receivers/' . self::TEST_RESOURCE_ID
        );
        $resource = BitcoinReceiver::retrieve(self::TEST_RESOURCE_ID);
        static::assertSame(\Payske\BitcoinReceiver::class, \get_class($resource));
    }
}
