<?php

namespace manrog\classes\util;

use manrog\interfaces\util\DicInterface;

/**
 * Class Dic
 *
 * a simple dependency injection Container
 *
 * @package manrog\classes\util
 */
class Dic implements DicInterface
{
    /**
     * Depends all objects
     *
     * @var $container
     */
    private $container;

    /**
     * @param string   $dependency
     * @param callable $callback
     *
     * @throws \Exception
     */
    public function add($dependency, $callback)
    {
        if(isset($this->container[$dependency])) {
            throw new \Exception('"'.$dependency.'" already in use');
        }

        $this->container[$dependency] = $callback;
    }

    /**
     * @param string $dependency
     *
     * @return null
     */
    public function get($dependency)
    {
        if(isset($this->container[$dependency])) {
            return $this->container[$dependency]($this);
        }

        return null;
    }

    /**
     * @param string   $dependency
     * @param callable $callback
     *
     * @throws \Exception
     */
    public function replace($dependency, $callback)
    {
        unset($this->container[$dependency]);
        $this->add($dependency, $callback);
    }

    /**
     *
     * get Instance with Constructor arguments
     *
     * @param string $class
     * @param array $arguments
     *
     * @return mixed
     */
    public function getInstance($class, array $arguments = array())
    {
        return call_user_func_array(array(new \ReflectionClass($class), 'newInstance'), $arguments);
    }
}
