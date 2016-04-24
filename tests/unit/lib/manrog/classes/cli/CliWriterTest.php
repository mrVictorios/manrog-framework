<?php
/**
 * This file is part of manrog-framework
 *
 * (c) Manuel Rogoll <manuel.rogoll@manrog.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

use \manrog\classes\cli\CliWriter;

/**
 * Class CliWriterTest
 *
 * test the CliWriter
 *
 */
class CliWriterTest extends PHPUnit_Framework_TestCase
{
    /** @var \manrog\classes\util\Php */
    private $php;
    /** @var \peet\classes\util\Dic */
    private $dic;
    /** @var CliWriter */
    private $writer;

    protected function setUp()
    {
        $this->php = $this->getMockBuilder('manrog\\classes\\util\\Php')
            ->disableOriginalConstructor()
            ->setMethods(array(
                'fwrite'
            ))
            ->getMock();

        $this->dic = $this->getMockBuilder('manrog\\classes\\util\\Dic')
            ->disableOriginalConstructor()
            ->getMock();

        $this->dic->expects($this->once())
            ->method('get')
            ->with($this->equalTo('Php'))
            ->willReturn($this->php);
    }

    /**
     * write a default message to the console
     */
    public function testWritePlainContentOnOutStream()
    {
        $this->php->expects($this->once())
            ->method('fwrite')
            ->with($this->equalTo(STDOUT), $this->equalTo('Hello World!'));

        $this->writer = new CliWriter($this->dic);
        $this->writer->usePlain();
        $this->writer->useDefaultStream();
        $this->writer->write('Hello World!');
    }

    /**
     * write a coulored text to the console
     */
    public function testWriteColouredContent()
    {
        $this->php->expects($this->once())
            ->method('fwrite')
            ->with($this->equalTo(STDOUT), $this->equalTo("\033[0m\033[1mHello World!\033[0m\033[m"));

        $this->writer = new CliWriter($this->dic);

        $this->assertFalse($this->writer->isColoured());

        $this->writer->useColoured();
        $this->writer->write('Hello World!');
    }

    /**
     * write a text to the error stream
     */
    public function testWriteLineOnErrorStream()
    {
        $this->php->expects($this->once())
            ->method('fwrite')
            ->with($this->equalTo(STDERR), $this->equalTo('Hello World!'.PHP_EOL));

        $this->writer = new CliWriter($this->dic);

        $this->assertFalse($this->writer->isColoured());

        $this->writer->useErrorStream();
        $this->writer->writeLine('Hello World!');
    }
}
