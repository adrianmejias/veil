<?php

declare(strict_types=1);

namespace AdrianMejias\Tests\Veils;

use AdrianMejias\Veil\VeilAbstract;

class NoAccessorVeil extends VeilAbstract
{
    /** @inheritDoc */
    public static function getVeilInstance()
    {
        return new MyTestClass;
    }
}
