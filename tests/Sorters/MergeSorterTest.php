<?php

declare(strict_types=1);

namespace Sorters;

use Adyen\CustomSort\SorterInterface;
use Adyen\CustomSort\Sorters\MergeSorter;
use PHPUnit\Framework\TestCase;

class MergeSorterTest extends TestCase
{
    private SorterInterface $sorter;

    protected function setUp(): void
    {
        parent::setUp();
        $this->sorter = new MergeSorter();
    }

    public function testSortInAscendingOrder(): void
    {
        $input =  [
            ['name' => 'Jane', 'age' => 24],
            ['name' => 'Omar', 'age' => 21],
            ['name' => 'Amir', 'age' => 30],
            ['name' => 'Sara', 'age' => 22]
        ];

        $expected = [
            ['name' => 'Omar', 'age' => 21],
            ['name' => 'Sara', 'age' => 22],
            ['name' => 'Jane', 'age' => 24],
            ['name' => 'Amir', 'age' => 30]
        ];

        $result = $this->sorter->sort($input, 'age', 'asc');
        $this->assertEquals($expected, $result);
    }

    public function testSortInDescendingOrder(): void
    {
        $input = [
            ['name' => 'Jane', 'age' => 24],
            ['name' => 'Omar', 'age' => 21],
            ['name' => 'Amir', 'age' => 30],
            ['name' => 'Sara', 'age' => 22]
        ];

        $expected = [
            ['name' => 'Amir', 'age' => 30],
            ['name' => 'Jane', 'age' => 24],
            ['name' => 'Sara', 'age' => 22],
            ['name' => 'Omar', 'age' => 21]
        ];

        $result = $this->sorter->sort($input, 'age', 'desc');
        $this->assertEquals($expected, $result);
    }

    public function testSortWithMissingKey(): void
    {
        $input = [
            ['name' => 'Jane', 'age' => 24],
            ['name' => 'Omar'],
            ['name' => 'Amir', 'age' => 30],
            ['name' => 'Sara', 'age' => 22]
        ];

        $expected = [
            ['name' => 'Omar'],
            ['name' => 'Sara', 'age' => 22],
            ['name' => 'Jane', 'age' => 24],
            ['name' => 'Amir', 'age' => 30]
        ];

        $result = $this->sorter->sort($input, 'age', 'asc');
        $this->assertEquals($expected, $result);
    }

    public function testSortWithEmptyArray(): void
    {
        $input = [];
        $expected = [];
        $result = $this->sorter->sort($input, 'age', 'asc');
        $this->assertEquals($expected, $result);
    }

    public function testSortWithSingleElement(): void
    {
        $input = [['name' => 'Jane', 'age' => 24]];
        $expected = [['name' => 'Jane', 'age' => 24]];
        $result = $this->sorter->sort($input, 'age', 'asc');
        $this->assertEquals($expected, $result);
    }

    public function testSortWithNonAssociativeArrayElements(): void
    {
        $input = [
            ['name' => 'Jane', 'age' => 24],
            'hello',
            12,
            null,
            [],
            ['name' => 'Omar', 'age' => 21]
        ];

        $expected = [
            'hello',
            12,
            null,
            [],
            ['name' => 'Omar', 'age' => 21],
            ['name' => 'Jane', 'age' => 24]
        ];

        $result = $this->sorter->sort($input, 'age', 'asc');
        $this->assertEquals($expected, $result);
    }
}
