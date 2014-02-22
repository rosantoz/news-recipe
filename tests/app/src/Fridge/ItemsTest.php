<?php

namespace Tests\Fridge;

use Fridge\Items;

class ItemsTest extends \PHPUnit_Framework_TestCase
{
    protected $items;

    public function setUp()
    {
        $this->items = new Items();

        parent::setUp();
    }

    public function testClassInstance()
    {
        $this->assertInstanceOf('Fridge\Items', $this->items);
    }

    public function testGetItemFromCsvFile()
    {
        $file = __DIR__ . '/../../../fixtures/fridge.csv';

        $items = $this->items->getItemFromCsvFile($file);

        $this->assertCount(5, $items);
        $this->assertEquals('bread', $items[0]['item']);
        $this->assertEquals(10, $items[0]['amount']);
        $this->assertEquals('slices', $items[0]['unit']);
        $this->assertEquals('25/12/2014', $items[0]['useBy']);
    }

    /**
     * @expectedException RuntimeException
     */
    public function testExceptionWhenFileCanNotBeParsed()
    {
        $file = 'path/to/an/invalid/file.csv';

        $this->items->getItemFromCsvFile($file);

    }

    /**
     * @expectedException Exception
     */
    public function testExceptionWhenItemsAreInAnInvalidFormat()
    {
        $file = __DIR__ . '/../../../fixtures/fridge_with_invalid_item.csv';

        $this->items->getItemFromCsvFile($file);
    }

    protected function orderByClosesUseByProvider()
    {
        return array(
            array(
                array(
                    'item'   => 'bread',
                    'amount' => 10,
                    'unit'   => 'slices',
                    'useBy'  => '25/03/2014'
                ),
                array(
                    'item'   => 'cheese',
                    'amount' => 10,
                    'unit'   => 'slices',
                    'useBy'  => '25/02/2014'
                ),
                array(
                    'item'   => 'butter',
                    'amount' => 250,
                    'unit'   => 'grams',
                    'useBy'  => '10/03/2014'
                ),
            )
        );
    }

    /**
     * @dataProvider orderByClosestUseByProvider
     */
    public function testOrderByClosestUseBy($items)
    {
        $this->items->orderByClosestUseBy($items);
    }
}