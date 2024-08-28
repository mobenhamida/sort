<?php

declare(strict_types=1);

namespace Adyen\CustomSort\Sorters;

use Adyen\CustomSort\SorterInterface;

class QuickSorter implements SorterInterface
{
    public function sort(array $input, string $sortKey, string $sortOrder): array
    {
        if (count($input) < 2) {
            return $input;
        }

        // Pick a pivot, make sure it is an array and that it has the sortKey.
        $pivotIndex = $this->pickPivot($input, $sortKey);

        // if no pivot could be selected return same array since it is not sortable.
        if ($pivotIndex === null) {
            return $input;
        }

        $pivot = $input[$pivotIndex];

        $left = $right = $rest = [];

        foreach ($input as $index => $el) {
            if ($index === $pivotIndex) {
                continue;
            }

            // If element is not an array or does not contain sortKey put it aside.
            if (!is_array($el) || !array_key_exists($sortKey, $el)) {
                $rest[] = $el;
                continue;
            }

            // If ascending, put smaller elements before pivot otherwise after.
            if ($sortOrder === 'asc') {
                if ($el[$sortKey] > $pivot[$sortKey]) {
                    $right[] = $el;
                } else {
                    $left[] = $el;
                }
            } else {
                if ($el[$sortKey] > $pivot[$sortKey]) {
                    $left[] = $el;
                } else {
                    $right[] = $el;
                }
            }
        }

        // Repeat for sub arrays left and right and merge results.
        $left = $this->sort($left, $sortKey, $sortOrder);
        $right = $this->sort($right, $sortKey, $sortOrder);

        // Depending on the sorting order put the non-sortable elements to the start of end of the result.
        $before = $sortOrder === 'asc' ? $rest : [];
        $after = $sortOrder === 'desc' ? $rest : [];

        return array_merge($before, $left, [$pivot], $right, $after);
    }

    private function pickPivot(array $input, string $sortKey): ?int
    {
        // There are multiple strategies for selecting the pivot.
        // For this implementation and for the sake of simplicity we just select the first usable one.
        foreach ($input as $index => $item) {
            if (is_array($item) && array_key_exists($sortKey, $item)) {
                return $index;
            }
        }

        return null;
    }
}