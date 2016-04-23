<?php
/**
 * This file is part of peet-util.
 *
 * (c) Manuel Rogoll <manuel.rogoll@manrog.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use manrog\classes\util\Php;

/**
 * Class PhpTest
 *
 * tests the Php delegate object
 */
class PhpTest extends PHPUnit_Framework_TestCase
{
    private $php;

    protected function setUp()
    {
        $this->php = new Php();
    }

    /**
     * should run the Php Static function
     */
    public function testPhpStaticWrapper()
    {
        $expected = get_defined_functions();

        $this->assertEquals($expected, $this->php->get_defined_functions());
    }

    /**
     * @expectedException Exception
     */
    public function testPhpGetNonExistFunction()
    {
        $this->php->nonexist();
    }
}
