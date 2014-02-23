<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Fridge\Items;
use Recipe\Recipes;
use Recipe\Finder;

$fridgeFile  = isset($argv[1]) ? $argv[1] : array();
$recipesFile = isset($argv[2]) ? $argv[2] : array();

if ($_FILES) {
    $fridgeFile  = isset($_FILES['items'])
        ? $_FILES['items']['tmp_name'] : array();

    $recipesFile = isset($_FILES['recipes'])
        ? $_FILES['recipes']['tmp_name'] : array();
}

try {

    $items      = new Items();
    $itemsInput = $items->getItemFromCsvFile($fridgeFile);

    $recipes      = new Recipes();
    $recipesInput = $recipes->getFromJsonFile($recipesFile);

    $recipeFinder = new Finder($itemsInput, $recipesInput);

    echo "\n";
    echo "Recommendation for tonight is: ";
    echo $recipeFinder->find();
    echo "\n\n";

} catch (\Exception $e) {
    echo $e->getMessage() . "\n";
}