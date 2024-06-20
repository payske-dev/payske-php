<?php

namespace Payske;

/**
 * @internal
 * @covers \Payske\Payske
 */
final class PayskeTest extends \PHPUnit\Framework\TestCase
{
    use TestHelper;

    /** @var array */
    protected $orig;

    /**
     * @before
     */
    public function saveOriginalValues()
    {
        $this->orig = [
            'caBundlePath' => Payske::$caBundlePath,
        ];
    }

    /**
     * @after
     */
    public function restoreOriginalValues()
    {
        Payske::$caBundlePath = $this->orig['caBundlePath'];
    }

    public function testCABundlePathAccessors()
    {
        Payske::setCABundlePath('path/to/ca/bundle');
        static::assertSame('path/to/ca/bundle', Payske::getCABundlePath());
    }
}
