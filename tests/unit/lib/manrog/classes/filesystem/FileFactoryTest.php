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

use manrog\classes\filesystem\File;
use org\bovigo\vfs\vfsStream;
use \org\bovigo\vfs\vfsStreamWrapper,
    \org\bovigo\vfs\vfsStreamFile,
    \org\bovigo\vfs\vfsStreamDirectory,
    \manrog\classes\filesystem\FileFactory;

/**
 * Class FileFactoryTest
 * 
 * test the fileFactory class the factory returns Files from File System based on SpfFile 
 * 
 */
class FileFactoryTest extends PHPUnit_Framework_TestCase
{
    /** @var Object mocking filesystem */
    private $vfs;
    /** @var File Object Mock */
    private $file;
    /** @var \manrog\classes\util\Dic mock Object */
    private $dic;
    /** @var FileFactory this is the test object */
    private $filefactory;

    private $files = array(
        'one'    => 'example one',
        'two'    => 'example two',
        'three'  => 'example three',
        'subdir' => array(
            'one'    => 'example one',
            'two'    => 'example two',
            'three'  => 'example three',
            'level2' => array(
                'myside' => array(
                    'helloworld.txt' => 'content of hello world',
                ),
                "orders" => array(
                    '20160214' => '12345',
                    '20160213' => '1234',
                    '20160212' => '123',
                    '20160211' => '12',
                    '20160210' => '1',
                ),
            ),
        ),
    );

    protected function setUp()
    {
        $this->vfs = new vfsStreamDirectory('test');

        $this->file = $this->getMockBuilder('manrog\classes\filesystem\File')
            ->disableOriginalConstructor()
            ->getMock();

        $this->dic = $this->getMockBuilder('manrog\classes\util\Dic')
            ->disableOriginalConstructor()
            ->getMock();

        vfsStreamWrapper::register();

        $this->vfsBuilder($this->vfs, $this->files);

        vfsStreamWrapper::setRoot($this->vfs);

    }

    /**
     * returns file object on iteration the file objects will be represent the data from FileSystem
     */
    public function testGetFilesFromDir_ShouldBeGetFilesFromDir()
    {
        $this->dic->expects($this->exactly(3))
            ->method('getInstance')
            ->will($this->returnValueMap(array(
                array('manrog\classes\filesystem\File', array(vfsStream::url('test/one')), $this->file),
                array('manrog\classes\filesystem\File', array(vfsStream::url('test/three')), $this->file),
                array('manrog\classes\filesystem\File', array(vfsStream::url('test/two')), $this->file),
            )));

        $this->filefactory = new FileFactory($this->dic);
        $this->filefactory->getFiles(vfsStream::url('test'));

        $this->assertAttributeNotEmpty('files', $this->filefactory);

        foreach ($this->filefactory as $index => $file) {
            $this->assertInstanceOf('manrog\\classes\\filesystem\\File', $file);
        }
    }

    /**
     * Seek files in dictionary recursive, should get all files in this and sub dirs
     */
    public function testGetFilesFromDirRecursive_ShouldBeGetAlleFilesInDirIncludeBelowDirs()
    {
        $expectedFiles = array(
            vfsStream::url('test/one'),
            vfsStream::url('test/subdir/level2/myside/helloworld.txt'),
            vfsStream::url('test/subdir/level2/orders/20160210'),
            vfsStream::url('test/subdir/level2/orders/20160211'),
            vfsStream::url('test/subdir/level2/orders/20160212'),
            vfsStream::url('test/subdir/level2/orders/20160213'),
            vfsStream::url('test/subdir/level2/orders/20160214'),
            vfsStream::url('test/subdir/one'),
            vfsStream::url('test/subdir/three'),
            vfsStream::url('test/subdir/two'),
            vfsStream::url('test/three'),
            vfsStream::url('test/two'),
        );

        $this->filefactory = new FileFactory($this->dic);
        $this->filefactory->useRecursive();
        $this->filefactory->getFiles(vfsStream::url('test'));

        $this->assertAttributeEquals($expectedFiles, 'files', $this->filefactory);
    }

    /**
     * seek files there will match the expression in dir
     */
    public function testGetFilesFromDirRecursiveRegex_ShouldBeGetSpezificFilesFromDirIncludeBelowDirs()
    {
        $expectedFiles = array(
            vfsStream::url('test/one'),
            vfsStream::url('test/subdir/one'),
        );

        $this->filefactory = new FileFactory($this->dic);
        $this->filefactory->useRecursive();
        $this->filefactory->setRegex('/^on/');
        $this->filefactory->getFiles(vfsStream::url('test'));

        $this->assertCount(2, $this->filefactory);
        $this->assertAttributeEquals($expectedFiles, 'files', $this->filefactory);
    }

    /**
     * get files threre will match the expression from dir not recursive
     */
    public function testGetFilesFromDirRegex_ShouldGetSpezificFilesFromDir()
    {
        $expectedFiles = array(
            vfsStream::url('test/three'),
        );

        $this->filefactory = new FileFactory($this->dic);
        $this->filefactory->setRegex('/ee$/');
        $this->filefactory->notRecursive();

        $this->assertFalse($this->filefactory->isRecursive());

        $this->filefactory->getFiles(vfsStream::url('test'));

        $this->assertCount(1, $this->filefactory);
        $this->assertAttributeEquals($expectedFiles, 'files', $this->filefactory);
    }

    /**
     * builds VFS from array
     *
     * @param \org\bovigo\vfs\vfsStreamDirectory $dir
     * @param                                    $array
     */
    private function vfsBuilder(vfsStreamDirectory &$dir, $array)
    {
        foreach ($array as $name => $content) {
            if (is_array($content)) {
                $file = new vfsStreamDirectory($name);
                $this->vfsBuilder($file, $content);
            } else {
                $file = new vfsStreamFile($name);
                $file->setContent($content);
            }

            $dir->addChild($file);
        }
    }
}
