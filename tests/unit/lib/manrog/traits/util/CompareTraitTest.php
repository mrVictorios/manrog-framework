<?php
/**
 * This file is part of manrog-framework
 *
 * (c) Manuel Rogoll <manuel.rogoll@manrog.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Class TestCompareTraitTest
 *
 */
class TestCompareTraitTest extends PHPUnit_Framework_TestCase
{
    /** @var  \manrog\traits\util\CompareTrait */
    private $compareMock;

    protected function setUp()
    {
        $this->compareMock = $this->getMockForTrait('manrog\\traits\\util\\CompareTrait');
    }

    /**
     * chack is the array a numeric array or not
     */
    public function testIsArrayNumericWithNumericArrayShouldBeTrue()
    {
        $this->assertTrue(
            $this->compareMock->isArrayNumeric(
                array('test')
            )
        );
    }

    public function testIsArrayNumericWithAssocArrayShouldBeFalse()
    {
        $this->assertFalse(
            $this->compareMock->isArrayNumeric(
                array('test' => 'test')
            )
        );
    }
}
