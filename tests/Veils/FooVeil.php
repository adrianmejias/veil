<?php

declare(strict_types=1);

namespace Tests\Veils;

use AdrianMejias\Veil\VeilAbstract;

final class FooVeil extends VeilAbstract
{
    /** @inheritDoc */
    public static function getVeilAccessor()
    {
        return 'Foo';
    }

    /** @inheritDoc */
    public static function getVeilInstance()
    {
        return new class
        {
            /**
             * Say hi.
             *
             * @return string
             */
            public function bar(): string
            {
                return 'hi';
            }
        };
    }
}
