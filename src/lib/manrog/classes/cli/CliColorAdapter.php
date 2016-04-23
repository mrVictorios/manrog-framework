<?php
/**
 * This file is part of peet-util.
 *
 * (c) Manuel Rogoll <manuel.rogoll@manrog.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace manrog\classes\cli;

use manrog\interfaces\cli\CliAdapterInterface;

/**
 * Class CliArrayLineColorAdapter
 *
 * adapter for colours to interaction between a writer and array writer
 *
 * @package manrog\classes\cli
 */
class CliColorAdapter implements CliAdapterInterface
{
    /**
     * map of foreground colours
     *
     * @var array
     */
    private $foreground = array(
        'black'       => '0;30',
        'blue'        => '0;34',
        'browm'       => '0;33',
        'cyan'        => '0;36',
        'darkgrey'    => '1;30',
        'default'     => '0',
        'green'       => '0;32',
        'lightblue'   => '1;34',
        'lightcyan'   => '1;36',
        'lightgreen'  => '1;32',
        'lightgrey'   => '0;37',
        'lightpurple' => '1;35',
        'lightred'    => '1;31',
        'purple'      => '0;35',
        'red'         => '0;31',
        'white'       => '1;37',
        'yellow'      => '1;33',
    );

    /**
     * map of background colors
     *
     * @var array
     */
    private $background = array(
        'black'      => '40',
        'blue'       => '44',
        'cyan'       => '46',
        'default'    => '1',
        'green'      => '42',
        'lightgreen' => '47',
        'magenta'    => '45',
        'red'        => '41',
        'yellow'     => '43',
    );

    /**
     * returns the foreground color for output
     *
     * @param $color
     *
     * @return string|null
     */
    public function getForegroundColor($color)
    {
        return $this->foreground[$color];
    }

    /**
     * returns the background color for output
     *
     * @param $color
     *
     * @return string|null
     */
    public function getBackgroundColor($color)
    {
        return $this->background[$color];
    }
}
