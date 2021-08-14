<?php

declare(strict_types=1);

namespace AdrianMejias\Veil;

use AdrianMejias\Veil\Exceptions\NoAccessorFoundException;
use AdrianMejias\Veil\Exceptions\NoInstanceFoundException;

abstract class VeilAbstract
{
    /**
     * Array of class instances.
     *
     * @var array
     */
    private static $instances = [];

    /**
     * Get veil accessor.
     *
     * @return mixed|false
     * @throws \AdrianMejias\Veil\Exceptions\NoAccessorFoundException
     */
    public static function getVeilAccessor()
    {
        throw new NoAccessorFoundException();
    }

    /**
     * Get veil instance.
     *
     * @return mixed|false
     * @throws \AdrianMejias\Veil\Exceptions\NoInstanceFoundException
     */
    public static function getVeilInstance()
    {
        throw new NoInstanceFoundException();
    }

    /**
     * Get or set instance of eil.
     *
     * @return mixed|false
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
     * @param mixed $method
     * @param mixed $args
     * @return mixed|false
     */
    public static function __callStatic($method, $args)
    {
        $instance = static::getInstance();

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
                return call_user_func_array([$instance, $method], $args);
        }
    }
}
