<?php
/**
 * Recipes
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
 * Recipes
 *
 * @category RecipeFinder
 * @package  Recipe
 * @author   Rodrigo dos Santos <email@rodrigodossantos.ws>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link     https://github.com/rosantoz
 */
class Recipes
{
    protected $recipes;

    /**
     * Loads recipes from json file and convert them into array
     *
     * @param string $jsonFile Path to json file
     *
     * @return mixed
     * @throws \Exception
     */
    public function getFromJsonFile($jsonFile)
    {
        try {
            $recipes = json_decode(file_get_contents($jsonFile), true);
        } catch (\Exception $e) {
            throw $e;
        }

        return $recipes;
    }

}