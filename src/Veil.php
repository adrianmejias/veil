<?php

declare(strict_types=1);

namespace AdrianMejias\Veil;

use TypeError;

final class Veil
{
    /**
     * Array of class aliases.
     *
     * @var array
     */
    private $veils = [];

    /**
     * Array of loaded class aliases.
     *
     * @var array
     */
    private $registered = [];

    /**
     * Get a list of veils.
     *
     * @return array
     */
    public function all()
    {
        return $this->veils;
    }

    /**
     * Get a list of registered veils.
     *
     * @return array
     */
    public function registered()
    {
        return $this->registered;
    }

    /**
     * Add an array of veils.
     *
     * @param array|string $veils Array of class aliases. Alias if $class is given.
     * @param string|null $class Original class name for given $veils alias name.
     * @return void
     */
    public function add($veils, $class = null)
    {
        if (empty($class) && is_array($veils)) {
            $this->veils = array_merge($this->veils, $veils);
        }

        if (!empty($class) && is_string($class) && is_string($veils)) {
            $this->veils[$veils] = $class;
        }
    }

    /**
     * Register given array of veils as __autoload() implementation.
     *
     * @param array $prepend If true, spl_autoload_register() will prepend the autoloader on the autoload stack instead of appending it.
     * @return bool true on success or false on failure.
     * @throws TypeError
     */
    public function register(bool $prepend = true)
    {
        return spl_autoload_register([$this, 'autoload'], true, $prepend);
    }

    /**
     * Creates an alias for a class.
     *
     * @param string $alias Class alias to be autoloaded.
     * @return bool|null
     */
    public function autoload(string $class)
    {
        if (array_key_exists($class, $this->registered)) {
            return null;
        }

        if (!array_key_exists($class, $this->veils)) {
            return null;
        }

        if (class_exists($class, false)) {
            return null;
        }

        if (interface_exists($class, false)) {
            return null;
        }

        if (class_alias($this->veils[$class], $class, true)) {
            if (!class_exists($class, false)) {
                return null;
            }

            $this->registered[$class] = $this->veils[$class];

            return true;
        }

        return null;
    }
}
