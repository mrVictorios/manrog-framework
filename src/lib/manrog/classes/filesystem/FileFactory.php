<?php

namespace manrog\classes\filesystem;

use \Countable,
    \Iterator,
    \manrog\interfaces\util\DicInterface;

/**
 * Class FileFactory
 *
 * get Files from File System
 *
 * @package manrog\classes\filesystem
 */
class FileFactory implements Countable, Iterator
{
    /** @var string regular expression search */
    protected $regex;
    /** @var int actual deepness of recursive  */
    protected $deepness    = 0;
    /** @var int item postion for iteration */
    protected $position    = 0;
    /** @var bool search dictionary recursive */
    protected $recursive   = false;
    /** @var array contains file paths */
    protected $files       = array();

    /** @var \manrog\interfaces\util\DicInterface Dependency Injection Container */
    private $dic;

    public function __construct(DicInterface $dic)
    {
        $this->dic = $dic;
    }

    /**
     * Return the current element
     *
     * @link  http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        return $this->buildFile();
    }

    /**
     * create file object
     *
     * @return File|null
     */
    protected function buildFile()
    {
        /** @var File $file */
        $file = $this->dic->getInstance('manrog\classes\filesystem\File',array($this->files[$this->position]));
        $file->setContent(file_get_contents($this->files[$this->position]));

        return $file;
    }

    /**
     * Move forward to next element
     *
     * @link  http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        ++$this->position;
    }

    /**
     * Return the key of the current element
     *
     * @link  http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * Checks if current position is valid
     *
     * @link  http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     *        Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        return isset($this->files[$this->position]);
    }

    /**
     * Rewind the Iterator to the first element
     *
     * @link  http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * get Files from dir
     *
     * @param $dir
     */
    public function getFiles($dir)
    {
        $this->fileIterator($dir);
        $this->files = array_values($this->files);
    }

    /**
     * set Regex for Searching
     *
     * @param string $regex regular expression
     */
    public function setRegex($regex)
    {
        $this->regex = $regex;
    }

    /**
     * scan dirs recursive
     */
    public function useRecursive()
    {
        $this->recursive = true;
    }

    /**
     * scan dirs not recursive
     */
    public function notRecursive()
    {
        $this->recursive = false;
    }

    /**
     * scans dirs recursive or not
     *
     * @return bool
     */
    public function isRecursive()
    {
        return $this->recursive;
    }

    /**
     * Count elements of an object
     *
     * @link  http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     *        </p>
     *        <p>
     *        The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count()
    {
        return count($this->files);
    }

    /**
     * iterate dir
     *
     * @param $dir
     */
    protected function fileIterator($dir)
    {
        foreach ($this->getDirContent($dir) as $content) {
            $path = $dir.'/'.$content;

            if (is_file($path)) {
                $this->checkFile($path, $content);
                continue;
            }

            if($this->recursive) {
                $this->fileIterator($path);
            }
        }
    }

    /**
     * return dir content
     *
     * @param $dir
     *
     * @return array
     */
    protected function getDirContent($dir)
    {
        return array_values(array_diff(scandir($dir), array('..', '.')));
    }

    /**
     * check file needed
     *
     * @param $path
     * @param $filename
     */
    protected function checkFile($path, $filename)
    {
        if(!is_null($this->regex)) {
            if (preg_match($this->regex, $filename)) {
                $this->addFile($path);
            }

            return;
        }

        $this->addFile($path);
    }
    /**
     * add file to list
     *
     * @param $path
     */
    protected function addFile($path)
    {
        $this->files[hash('adler32', $path)] = $path;
    }
}
