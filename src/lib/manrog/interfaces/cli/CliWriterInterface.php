<?php
/**
 * This file is part of manrog-framework
 *
 * (c) Manuel Rogoll <manuel.rogoll@manrog.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace manrog\interfaces\cli;

interface CliWriterInterface
{
    /**
     * Write to stream
     *
     * @param string $message
     * @param string $foreground
     * @param string $background
     *
     * @return void
     */
    public function write($message, $foreground = null, $background = null);

    /**
     * Write line to stream
     *
     * @param        $message
     * @param string $foreground
     * @param string $background
     *
     * @return void
     */
    public function writeLine($message, $foreground = null, $background = null);
}
