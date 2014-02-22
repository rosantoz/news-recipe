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
    }

    /**
     * @expectedException RuntimeException
     */
    public function testExceptionWhenFileCanNotBeParsed()
    {
        $file = 'path/to/an/invalid/file.csv';

        $this->items->getItemFromCsvFile($file);

    }
}