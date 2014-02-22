<?php

namespace Recipe;

class Finder
{
    protected $items;
    protected $recipes;

    public function __construct(array $items, array $recipes)
    {
        $this->items   = $items;
        $this->recipes = $recipes;
    }

    public function getMatchingItems()
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

    public function getIngredients($recipe)
    {
        return isset($recipe['ingredients']) ? $recipe['ingredients'] : null;
    }

    public function isInTheFridge($ingredient)
    {
        foreach ($this->items as $item) {

            if (($item['item'] === $ingredient['item'])
                && ($item['amount'] >= $ingredient['amount'])
                && ($item['unit'] === $ingredient['unit'])
                && ($this->hasExpired($item['useBy']))
            ) {
                return true;
            }
        }

        return false;
    }

    public function hasExpired($useBy)
    {
        return strtotime(str_replace('/', '-', $useBy)) > time();
    }
}