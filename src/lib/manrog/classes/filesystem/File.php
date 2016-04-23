<?php

namespace manrog\classes\filesystem;

use manrog\interfaces\filesystem\FileInterface;
use \SplFileInfo;

/**
 * Class File
 *
 * represent File from Filesystem
 *
 * @package manrog\classes\filesystem
 */
class File extends SplFileInfo implements FileInterface
{
    protected $content;

    /**
     * set content of this file
     *
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * get content from this file
     *
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * append content to file
     *
     * @param $content
     *
     * @return mixed
     */
    public function appendContent($content)
    {
        $this->content .= $content;
    }

    /**
     * prepend content to this file
     *
     * @param $content
     */
    public function prependContent($content)
    {
        $this->content = $content.$this->content;
    }
}
