<?php
/**
 * This file is part of peet-util.
 *
 * (c) Manuel Rogoll <manuel.rogoll@manrog.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace manrog\classes\cli;

use manrog\interfaces\cli\CliAdapterInterface,
    manrog\interfaces\cli\CliWriterInterface,
    manrog\interfaces\util\DicInterface;

/**
 * Class CliArrayLineWriter !!!Experimental!!!
 *
 * writes messages to console from array
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
 * @package manrog\classes\cli
 */
class CliArrayLineWriter
{
    /** @var \manrog\interfaces\util\DicInterface */
    private $dic;
    /** @var  CliAdapterInterface */
    private $adapter;
    /** @var  CliWriterInterface */
    private $writer;

    public function __construct(DicInterface $dic)
    {
        $this->dic    = $dic;
        $this->writer = $dic->get('CliWriter');
    }

    /**
     * write messages from array
     *
     * @param array $messages
     *
     * @return $this
     */
    public function write(array $messages)
    {
        foreach ($messages as $message) {
            if (is_array($message)) {
                $this->writeColor();
                $this->writeColorRow($message);

                continue;
            }

            $this->writer->writeLine($message);
        }

        return $this;
    }

    /**
     * write with colour, requires CliColorAdapter
     */
    private function writeColor()
    {
        if (!isset($this->adapter)) {
            $this->adapter = $this->dic->get('CliColorAdapter');
        }

        return $this;
    }

    /**
     * writes a part of message
     *
     * @param $message
     *
     * @return $this
     */
    private function writeColorRow($message)
    {
        foreach ($message as $color => $text) {
            $colors = explode('/', $color);

            if (count($colors) == 1) {
                $this->writer->write(
                    $text,
                    $this->adapter->getForegroundColor($colors[0])
                );
                continue;
            }

            $this->writer->write(
                $text,
                $this->adapter->getForegroundColor($colors[0]),
                $this->adapter->getBackgroundColor($colors[1])
            );
        }

        $this->writer->write(PHP_EOL);

        return $this;
    }
}
