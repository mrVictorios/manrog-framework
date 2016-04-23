<?php
/**
 * This file is part of peet-util.
 *
 * (c) Manuel Rogoll <manuel.rogoll@manrog.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace manrog\interfaces\util;

/**
 * Interface DicInterface
 *
 * Interface Declaration for using Dependency Injection Container with manrog components
 *
 * @package manrog\interfaces\util
 */
interface DicInterface
{
    /**
     *
     * get Instance with Constructor arguments
     *
     * @param string $class
     * @param array  $arguments
     *
     * @return mixed
     */
    public function getInstance($class, array $arguments = array());

    /**
     * get dependency
     *
     * @param string $dependency
     *
     * @return mixed|null
     */
    public function get($dependency);

    /**
     * register a dependency
     *
     * @param string   $dependency
     * @param callable $callback
     *
     * @return void
     */
    public function add($dependency, $callback);

    /**
     * replace registered dependency
     *
     * @param string   $dependency
     * @param callable $callback
     *
     * @return void
     */
    public function replace($dependency, $callback);
}
