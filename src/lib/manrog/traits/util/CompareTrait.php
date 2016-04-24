<?php
/**
 * This file is part of manrog-framework
 *
 * (c) Manuel Rogoll <manuel.rogoll@manrog.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace manrog\traits\util;

/**
 * Class CompareTrait
 *
 * includes methods for comparison
 *
 * @package manrog\traits\util
 */
trait CompareTrait
{
    /**
     * validate is a array numeric
     *
     * @param array $array
     *
     * @return bool
     */
    public function isArrayNumeric(array $array)
    {
        return array_values($array) === $array;
    }
}
