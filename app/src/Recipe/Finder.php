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
    const NO_RECIPES_FOUND = 'Order Takeout';
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
     * @return string What to cook tonight
     */
    public function find()
    {
        $ingredientsFound = 0;
        $closestUseBy     = 0;

        $matchingItems = [];
        foreach ($this->recipes as $recipe) {
            foreach ($this->items as $item) {

                $recipeIngredients   = $this->getIngredients($recipe);
                $numberOfIngredients = count($recipeIngredients);

                if ($this->isInTheFridge($recipeIngredients, $item)) {

                    $ingredientsFound++;

                    if ($closestUseBy == 0
                        || $closestUseBy > $this->getUseBy($item['useBy'])
                    ) {
                        $recipe['useBy'] = $this->getUseBy($item['useBy']);
                    }

                }

                if (($ingredientsFound > 0)
                    && ($ingredientsFound === $numberOfIngredients)
                ) {
                    $matchingItems[]  = $recipe;
                    $ingredientsFound = 0;
                }
            }
        }

        if (count($matchingItems)) {
            return $this->closestUseBy($matchingItems);
        }

        return self::NO_RECIPES_FOUND;
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
     * @param string $recipeIngredients Ingredient Name
     * @param array  $item              Item array
     *
     * @return bool
     */
    public function isInTheFridge($recipeIngredients, $item)
    {

        foreach ($recipeIngredients as $ingredient) {
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
        return $this->getUseBy($useBy) < time();
    }

    /**
     * Converts use-by date to timestamp
     *
     * @param string $useBy Date (dd/mm/YYYY)
     *
     * @return int
     */
    protected function getUseBy($useBy)
    {
        return strtotime(str_replace('/', '-', $useBy));
    }

    /**
     * Sort the recipes found by the one
     * with closest use by item
     *
     * @param array $recipes Recipes Array
     *
     * @return string
     */
    public function closestUseBy($recipes)
    {
        usort(
            $recipes, function ($recipe1, $recipe2) {

                return $this->getUseBy($recipe1['useBy'])
                - $this->getUseBy($recipe2['useBy']);
            }
        );

        return $recipes[0]['name'];
    }
}