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
    protected $inputValidation = array(
        'item'   => '/^(.*)$/',
        'amount' => '/^(\d+)$/',
        'unit'   => '/^(of|grams|ml|slices)$/i',
        'useBy'  => '/^(\d{1,2})\/(\d{1,2})\/(\d{1,4})/'
    );

    /**
     * Parses a csv file containing the items in the fridge
     * and convert them into an array of items
     *
     * @param string $csvFile Path to CSV file
     *
     * @throws \Exception
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

        try {
            $this->validate($items);
        } catch (\Exception $e) {
            throw $e;
        }

        return $this->orderByClosestUseBy($items);
    }

    /**
     * Validates each ingredient value
     *
     * @param array $items Array of items uploaded
     *
     * @throws \Exception
     * @return void
     */
    protected function validate($items)
    {
        array_walk_recursive(
            $items, function ($value, $key) {

                if (!preg_match($this->inputValidation[$key], $value)) {
                    throw new \Exception(
                        '"' . $value
                        . ' is an invalid for entry for field "'
                        . $key . '"'
                    );
                }
            }
        );
    }

    /**
     * Order items by closest use-by date
     *
     * @param array $items Items array
     *
     * @return array Ordered array
     */
    public function orderByClosestUseBy($items)
    {
        usort(
            $items, function ($item1, $item2) {

                return strtotime(str_replace('/', '-', $item1['useBy']))
                - strtotime(str_replace('/', '-', $item2['useBy']));
            }
        );

        return $items;

    }
}