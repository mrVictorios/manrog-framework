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

use manrog\classes\filesystem\File;

/**
 * Class FileTest
 *
 * represent a file on file System
 */
class FileTest extends PHPUnit_Framework_TestCase
{
    /** @var File */
    private $file;

    protected function setUp()
    {
        $this->file = new File('mynew');
    }

    /**
     * set the content of file
     *
     * @return \manrog\classes\filesystem\File
     */
    public function testFileSetContent()
    {
        $this->file->setContent('hello world');

        $this->assertAttributeEquals('hello world', 'content', $this->file);

        return $this->file;
    }

    /**
     * @depends testFileSetContent
     *
     * @param \manrog\classes\filesystem\File $file
     */
    public function testFileGetContent(File $file)
    {
        $this->assertEquals('hello world', $file->getContent());
    }

    /**
     * append data to content
     */
    public function testFileAppendContent()
    {
        $this->file->setContent('hello');
        $this->file->appendContent('world');

        $this->assertAttributeEquals('helloworld', 'content', $this->file);
    }

    /**
     * prepend content 
     */
    public function testFilePrependContent()
    {
        $this->file->setContent('world');
        $this->file->prependContent('hello');

        $this->assertAttributeEquals('helloworld', 'content', $this->file);
    }
}
