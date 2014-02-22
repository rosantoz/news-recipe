<?php

namespace Tests\Recipe;

use Recipe\Finder;
use Recipe\Recipes;
use Fridge\Items;

class FinderTest extends \PHPUnit_Framework_TestCase
{
    public function testClassInstance()
    {
        $this->assertInstanceOf('Recipe\Finder',  new Finder([], []));
    }

    public function testGetMatchingItemsWithValidInput()
    {
        $itemsFile   = __DIR__ . '/../../../fixtures/fridge.csv';
        $recipesFile = __DIR__ . '/../../../fixtures/recipes.json';

        $items   = new Items();
        $recipes = new Recipes();
        $finder  = new Finder(
            $items->getItemFromCsvFile($itemsFile),
            $recipes->getFromJsonFile($recipesFile)
        );

        $whatToCook = $finder->find();

        $this->assertCount(1, $whatToCook);
        $this->assertEquals('grilled cheese on toast', $whatToCook[0]);

    }

}