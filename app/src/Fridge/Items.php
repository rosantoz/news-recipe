<?php
/**
 * Items in the fridge
 *
 * PHP version 5.5.8
 *
 * @category RecipeFinder
 * @package  Fridge
 * @author   Rodrigo dos Santos <rodrigo@dossantos.com.au>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link     https://github.com/rosantoz
 */
namespace Fridge;

/**
 * Items in the fridge
 *
 * @category RecipeFinder
 * @package  Fridge
 * @author   Rodrigo dos Santos <email@rodrigodossantos.ws>
 * @license  http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link     https://github.com/rosantoz
 */
class Items
{
    /**
     * Parses a csv file containing the items in the fridge
     * and convert them into an array of items
     *
     * @param string $csvFile Path to CSV file
     *
     * @return array
     */
    public function getItemFromCsvFile($csvFile)
    {
        $file = new \SplFileObject($csvFile);

        $file->setFlags(\SplFileObject::READ_CSV);
        $file->setCsvControl(',', '"', '\\');

        $items = [];

        foreach ($file as $item) {

            list ($itemName, $amount, $unit, $useBy) = $item;

            $items[] = [
                'item'   => $itemName,
                'amount' => $amount,
                'unit'   => $unit,
                'useBy'  => $useBy
            ];
        }

        return $items;
    }
}