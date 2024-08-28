<?php

declare(strict_types=1);

namespace Adyen\CustomSort;

interface SorterInterface
{
    function sort(array $input, string $sortKey, string $sortOrder): array;
}