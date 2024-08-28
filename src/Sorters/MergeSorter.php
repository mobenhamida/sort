<?php

declare(strict_types=1);

namespace Adyen\CustomSort\Sorters;

use Adyen\CustomSort\SorterInterface;

class MergeSorter implements SorterInterface
{
    public function sort(array $input, string $sortKey, string $sortOrder): array
    {
        // Stopping condition.
        if (count($input) < 2) {
            return $input;
        }

        // Split array in half.
        $mid = (int)floor((count($input) + 1) / 2);
        $left = array_slice($input, 0, $mid);
        $right = array_slice($input, $mid);

        // Iterate.
        $left = $this->sort($left, $sortKey, $sortOrder);
        $right = $this->sort($right, $sortKey, $sortOrder);

        // Merge the two halves, here is where the sorting actually happens.
        return $this->merge($left, $right, $sortKey, $sortOrder);
    }

    private function merge(array $left, array $right, string $sortKey, string $sortOrder): array
    {
        $result = [];
        $i = 0;
        $j = 0;

        // Merge the arrays while there are elements in both.
        while ($i < count($left) && $j < count($right)) {
            // Get the elements.
            $leftEl = $left[$i][$sortKey] ?? null;
            $rightEl = $right[$j][$sortKey] ?? null;

            if (
                ($sortOrder === 'asc' && $leftEl <= $rightEl)
                || ($sortOrder === 'desc' && $leftEl >= $rightEl)
            ) {
                $result[] = $left[$i];
                $i++;
            } else {
                $result[] = $right[$j];
                $j++;
            }
        }

        // Add any remaining elements from left or right to result.
        // At this step either bother arrays are empty or one of them has remaining elements.
        // Either way the order does not matter.
        while ($i < count($left)) {
            $result[] = $left[$i];
            $i++;
        }

        while ($j < count($right)) {
            $result[] = $right[$j];
            $j++;
        }

        return $result;
    }
}