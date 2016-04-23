<?php
/**
 * This file is part of peet-util.
 *
 * (c) Manuel Rogoll <manuel.rogoll@manrog.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

use manrog\classes\cli\CliColorAdapter;

/**
 * Class CliColorAdapterTest
 *
 * test the CliColourAdapter
 */
class CliColorAdapterTest extends PHPUnit_Framework_TestCase
{
    protected $dic;
    /** @var  CliColorAdapter */
    protected $adapter;

    protected function setUp()
    {
        $this->adapter = new CliColorAdapter($this->dic);
    }

    /**
     * should get the code for foreground color green
     */
    public function testGetForegroundColor_getForGroundColorCode()
    {
        $this->assertEquals(
            '0;32',
            $this->adapter->getForegroundColor('green')
        );
    }

    /**
     * should get the code for background color green
     */
    public function testGetBackgroundColour_getBackgroundColorCode()
    {
        $this->assertEquals(
            '42',
            $this->adapter->getBackgroundColor('green')
        );
    }
}
