<?php

declare(strict_types=1);

namespace AdrianMejias\Veil\Exceptions;

use Exception;

/**
 * Veil autoload register exception.
 *
 * @package Veil
 * @category Support
 */
class AutoloadRegisterException extends Exception
{
    /**
     * String representation of the exception.
     *
     * @return string
     */
    public function __toString(): string
    {
        return 'Could not register autoload.';
    }
}
