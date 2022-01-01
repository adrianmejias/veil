<?php

declare(strict_types=1);

namespace AdrianMejias\Tests\Veils;

/**
 * My Test Class.
 *
 * @package Veil
 * @category Test
 */
class MyTestClass
{
    /**
     * Say hi.
     *
     * @param mixed $args
     * @return string
     */
    public function bar(...$args): string
    {
        if (count($args) > 0) {
            return 'hi' . json_encode($args ?? []);
        }

        return 'hi';
    }
}
