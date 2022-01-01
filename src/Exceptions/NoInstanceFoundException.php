<?php

declare(strict_types=1);

namespace AdrianMejias\Veil\Exceptions;

use Exception;

/**
 * Veil no instance found exception.
 *
 * @package Veil
 * @category Support
 */
class NoInstanceFoundException extends Exception
{
    /**
     * String representation of the exception.
     *
     * @return string
     */
    public function __toString(): string
    {
        return 'No instance found.';
    }
}
