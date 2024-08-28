**Important**

I understand that this implementation extends beyond the assignment's requirements. It is intended to showcase skills and explore additional techniques that I deem related to 
the role.<br>
I typically focus on simplicity and efficiency. I am mindful of avoiding over-engineering in practical applications.<br>

**Assumptions**

- Keys are always strings.
- The input array can potentially hold non array elements.
- Sort key can potentially be missing in some arrays.
- Non array elements or arrays that do not contain the sort key are pushed either to the beginning or to the end of the result array depending on the sort order, asc or desc respectively.

**The solution**

The most straightforward would have been a simple implementation of bubble sort. I chose merge sort, adjusted for the requirements of the assignment.

Initially I considered quick sort. It does the trick, but I noticed that managing non array elements leads to some issues:

- Ugly code to handle edge cases explicitly.
- Deciding on a pivot requires validating the elements to check if they hold the sort key.
- Increased cyclomatic complexity because of the extra validation loops.

Merge sort offered a better solution that integrates nicely with the requirements, handling non array elements and pushing them to the edges no longer require explicit logic.

**Structure of the project**

Since this is an assigment for a role related to integrations and plugins I decided to keep both implementations and make a small package out of it.

**Setup**

All you need to do is run composer install to load phpunit and enable autoload:

```bash
composer install
```

**How to run**

I attached a `sort.php` file that you can execute directly. It contains some test data. You can run it with:

```bash
php sort.php
```

**Tests**

To run the tests use:

```bash
# run all the tests
vendor/bin/phpunit

# run QuickSorter tests
vendor/bin/phpunit tests/Sorters/QuickSorterTest.php

# run MergeSorter tests
vendor/bin/phpunit tests/Sorters/MergeSorterTest.php
```

