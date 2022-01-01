<?php

declare(strict_types=1);

namespace AdrianMejias\Veil;

use AdrianMejias\Veil\Exceptions\AutoloadRegisterException;

/**
 * Veil.
 *
 * @package Veil
 * @category Support
 */
class Veil
{
    /**
     * Array of class aliases.
     *
     * @var array|mixed[]
     */
    private array $veils = [];

    /**
     * Array of loaded class aliases.
     *
     * @var array|mixed[]
     */
    private array $registered = [];

    /**
     * Get a list of veils.
     *
     * @return array|mixed[]
     */
    public function all(): array
    {
        return $this->veils;
    }

    /**
     * Get a list of registered veils.
     *
     * @return array|mixed[]
     */
    public function registered(): array
    {
        return $this->registered;
    }

    /**
     * Add an array of veils.
     *
     * @param array|mixed[]|string $veils Array of class
     * aliases. Alias if $class is given.
     * @param mixed $class Original class name for
     * given $veils alias name.
     * @return void
     */
    public function add($veils, $class = null): void
    {
        if (empty($class) && is_array($veils)) {
            $this->veils = array_merge($this->veils, $veils);

            foreach ($this->veils as $veil => $_class) {
                if (class_exists($veil)) {
                    $this->registered[$veil] = $this->veils[$veil];
                }

                if (interface_exists($veil)) {
                    $this->registered[$veil] = $this->veils[$veil];
                }
            }
        }

        if (! empty($class) && is_string($class) && is_string($veils)) {
            $this->veils[$veils] = $class;

            if (class_exists($veils)) {
                $this->registered[$veils] = $this->veils[$veils];
            }

            if (interface_exists($veils)) {
                $this->registered[$veils] = $this->veils[$veils];
            }
        }
    }

    /**
     * Register given array of veils as __autoload() implementation.
     *
     * @param bool $prepend If true, spl_autoload_register()
     * will prepend the autoloader on the autoload stack
     * instead of appending it.
     * @return \AdrianMejias\Veil\Veil
     * @throws \TypeError
     * @throws \AdrianMejias\Veil\Exceptions\AutoloadRegisterException
     */
    public function register(bool $prepend = true): Veil
    {
        $callback = fn (string $class) => $this->autoload($class);

        if (spl_autoload_register($callback, true, $prepend)) {
            return $this;
        }

        throw new AutoloadRegisterException();
    }

    /**
     * Creates an alias for a class.
     *
     * @param string $class Class alias to be autoloaded.
     * @return mixed
     */
    public function autoload(string $class)
    {
        if (array_key_exists($class, $this->registered)) {
            return false;
        }

        if (! array_key_exists($class, $this->veils)) {
            return false;
        }

        if (class_exists($class, false)) {
            return false;
        }

        if (interface_exists($class, false)) {
            return false;
        }

        if (class_alias(
            $this->veils[$class],
            $class,
            true
        )) {
            $this->registered[$class] = $this->veils[$class];

            return true;
        }
    }
}
