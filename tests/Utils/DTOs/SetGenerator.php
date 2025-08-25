<?php

declare(strict_types=1);

namespace Tests\Utils\DTOs;

class SetGenerator
{
    public static function generate(array $values, int $amounts): array
    {
        $sets = [];
        $indices = range(0, count($values) - 1);

        foreach (self::combinations($indices, $amounts) as $combo) {
            $set = array_fill(0, count($values), null);
            foreach ($combo as $indexes) {
                $set[$indexes] = $values[$indexes];
            }
            $sets[] = $set;
        }

        return $sets;
    }

    private static function combinations(array $items, int $count): array
    {
        if ($count === 0) {
            return [[]];
        }
        if (count($items) < $count) {
            return [];
        }

        $combinations = [];
        $head = $items[0];
        $tail = array_slice($items, 1);

        foreach (self::combinations($tail, $count - 1) as $combination) {
            array_unshift($combination, $head);
            $combinations[] = $combination;
        }

        foreach (self::combinations($tail, $count) as $combination) {
            $combinations[] = $combination;
        }

        return $combinations;
    }
}
