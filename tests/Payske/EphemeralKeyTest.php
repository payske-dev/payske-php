<?php

namespace Payske;

/**
 * @internal
 * @covers \Payske\EphemeralKey
 */
final class EphemeralKeyTest extends \PHPUnit\Framework\TestCase
{
    use TestHelper;

    public function testIsCreatable()
    {
        $this->expectsRequest(
            'post',
            '/api/v1/ephemeral_keys',
            null,
            ['Payske-Version: 2017-05-25']
        );
        $resource = EphemeralKey::create([
            'customer' => 'cus_123',
        ], ['Payske_version' => '2017-05-25']);
        static::assertInstanceOf(\Payske\EphemeralKey::class, $resource);
    }

    public function testIsNotCreatableWithoutAnExplicitApiVersion()
    {
        $this->expectException(\InvalidArgumentException::class);

        $resource = EphemeralKey::create([
            'customer' => 'cus_123',
        ]);
    }

    public function testIsDeletable()
    {
        $key = EphemeralKey::create([
            'customer' => 'cus_123',
        ], ['Payske_version' => '2017-05-25']);
        $this->expectsRequest(
            'delete',
            '/api/v1/ephemeral_keys/' . $key->id
        );
        $resource = $key->delete();
        static::assertInstanceOf(\Payske\EphemeralKey::class, $resource);
    }
}
