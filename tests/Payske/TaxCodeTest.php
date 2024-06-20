<?php

namespace Payske;

/**
 * @internal
 * @covers \Payske\TaxCode
 */
final class TaxCodeTest extends \PHPUnit\Framework\TestCase
{
    use TestHelper;

    const TEST_RESOURCE_ID = 'txcd_123';

    public function testIsListable()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/tax_codes'
        );
        $resources = TaxCode::all();
        static::assertInternalType('array', $resources->data);
        static::assertInstanceOf(\Payske\TaxCode::class, $resources->data[0]);
    }

    public function testIsRetrievable()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/tax_codes/' . self::TEST_RESOURCE_ID
        );
        $resource = TaxCode::retrieve(self::TEST_RESOURCE_ID);
        static::assertInstanceOf(\Payske\TaxCode::class, $resource);
    }
}
