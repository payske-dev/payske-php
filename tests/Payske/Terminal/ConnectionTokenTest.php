<?php

namespace Payske\Terminal;

/**
 * @internal
 * @covers \Payske\Terminal\ConnectionToken
 */
final class ConnectionTokenTest extends \PHPUnit\Framework\TestCase
{
    use \Payske\TestHelper;

    public function testIsCreatable()
    {
        $this->expectsRequest(
            'post',
            '/api/v1/terminal/connection_tokens'
        );
        $resource = ConnectionToken::create();
        static::assertInstanceOf(\Payske\Terminal\ConnectionToken::class, $resource);
    }
}
