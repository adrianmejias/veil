<?php

declare(strict_types=1);

namespace AdrianMejias\Tests\Veils;

use AdrianMejias\Veil\VeilAbstract;

/**
 * FooVeil.
 *
 * @package Veil
 * @category Test
 * @method static string getVeilAccessor() Get veil accessor.
 * @method static \AdrianMejias\Tests\Veils\MyTestClass getVeilInstance()
 * Get veil instance.
 * @method static string bar() Say hi.
 */
class FooVeil extends VeilAbstract
{
    /** @inheritDoc */
    public static function getVeilAccessor()
    {
        return 'Foo';
    }

    /**
     * @inheritDoc
     * @return \AdrianMejias\Tests\Veils\MyTestClass
     */
    public static function getVeilInstance(): MyTestClass
    {
        return new MyTestClass;
    }
}
