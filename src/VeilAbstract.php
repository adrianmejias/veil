<?php

declare(strict_types=1);

namespace AdrianMejias\Veil;

use AdrianMejias\Veil\Exceptions\NoAccessorFoundException;
use AdrianMejias\Veil\Exceptions\NoInstanceFoundException;
use AdrianMejias\Veil\Exceptions\NoMethodFoundException;

/**
 * Veil Abstract.
 *
 * @package Veil
 * @category Support
 */
abstract class VeilAbstract
{
    /**
     * Array of class instances.
     *
     * @var array|mixed[]
     * @static
     */
    protected static array $instances = [];

    /**
     * Get veil accessor.
     *
     * @return mixed
     * @static
     * @throws \AdrianMejias\Veil\Exceptions\NoAccessorFoundException
     */
    public static function getVeilAccessor()
    {
        throw new NoAccessorFoundException();
    }

    /**
     * Get veil instance.
     *
     * @return mixed
     * @static
     * @throws \AdrianMejias\Veil\Exceptions\NoInstanceFoundException
     */
    public static function getVeilInstance()
    {
        throw new NoInstanceFoundException();
    }

    /**
     * Get or set instance of eil.
     *
     * @return mixed
     * @static
     * @throws \AdrianMejias\Veil\Exceptions\NoAccessorFoundException
     * @throws \AdrianMejias\Veil\Exceptions\NoInstanceFoundException
     */
    public static function getInstance()
    {
        $accessor = static::getVeilAccessor();

        return static::$instances[$accessor] ??
            (static::$instances[$accessor] = static::getVeilInstance());
    }

    /**
     * Call a callback with an array of parameters.
     *
     * @param string $method
     * @param mixed $args
     * @return mixed
     * @static
     * @throws \AdrianMejias\Veil\Exceptions\NoMethodFoundException
     */
    public static function __callStatic(string $method, $args)
    {
        $instance = static::getInstance();

        if (! method_exists($instance, $method)) {
            throw new NoMethodFoundException();
        }

        switch (count($args)) {
            case 0:
                return $instance->$method();
            case 1:
                return $instance->$method($args[0]);
            case 2:
                return $instance->$method($args[0], $args[1]);
            case 3:
                return $instance->$method($args[0], $args[1], $args[2]);
            case 4:
                return $instance->$method(
                    $args[0],
                    $args[1],
                    $args[2],
                    $args[3]
                );
            default:
                $callback = fn (...$args) => $instance->$method(...$args);

                return call_user_func_array($callback, $args);
        }
    }
}
