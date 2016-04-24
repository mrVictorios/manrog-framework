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

namespace manrog\classes\cli;

use manrog\classes\util\Php,
    manrog\interfaces\cli\CliWriterInterface,
    manrog\interfaces\util\DicInterface;

/**
 * Class CliWriter
 *
 * write messages to console
 *
 * @package manrog\classes\writer
 */
class CliWriter implements CliWriterInterface
{
    /**
     * Output font colors
     */
    const COLOR_FOREGROUND_DEFAULT = '0';

    /**
     * Output row color
     */
    const COLOR_BACKGROUND_DEFAULT = '1';

    /** @var resource $output output stream */
    private $output = STDOUT;
    /** @var bool use coloured output */
    private $colouredOutput = false;
    /** @var string coloured output template */
    private $coloured = "\033[{foreground}m\033[{background}m{message}\033[0m\033[m";
    /** @var array coloured outputant  template placeholder */
    private $replacements = array('{foreground}', '{background}', '{message}');

    /** @var Php */
    private $php;

    public function __construct(DicInterface $dic)
    {
        $this->php = $dic->get('Php');
    }

    /**
     * use coloured output
     */
    public function useColoured()
    {
        $this->colouredOutput = true;
    }

    /**
     * use plain output
     */
    public function usePlain()
    {
        $this->colouredOutput = false;
    }

    /**
     * write on error stream
     */
    public function useErrorStream()
    {
        $this->output = STDERR;
    }

    /**
     * write on standart out stream
     */
    public function useDefaultStream()
    {
        $this->output = STDOUT;
    }

    /**
     * check is coloured output active
     *
     * @return bool
     */
    public function isColoured()
    {
        return $this->colouredOutput;
    }

    /**
     * Write to stream
     *
     * @param string $message
     * @param string $foreground
     * @param string $background
     *
     * @return void
     */
    public function write(
        $message,
        $foreground = self::COLOR_FOREGROUND_DEFAULT,
        $background = self::COLOR_BACKGROUND_DEFAULT
    ) {
        if ($this->colouredOutput) {
            $message = str_replace(
                $this->replacements,
                array(
                    $foreground,
                    $background,
                    $message,
                ),
                $this->coloured
            );
        }

        $this->php->fwrite($this->output, $message);
    }

    /**
     * Write line to stream
     *
     * @param        $message
     * @param string $foreground
     * @param string $background
     *
     * @return $this
     */
    public function writeLine(
        $message,
        $foreground = self::COLOR_FOREGROUND_DEFAULT,
        $background = self::COLOR_BACKGROUND_DEFAULT
    ) {
        $this->write($message.PHP_EOL, $foreground, $background);

        return $this;
    }
}
