<?php

namespace Recipe;


class Recipes
{
    protected $recipes;

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