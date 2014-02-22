<?php

namespace Tests\Recipe;

use Recipe\Recipes;

class RecipesTest extends \PHPUnit_Framework_TestCase
{
    protected $recipes;

    public function setUp()
    {
        $this->recipes = new Recipes();

        parent::setUp();
    }

    public function testClassInstance()
    {
        $this->assertInstanceOf('Recipe\Recipes', $this->recipes);
    }

    public function testGetItemFromCsvFile()
    {
        $file = __DIR__ . '/../../../fixtures/recipes.json';

        $recipes = $this->recipes->getFromJsonFile($file);

        $this->assertCount(2, $recipes);
    }

    /**
     * @expectedException Exception
     */
    public function testExceptionWhenJsonFileCanNotBeParsed()
    {
        $file = 'path/to/an/invalid/file.json';

        $this->recipes->getFromJsonFile($file);

    }
}