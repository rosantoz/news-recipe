<?php

namespace Tests\Recipe;

use Recipe\Finder;
use Recipe\Recipes;
use Fridge\Items;

class FinderTest extends \PHPUnit_Framework_TestCase
{
    public function testClassInstance()
    {
        $this->assertInstanceOf('Recipe\Finder', new Finder([], []));
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

        $this->assertEquals('grilled cheese on toast', $whatToCook);

    }

    public function testResultWhenNoIngredientsAreFound()
    {
        $itemsFile   = __DIR__ . '/../../../fixtures/fridge.csv';
        $recipesFile = __DIR__ . '/../../../fixtures/recipes_order_takeout.json';

        $items   = new Items();
        $recipes = new Recipes();
        $finder  = new Finder(
            $items->getItemFromCsvFile($itemsFile),
            $recipes->getFromJsonFile($recipesFile)
        );

        $whatToCook = $finder->find();

        $this->assertEquals('Order Takeout', $whatToCook);
    }

    public function testResultWhenOnlyOneIngredientIsFound()
    {
        $itemsFile   = __DIR__ . '/../../../fixtures/fridge_only_one_found.csv';
        $recipesFile = __DIR__ . '/../../../fixtures/recipes_only_one_found.json';

        $items   = new Items();
        $recipes = new Recipes();
        $finder  = new Finder(
            $items->getItemFromCsvFile($itemsFile),
            $recipes->getFromJsonFile($recipesFile)
        );

        $whatToCook = $finder->find();

        $this->assertEquals('Order Takeout', $whatToCook);
    }

    /**
     * @group now
     */
    public function testResultWhenMoreThanOneRecipeIsFound()
    {
        $itemsFile   = __DIR__ . '/../../../fixtures/fridge_closest_use_by.csv';
        $recipesFile = __DIR__ . '/../../../fixtures/recipes_closest_use_by.json';

        $items   = new Items();
        $recipes = new Recipes();
        $finder  = new Finder(
            $items->getItemFromCsvFile($itemsFile),
            $recipes->getFromJsonFile($recipesFile)
        );

        $whatToCook = $finder->find();

        $this->assertEquals('student toast', $whatToCook);
    }

}