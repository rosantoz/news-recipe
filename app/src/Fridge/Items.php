<?php

namespace Fridge;

class Items
{
    public function getItemFromCsvFile()
    {
        $csvFile = __DIR__ . '/../../../data/fridge.csv';

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