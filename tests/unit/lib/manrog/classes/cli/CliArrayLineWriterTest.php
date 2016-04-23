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

use manrog\classes\cli\CliArrayLineWriter;

/**
 * Class CliArrayLineWriterTest
 *
 * should writes messages to console from array
 *
 * example:
 *
 * $cliArrayLineWrite->write(array(
 *  array('My new line');                       // each array in the main array is a line
 *  array('green'     => 'write a greenLine')   // the key of the array works for color choose
 *  array('white/red' => 'write a greenLine')   // with a slash you can split fore- and background color
 *  array(                                      // if you ave multiple records for a line there will be group for line
 *      'default' => 'this is realy',           // in this case you have one line output with a red important string
 *      'red'     => 'important',
 *      'default' => '!',
 *  )
 * ));
 *
 */
class CliArrayLineWriterTest extends PHPUnit_Framework_TestCase
{
    /** @var CliArrayLineWriter */
    private $writer;
    /** @var \manrog\classes\cli\CliWriter|PHPUnit_Framework_MockObject_MockObject */
    private $cliWriter;
    /** @var \manrog\classes\cli\CliColorAdapter|PHPUnit_Framework_MockObject_MockObject */
    private $adapter;
    private $dic;

    private $plainText    = array(
        'my first line',
        'mysecondline',
    );
    private $colouredText = array(
        array(
            'red'   => 'hello',
            'green' => 'world',
        ),
        array(
            'default/green' => 'clean',
            'blue/yellow'   => 'text',
        ),
    );

    protected function setUp()
    {
        $this->dic = $this->getMockBuilder('manrog\classes\util\Dic')
            ->disableOriginalConstructor()
            ->getMock();

        $this->cliWriter = $this->getMockBuilder('manrog\classes\cli\CliWriter')
            ->disableOriginalConstructor()
            ->getMock();

        $this->adapter = $this->getMockBuilder('manrog\classes\cli\CliColorAdapter')
            ->disableOriginalConstructor()
            ->getMock();

        $this->dic->expects($this->at(0))
            ->method('get')
            ->willReturn($this->cliWriter);
    }

    /**
     * write lines to console
     */
    public function testWrite_WithPlainText_ShouldBeCallWriteLines()
    {
        $this->cliWriter->expects($this->at(0))
            ->method('writeLine')
            ->will($this->returnValueMap(array(
                array($this->equalTo('my first line'), $this->cliWriter),
                array($this->equalTo('mysecondline'), $this->cliWriter),
            )));

        $this->writer = new CliArrayLineWriter($this->dic);
        $this->writer->write($this->plainText);
    }

    /**
     * write multiple color rows to console
     */
    public function testWrite_WithColouredText_ShouldBeWriteColouredLines()
    {
        $this->adapter->expects($this->exactly(4))
            ->method('getForegroundColor')
            ->will($this->returnValueMap(array(
                array('red', 'red'),
                array('green', 'green'),
                array('default', 'default'),
                array('blue', 'blue'),
            )));

        $this->adapter->expects($this->exactly(2))
            ->method('getBackgroundColor')
            ->will($this->returnValueMap(array(
                array('green', 'green'),
                array('yellow', 'yellow'),
            )));

        $this->cliWriter->expects($this->exactly(6))
            ->method('write')
            ->will($this->returnValueMap(array(
                array('hello', 'red', $this->cliWriter),
                array('world', 'green', $this->cliWriter),
                array('clean', 'default', 'green', $this->cliWriter),
                array('text', 'blue', 'yellow', $this->cliWriter),
            )));

        $this->dic->expects($this->at(1))
            ->method('get')
            ->with($this->equalTo('CliColorAdapter'))
            ->willReturn($this->adapter);

        $this->writer = new CliArrayLineWriter($this->dic);
        $this->writer->write($this->colouredText);
    }
}
