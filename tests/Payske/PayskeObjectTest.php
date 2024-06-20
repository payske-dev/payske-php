<?php

namespace Payske;

/**
 * @internal
 * @covers \Payske\PayskeObject
 */
final class PayskeObjectTest extends \PHPUnit\Framework\TestCase
{
    use TestHelper;

    /** @var \ReflectionMethod */
    private $deepCopyReflector;

    /** @var \ReflectionMethod */
    private $optsReflector;

    /**
     * @before
     */
    public function setUpReflectors()
    {
        // Sets up reflectors needed by some tests to access protected or
        // private attributes.

        // This is used to invoke the `deepCopy` protected function
        $this->deepCopyReflector = new \ReflectionMethod(\Payske\PayskeObject::class, 'deepCopy');
        $this->deepCopyReflector->setAccessible(true);

        // This is used to access the `_opts` protected variable
        $this->optsReflector = new \ReflectionProperty(\Payske\PayskeObject::class, '_opts');
        $this->optsReflector->setAccessible(true);
    }

    public function testArrayAccessorsSemantics()
    {
        $s = new PayskeObject();
        $s['foo'] = 'a';
        static::assertSame($s['foo'], 'a');
        static::assertTrue(isset($s['foo']));
        unset($s['foo']);
        static::assertFalse(isset($s['foo']));
    }

    public function testNormalAccessorsSemantics()
    {
        $s = new PayskeObject();
        $s->foo = 'a';
        static::assertSame($s->foo, 'a');
        static::assertTrue(isset($s->foo));
        $s->foo = null;
        static::assertFalse(isset($s->foo));
    }

    public function testArrayAccessorsMatchNormalAccessors()
    {
        $s = new PayskeObject();
        $s->foo = 'a';
        static::assertSame($s['foo'], 'a');

        $s['bar'] = 'b';
        static::assertSame($s->bar, 'b');
    }

    public function testCount()
    {
        $s = new PayskeObject();
        static::assertCount(0, $s);

        $s['key1'] = 'value1';
        static::assertCount(1, $s);

        $s['key2'] = 'value2';
        static::assertCount(2, $s);

        unset($s['key1']);
        static::assertCount(1, $s);
    }

    public function testKeys()
    {
        $s = new PayskeObject();
        $s->foo = 'bar';
        static::assertSame($s->keys(), ['foo']);
    }

    public function testValues()
    {
        $s = new PayskeObject();
        $s->foo = 'bar';
        static::assertSame($s->values(), ['bar']);
    }

    public function testToArray()
    {
        $array = [
            'foo' => 'a',
            'list' => [1, 2, 3],
            'null' => null,
            'metadata' => [
                'key' => 'value',
                1 => 'one',
            ],
        ];
        $s = PayskeObject::constructFrom($array);

        $converted = $s->toArray();

        static::assertInternalType('array', $converted);
        static::assertSame($array, $converted);
    }

    public function testToArrayRecursive()
    {
        // deep nested associative array (when contained in an indexed array)
        // or PayskeObject
        $nestedArray = ['id' => 7, 'foo' => 'bar'];
        $nested = PayskeObject::constructFrom($nestedArray);

        $obj = PayskeObject::constructFrom([
            'id' => 1,
            // simple associative array that contains a PayskeObject to help us
            // test deep recursion
            'nested' => ['object' => 'list', 'data' => [$nested]],
            'list' => [$nested],
        ]);

        $expected = [
            'id' => 1,
            'nested' => ['object' => 'list', 'data' => [$nestedArray]],
            'list' => [$nestedArray],
        ];

        static::assertSame($expected, $obj->toArray());
    }

    public function testNonexistentProperty()
    {
        $capture = \tmpfile();
        $origErrorLog = \ini_set('error_log', \stream_get_meta_data($capture)['uri']);

        try {
            $s = new PayskeObject();
            static::assertNull($s->nonexistent);

            static::assertRegExp(
                '/Payske Notice: Undefined property of Payske\\\\PayskeObject instance: nonexistent/',
                \stream_get_contents($capture)
            );
        } finally {
            \ini_set('error_log', $origErrorLog);
            \fclose($capture);
        }
    }

    public function testPropertyDoesNotExists()
    {
        $s = new PayskeObject();
        static::assertNull($s['nonexistent']);
    }

    public function testJsonEncode()
    {
        $s = new PayskeObject();
        $s->foo = 'a';

        static::assertSame('{"foo":"a"}', \json_encode($s));
    }

    public function testToString()
    {
        $s = new PayskeObject();
        $s->foo = 'a';

        $string = (string) $s;
        $expected = <<<'EOS'
Payske\PayskeObject JSON: {
    "foo": "a"
}
EOS;
        static::assertSame($expected, $string);
    }

    public function testReplaceNewNestedUpdatable()
    {
        $s = new PayskeObject();

        $s->metadata = ['bar'];
        static::assertSame($s->metadata, ['bar']);
        $s->metadata = ['baz', 'qux'];
        static::assertSame($s->metadata, ['baz', 'qux']);
    }

    public function testSetPermanentAttribute()
    {
        $this->expectException(\InvalidArgumentException::class);

        $s = new PayskeObject();
        $s->id = 'abc_123';
    }

    public function testSetEmptyStringValue()
    {
        $this->expectException(\InvalidArgumentException::class);

        $s = new PayskeObject();
        $s->foo = '';
    }

    public function testSerializeParametersOnEmptyObject()
    {
        $obj = PayskeObject::constructFrom([]);
        static::assertSame([], $obj->serializeParameters());
    }

    public function testSerializeParametersOnNewObjectWithSubObject()
    {
        $obj = new PayskeObject();
        $obj->metadata = ['foo' => 'bar'];
        static::assertSame(['metadata' => ['foo' => 'bar']], $obj->serializeParameters());
    }

    public function testSerializeParametersOnBasicObject()
    {
        $obj = PayskeObject::constructFrom(['foo' => null]);
        $obj->updateAttributes(['foo' => 'bar']);
        static::assertSame(['foo' => 'bar'], $obj->serializeParameters());
    }

    public function testSerializeParametersOnMoreComplexObject()
    {
        $obj = PayskeObject::constructFrom([
            'foo' => PayskeObject::constructFrom([
                'bar' => null,
                'baz' => null,
            ]),
        ]);
        $obj->foo->bar = 'newbar';
        static::assertSame(['foo' => ['bar' => 'newbar']], $obj->serializeParameters());
    }

    public function testSerializeParametersOnArray()
    {
        $obj = PayskeObject::constructFrom([
            'foo' => null,
        ]);
        $obj->foo = ['new-value'];
        static::assertSame(['foo' => ['new-value']], $obj->serializeParameters());
    }

    public function testSerializeParametersOnArrayThatShortens()
    {
        $obj = PayskeObject::constructFrom([
            'foo' => ['0-index', '1-index', '2-index'],
        ]);
        $obj->foo = ['new-value'];
        static::assertSame(['foo' => ['new-value']], $obj->serializeParameters());
    }

    public function testSerializeParametersOnArrayThatLengthens()
    {
        $obj = PayskeObject::constructFrom([
            'foo' => ['0-index', '1-index', '2-index'],
        ]);
        $obj->foo = \array_fill(0, 4, 'new-value');
        static::assertSame(['foo' => \array_fill(0, 4, 'new-value')], $obj->serializeParameters());
    }

    public function testSerializeParametersOnArrayOfHashes()
    {
        $obj = PayskeObject::constructFrom(['foo' => null]);
        $obj->foo = [
            PayskeObject::constructFrom(['bar' => null]),
        ];

        $obj->foo[0]->bar = 'baz';
        static::assertSame(['foo' => [['bar' => 'baz']]], $obj->serializeParameters());
    }

    public function testSerializeParametersDoesNotIncludeUnchangedValues()
    {
        $obj = PayskeObject::constructFrom([
            'foo' => null,
        ]);
        static::assertSame([], $obj->serializeParameters());
    }

    public function testSerializeParametersOnUnchangedArray()
    {
        $obj = PayskeObject::constructFrom([
            'foo' => ['0-index', '1-index', '2-index'],
        ]);
        $obj->foo = ['0-index', '1-index', '2-index'];
        static::assertSame([], $obj->serializeParameters());
    }

    public function testSerializeParametersWithPayskeObject()
    {
        $obj = PayskeObject::constructFrom([]);
        $obj->metadata = PayskeObject::constructFrom(['foo' => 'bar']);

        $serialized = $obj->serializeParameters();
        static::assertSame(['foo' => 'bar'], $serialized['metadata']);
    }

    public function testSerializeParametersOnReplacedPayskeObject()
    {
        $obj = PayskeObject::constructFrom([
            'source' => PayskeObject::constructFrom(['bar' => 'foo']),
        ]);
        $obj->source = PayskeObject::constructFrom(['baz' => 'foo']);

        $serialized = $obj->serializeParameters();
        static::assertSame(['baz' => 'foo'], $serialized['source']);
    }

    public function testSerializeParametersOnReplacedPayskeObjectWhichIsMetadata()
    {
        $obj = PayskeObject::constructFrom([
            'metadata' => PayskeObject::constructFrom(['bar' => 'foo']),
        ]);
        $obj->metadata = PayskeObject::constructFrom(['baz' => 'foo']);

        $serialized = $obj->serializeParameters();
        static::assertSame(['bar' => '', 'baz' => 'foo'], $serialized['metadata']);
    }

    public function testSerializeParametersOnArrayOfPayskeObjects()
    {
        $obj = PayskeObject::constructFrom([]);
        $obj->metadata = [
            PayskeObject::constructFrom(['foo' => 'bar']),
        ];

        $serialized = $obj->serializeParameters();
        static::assertSame([['foo' => 'bar']], $serialized['metadata']);
    }

    public function testSerializeParametersOnSetApiResource()
    {
        $customer = Customer::constructFrom(['id' => 'cus_123']);
        $obj = PayskeObject::constructFrom([]);

        // the key here is that the property is set explicitly (and therefore
        // marked as unsaved), which is why it gets included below
        $obj->customer = $customer;

        $serialized = $obj->serializeParameters();
        static::assertSame(['customer' => $customer], $serialized);
    }

    public function testSerializeParametersOnNotSetApiResource()
    {
        $customer = Customer::constructFrom(['id' => 'cus_123']);
        $obj = PayskeObject::constructFrom(['customer' => $customer]);

        $serialized = $obj->serializeParameters();
        static::assertSame([], $serialized);
    }

    public function testSerializeParametersOnApiResourceFlaggedWithSaveWithParent()
    {
        $customer = Customer::constructFrom(['id' => 'cus_123']);
        $customer->saveWithParent = true;

        $obj = PayskeObject::constructFrom(['customer' => $customer]);

        $serialized = $obj->serializeParameters();
        static::assertSame(['customer' => []], $serialized);
    }

    public function testSerializeParametersRaisesExceotionOnOtherEmbeddedApiResources()
    {
        // This customer doesn't have an ID and therefore the library doesn't know
        // what to do with it and throws an InvalidArgumentException because it's
        // probably not what the user expected to happen.
        $customer = Customer::constructFrom([]);

        $obj = PayskeObject::constructFrom([]);
        $obj->customer = $customer;

        try {
            $serialized = $obj->serializeParameters();
            static::fail('Did not raise error');
        } catch (\InvalidArgumentException $e) {
            static::assertSame(
                'Cannot save property `customer` containing an API resource of type Payske\\Customer. ' .
                    "It doesn't appear to be persisted and is not marked as `saveWithParent`.",
                $e->getMessage()
            );
        } catch (\Exception $e) {
            static::fail('Unexpected exception: ' . \get_class($e));
        }
    }

    public function testSerializeParametersForce()
    {
        $obj = PayskeObject::constructFrom([
            'id' => 'id',
            'metadata' => PayskeObject::constructFrom([
                'bar' => 'foo',
            ]),
        ]);

        $serialized = $obj->serializeParameters(true);
        static::assertSame(['id' => 'id', 'metadata' => ['bar' => 'foo']], $serialized);
    }

    public function testDirty()
    {
        $obj = PayskeObject::constructFrom([
            'id' => 'id',
            'metadata' => PayskeObject::constructFrom([
                'bar' => 'foo',
            ]),
        ]);

        // note that `$force` and `dirty()` are for different things, but are
        // functionally equivalent
        $obj->dirty();

        $serialized = $obj->serializeParameters();
        static::assertSame(['id' => 'id', 'metadata' => ['bar' => 'foo']], $serialized);
    }

    public function testDeepCopy()
    {
        $opts = [
            'api_base' => Payske::$apiBase,
            'api_key' => 'apikey',
        ];
        $values = [
            'id' => 1,
            'name' => 'Payske',
            'arr' => [
                PayskeObject::constructFrom(['id' => 'index0'], $opts),
                'index1',
                2,
            ],
            'map' => [
                '0' => PayskeObject::constructFrom(['id' => 'index0'], $opts),
                '1' => 'index1',
                '2' => 2,
            ],
        ];

        $copyValues = $this->deepCopyReflector->invoke(null, $values);

        // we can't compare the hashes directly because they have embedded
        // objects which are different from each other
        static::assertSame($values['id'], $copyValues['id']);
        static::assertSame($values['name'], $copyValues['name']);
        static::assertSame(\count($values['arr']), \count($copyValues['arr']));

        // internal values of the copied PayskeObject should be the same,
        // but the object itself should be new (hence the assertNotSame)
        static::assertSame($values['arr'][0]['id'], $copyValues['arr'][0]['id']);
        static::assertNotSame($values['arr'][0], $copyValues['arr'][0]);

        // likewise, the Util\RequestOptions instance in _opts should have
        // copied values but be a new instance
        static::assertSame(
            $this->optsReflector->getValue($values['arr'][0])->apiKey,
            $this->optsReflector->getValue($copyValues['arr'][0])->apiKey
        );
        static::assertNotSame(
            $this->optsReflector->getValue($values['arr'][0]),
            $this->optsReflector->getValue($copyValues['arr'][0])
        );

        // scalars however, can be compared
        static::assertSame($values['arr'][1], $copyValues['arr'][1]);
        static::assertSame($values['arr'][2], $copyValues['arr'][2]);

        // and a similar story with the hash
        static::assertSame($values['map']['0']['id'], $copyValues['map']['0']['id']);
        static::assertNotSame($values['map']['0'], $copyValues['map']['0']);
        static::assertNotSame(
            $this->optsReflector->getValue($values['arr'][0]),
            $this->optsReflector->getValue($copyValues['arr'][0])
        );
        static::assertSame(
            $this->optsReflector->getValue($values['map']['0'])->apiKey,
            $this->optsReflector->getValue($copyValues['map']['0'])->apiKey
        );
        static::assertNotSame(
            $this->optsReflector->getValue($values['map']['0']),
            $this->optsReflector->getValue($copyValues['map']['0'])
        );
        static::assertSame($values['map']['1'], $copyValues['map']['1']);
        static::assertSame($values['map']['2'], $copyValues['map']['2']);
    }

    public function testDeepCopyMaintainClass()
    {
        $charge = Charge::constructFrom(['id' => 1], null);
        $copyCharge = $this->deepCopyReflector->invoke(null, $charge);
        static::assertSame(\get_class($charge), \get_class($copyCharge));
    }

    public function testIsDeleted()
    {
        $obj = PayskeObject::constructFrom([]);
        static::assertFalse($obj->isDeleted());

        $obj = PayskeObject::constructFrom(['deleted' => false]);
        static::assertFalse($obj->isDeleted());

        $obj = PayskeObject::constructFrom(['deleted' => true]);
        static::assertTrue($obj->isDeleted());
    }

    public function testDeserializeEmptyMetadata()
    {
        $obj = PayskeObject::constructFrom([
            'metadata' => [],
        ]);

        static::assertInstanceOf(\Payske\PayskeObject::class, $obj->metadata);
    }

    public function testDeserializeMetadataWithKeyNamedMetadata()
    {
        $obj = PayskeObject::constructFrom([
            'metadata' => ['metadata' => 'value'],
        ]);

        static::assertInstanceOf(\Payske\PayskeObject::class, $obj->metadata);
        static::assertSame('value', $obj->metadata->metadata);
    }
}
