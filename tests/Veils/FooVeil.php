<?php

declare(strict_types=1);

namespace AdrianMejias\Tests\Veils;

use AdrianMejias\Veil\VeilAbstract;

class FooVeil extends VeilAbstract
{
    /** @inheritDoc */
    public static function getVeilAccessor()
    {
        return 'Foo';
    }

    /** @inheritDoc */
    public static function getVeilInstance()
    {
        return new MyTestClass;
    }
}
