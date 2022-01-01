<?php

declare(strict_types=1);

namespace AdrianMejias\Veil\Exceptions;

use Exception;

/**
 * Veil no method found exception.
 *
 * @package Veil
 * @category Support
 */
class NoInstanceMethodFoundException extends Exception
{
    /**
     * String representation of the exception.
     *
     * @return string
     */
    public function __toString(): string
    {
        return 'No instance method found.';
    }
}
