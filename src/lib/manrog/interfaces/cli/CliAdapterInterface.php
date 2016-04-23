<?php
/**
 * This file is part of peet-util.
 *
 * (c) Manuel Rogoll <manuel.rogoll@manrog.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace manrog\interfaces\cli;

interface CliAdapterInterface
{
    /**
     * returns the foreground color for output
     *
     * @param $color
     *
     * @return mixed
     */
    public function getForegroundColor($color);

    /**
     * returns the background color for output
     *
     * @param $color
     *
     * @return mixed
     */
    public function getBackgroundColor($color);
}
