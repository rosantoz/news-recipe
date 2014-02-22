<?php
/**
 * Recipe Finder
 *
 * PHP version 5.5.8
 *
 * @category RecipeFinder
 * @package  Recipe
 * @author   Rodrigo dos Santos <rodrigo@dossantos.com.au>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link     https://github.com/rosantoz
 */
namespace Recipe;

/**
 * Recipe Finder. Checks the recipes and items in the fridge an
 * returns a suggestion of what to cook tonight
 *
 * @category RecipeFinder
 * @package  Recipe
 * @author   Rodrigo dos Santos <email@rodrigodossantos.ws>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link     https://github.com/rosantoz
 */
class Finder
{
    protected $items;
    protected $recipes;

    /**
     * Constructor
     *
     * @param array $items   Items in the fridge
     * @param array $recipes Recipes
     */
    public function __construct(array $items, array $recipes)
    {
        $this->items   = $items;
        $this->recipes = $recipes;
    }

    /**
     * Returns a list of what to cook
     *
     * @return array
     */
    public function find()
    {
        $matchingItems = [];
        foreach ($this->recipes as $recipe) {

            $ingredientAvailable = false;

            $recipeIngredients = $this->getIngredients($recipe);


            foreach ($recipeIngredients as $ingredient) {
                if (!$this->isInTheFridge($ingredient)) {
                    continue 2;
                }

                $ingredientAvailable = true;

            }

            if ($ingredientAvailable) {
                $matchingItems[] = $recipe['name'];
            }

        }

        return $matchingItems;
    }

    /**
     * Returns the ingredients of a recipe
     *
     * @param array $recipe Recipe Array
     *
     * @return array|null
     */
    public function getIngredients($recipe)
    {
        return isset($recipe['ingredients']) ? $recipe['ingredients'] : null;
    }

    /**
     * Checks if the recipe ingredient is in the fridge,
     * has the required amount and unit
     * and has not passed its use-by date.
     *
     * @param string $ingredient Ingredient Name
     *
     * @return bool
     */
    public function isInTheFridge($ingredient)
    {
        foreach ($this->items as $item) {

            if (($item['item'] === $ingredient['item'])
                && ($item['amount'] >= $ingredient['amount'])
                && ($item['unit'] === $ingredient['unit'])
                && (!$this->hasExpired($item['useBy']))
            ) {
                return true;
            }
        }

        return false;
    }

    /**
     * Checks if a given date string is in the past
     *
     * @param string $useBy Date (dd/mm/YYYY)
     *
     * @return bool
     */
    protected function hasExpired($useBy)
    {
        return strtotime(str_replace('/', '-', $useBy)) < time();
    }
}