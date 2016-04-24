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

use \manrog\classes\util\Dic;

/**
 * Class DicTest
 *
 * test the Dependency Injection Container
 */
class DicTest extends PHPUnit_Framework_TestCase
{
    /** @var Dic */
    private $dic;
    /** @var callable functional Callback */
    private $callback;

    protected function setUp()
    {
        $this->dic      = new Dic();
        $this->callback = function () {
            return 'hello world';
        };

    }

    public function testRegisterCallbackWillStoreInDic()
    {
        $this->dic->add('test', $this->callback);

        $this->assertAttributeEquals(
            array(
                'test' => $this->callback,
            ),
            'container',
            $this->dic
        );
    }

    public function testGetResultOfCallback()
    {
        $this->dic->add('test', $this->callback);

        $this->assertEquals('hello world', $this->dic->get('test'));

        return $this->dic;
    }

    /**
     * @depends testGetResultOfCallback
     *
     * @param $dic
     *
     * @throws \Exception
     */
    public function testReplaceNewCallbackOnSamePosition(Dic $dic)
    {
        $callback = function() {
            return "bye world";
        };

        $dic->replace('test', $callback);

        $this->assertAttributeEquals(
            array(
                'test' => $callback,
            ),
            'container',
            $dic
        );
    }

    /**
     * @expectedException Exception
     */
    public function testRegisterAlreadyInUse()
    {
        $this->dic->add('test', $this->callback);
        $this->dic->add('test', function() {
            return 'test';
        });
    }

    public function testGetNotRegistredCallback()
    {
        $this->assertNull($this->dic->get('notexist'));
    }

    public function testGetInstanceReturnsInstanceOfClass()
    {
        $this->assertInstanceOf('\stdClass', $this->dic->getInstance('\stdClass'));
    }
}
