<?php

declare(strict_types=1);

namespace AdrianMejias\Veil\Exceptions;

use Exception;

class NoAccessorFoundException extends Exception
{
    /**
     * String representation of the exception.
     *
     * @return string
     */
    public function __toString(): string
    {
        return 'No accessor found.';
    }
}
