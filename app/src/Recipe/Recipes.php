<?php

namespace Recipe;


class Recipes
{
    public function getFromJsonFile()
    {
        $jsonFile = __DIR__ . '/../../../data/recipes.json';

        $recipes = json_decode(file_get_contents($jsonFile), true);

        if ($recipes === null) {
            throw new \Exception("Could not parse recipes json file");
        }

        return $recipes;
    }

}