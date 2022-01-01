<?php

declare(strict_types=1);

namespace AdrianMejias\Tests\Veils;

use AdrianMejias\Veil\VeilAbstract;

class NoInstanceVeil extends VeilAbstract
{
    /** @inheritDoc */
    public static function getVeilAccessor()
    {
        return 'NoInstance';
    }
}
