<?php

namespace Payske;

/**
 * @internal
 * @covers \Payske\TaxId
 */
final class TaxIdTest extends \PHPUnit\Framework\TestCase
{
    use TestHelper;

    const TEST_CUSTOMER_ID = 'cus_123';
    const TEST_RESOURCE_ID = 'txi_123';

    public function testHasCorrectUrl()
    {
        $resource = \Payske\Customer::retrieveTaxId(self::TEST_CUSTOMER_ID, self::TEST_RESOURCE_ID);
        static::assertSame(
            '/api/v1/customers/' . self::TEST_CUSTOMER_ID . '/tax_ids/' . self::TEST_RESOURCE_ID,
            $resource->instanceUrl()
        );
    }

    public function testIsDeletable()
    {
        $resource = \Payske\Customer::retrieveTaxId(self::TEST_CUSTOMER_ID, self::TEST_RESOURCE_ID);
        $this->expectsRequest(
            'delete',
            '/api/v1/customers/' . self::TEST_CUSTOMER_ID . '/tax_ids/' . self::TEST_RESOURCE_ID
        );
        $resource->delete();
        static::assertInstanceOf(\Payske\TaxId::class, $resource);
    }
}
