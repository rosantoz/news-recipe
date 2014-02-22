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
        $this->assertEquals('mixed salad', $items[0]['item']);
        $this->assertEquals(150, $items[0]['amount']);
        $this->assertEquals('grams', $items[0]['unit']);
        $this->assertEquals('26/12/2013', $items[0]['useBy']);
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

    public function testOrderByClosestUseBy()
    {
        $items = array(
            array(
                'item'   => 'bread',
                'amount' => 10,
                'unit'   => 'slices',
                'useBy'  => '26/03/2014'
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
        );

        $orderedItems = $this->items->orderByClosestUseBy($items);

        $this->assertEquals('cheese', $orderedItems[0]['item']);
        $this->assertEquals('butter', $orderedItems[1]['item']);
        $this->assertEquals('bread', $orderedItems[2]['item']);
    }
}