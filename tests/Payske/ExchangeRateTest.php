<?php

namespace Payske;

/**
 * @internal
 * @covers \Payske\ExchangeRate
 */
final class ExchangeRateTest extends \PHPUnit\Framework\TestCase
{
    use TestHelper;

    public function testIsListable()
    {
        $this->stubRequest(
            'get',
            '/api/v1/exchange_rates',
            [],
            null,
            false,
            [
                'object' => 'list',
                'data' => [
                    [
                        'id' => 'eur',
                        'object' => 'exchange_rate',
                        'rates' => ['usd' => 1.18221],
                    ],
                    [
                        'id' => 'usd',
                        'object' => 'exchange_rate',
                        'rates' => ['eur' => 0.845876],
                    ],
                ],
            ]
        );

        $resources = ExchangeRate::all();
        static::assertInternalType('array', $resources->data);
        static::assertInstanceOf(\Payske\ExchangeRate::class, $resources->data[0]);
    }

    public function testIsRetrievable()
    {
        $this->stubRequest(
            'get',
            '/api/v1/exchange_rates/usd',
            [],
            null,
            false,
            [
                'id' => 'usd',
                'object' => 'exchange_rate',
                'rates' => ['eur' => 0.845876],
            ]
        );
        $resource = ExchangeRate::retrieve('usd');
        static::assertInstanceOf(\Payske\ExchangeRate::class, $resource);
    }
}
