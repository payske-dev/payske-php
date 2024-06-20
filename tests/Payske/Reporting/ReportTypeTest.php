<?php

namespace Payske\Reporting;

/**
 * @internal
 * @covers \Payske\Reporting\ReportType
 */
final class ReportTypeTest extends \PHPUnit\Framework\TestCase
{
    use \Payske\TestHelper;

    const TEST_RESOURCE_ID = 'activity.summary.1';

    public function testIsListable()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/reporting/report_types'
        );
        $resources = ReportType::all();
        static::assertInternalType('array', $resources->data);
        static::assertInstanceOf(\Payske\Reporting\ReportType::class, $resources->data[0]);
    }

    public function testIsRetrievable()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/reporting/report_types/' . self::TEST_RESOURCE_ID
        );
        $resource = ReportType::retrieve(self::TEST_RESOURCE_ID);
        static::assertInstanceOf(\Payske\Reporting\ReportType::class, $resource);
    }
}
