<?php

namespace Payske;

/**
 * @internal
 * @covers \Payske\SetupIntent
 */
final class SetupIntentTest extends \PHPUnit\Framework\TestCase
{
    use TestHelper;

    const TEST_RESOURCE_ID = 'seti_123';

    public function testIsListable()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/setup_intents'
        );
        $resources = SetupIntent::all();
        static::assertInternalType('array', $resources->data);
        static::assertInstanceOf(\Payske\SetupIntent::class, $resources->data[0]);
    }

    public function testIsRetrievable()
    {
        $this->expectsRequest(
            'get',
            '/api/v1/setup_intents/' . self::TEST_RESOURCE_ID
        );
        $resource = SetupIntent::retrieve(self::TEST_RESOURCE_ID);
        static::assertInstanceOf(\Payske\SetupIntent::class, $resource);
    }

    public function testIsCreatable()
    {
        $this->expectsRequest(
            'post',
            '/api/v1/setup_intents'
        );
        $resource = SetupIntent::create([
            'payment_method_types' => ['card'],
        ]);
        static::assertInstanceOf(\Payske\SetupIntent::class, $resource);
    }

    public function testIsSaveable()
    {
        $resource = SetupIntent::retrieve(self::TEST_RESOURCE_ID);
        $resource->metadata['key'] = 'value';
        $this->expectsRequest(
            'post',
            '/api/v1/setup_intents/' . self::TEST_RESOURCE_ID
        );
        $resource->save();
        static::assertInstanceOf(\Payske\SetupIntent::class, $resource);
    }

    public function testIsUpdatable()
    {
        $this->expectsRequest(
            'post',
            '/api/v1/setup_intents/' . self::TEST_RESOURCE_ID
        );
        $resource = SetupIntent::update(
            self::TEST_RESOURCE_ID,
            [
                'metadata' => ['key' => 'value'],
            ]
        );
        static::assertInstanceOf(\Payske\SetupIntent::class, $resource);
    }

    public function testIsCancelable()
    {
        $resource = SetupIntent::retrieve(self::TEST_RESOURCE_ID);
        $this->expectsRequest(
            'post',
            '/api/v1/setup_intents/' . self::TEST_RESOURCE_ID . '/cancel'
        );
        $resource->cancel();
        static::assertInstanceOf(\Payske\SetupIntent::class, $resource);
    }

    public function testIsConfirmable()
    {
        $resource = SetupIntent::retrieve(self::TEST_RESOURCE_ID);
        $this->expectsRequest(
            'post',
            '/api/v1/setup_intents/' . self::TEST_RESOURCE_ID . '/confirm'
        );
        $resource->confirm();
        static::assertInstanceOf(\Payske\SetupIntent::class, $resource);
    }
}
