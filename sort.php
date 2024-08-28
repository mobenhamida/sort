<?php

use Adyen\CustomSort\Sorters\MergeSorter;
use Adyen\CustomSort\Sorters\QuickSorter;

include 'vendor/autoload.php';

$input = [
    ['name' => 'Jane', 'age' => 45],
    ['name' => 'Omar', 'age' => 65],
    1,
    'hello',
    [],
    ['name' => 'Amir', 'age' => 34],
    ['name' => 'Sara', 'age' => 12],
];

$quickSorter = new QuickSorter();
$mergeSorter = new MergeSorter();

$ascResult = $mergeSorter->sort($input, 'age', 'asc');
$descResult = $mergeSorter->sort($input, 'age', 'desc');

print_r($ascResult);
print_r($descResult);
