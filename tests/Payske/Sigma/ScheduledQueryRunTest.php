<?php

namespace Payske\Sigma;

/**
 * @internal
 * @covers \Payske\Sigma\ScheduledQueryRun
 */
final class ScheduledQueryRunTest extends \PHPUnit\Framework\TestCase
{
    use \Payske\TestHelper;

    const TEST_RESOURCE_ID = 'sqr_123';

    public function testIsListable()
    {
        $resources = ScheduledQueryRun::all();
        static::assertInternalType('array', $resources->data);
        static::assertInstanceOf(\Payske\Sigma\ScheduledQueryRun::class, $resources->data[0]);
    }

    public function testIsRetrievable()
    {
        $resource = ScheduledQueryRun::retrieve(self::TEST_RESOURCE_ID);
        static::assertInstanceOf(\Payske\Sigma\ScheduledQueryRun::class, $resource);
    }
}
