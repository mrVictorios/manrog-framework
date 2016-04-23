<?php
/**
 * This file is part of peet-util.
 *
 * (c) Manuel Rogoll <manuel.rogoll@manrog.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace manrog\interfaces\filesystem;

interface FileInterface
{
    /**
     * get content from this file
     *
     * @return mixed
     */
    public function getContent();

    /**
     * set content of this file
     *
     * @param mixed $content
     */
    public function setContent($content);

    /**
     * Gets the path to the file
     * @link http://php.net/manual/en/splfileinfo.getpathname.php
     * @return string The path to the file.
     * @since 5.1.2
     */
    public function getPathname();
}
