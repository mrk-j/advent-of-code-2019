<?php

ini_set('memory_limit', '2G');

require(__DIR__ . '/../vendor/autoload.php');

$wires = collect(explode(PHP_EOL, file_get_contents('input.txt')))->map(function ($wire) {
    return collect(explode(',', $wire));
});

$paths = $wires->map(function ($instructions) {
    $positions = collect([[0, 0]]);

    foreach ($instructions as $instruction) {
        $times = substr($instruction, 1);

        switch (substr($instruction, 0, 1)) {
            case 'U':
                $direction = [0, -1];
                break;

            case 'R':
                $direction = [1, 0];
                break;

            case 'D':
                $direction = [0, 1];
                break;

            case 'L':
                $direction = [-1, 0];
                break;
        }

        foreach (range(1, $times) as $i) {
            $newPosition = $positions->get($positions->count() - 1);

            $newPosition[0] += $direction[0];
            $newPosition[1] += $direction[1];

            $positions->push($newPosition);
        }
    }

    return $positions;
});

$mapper = function ($array) {
    return $array[0] . ',' . $array[1];
};

$intersections = $paths[0]
    ->keyBy($mapper)
    ->intersectByKeys($paths[1]->keyBy($mapper))
    ->filter(function ($intersection) {
        return $intersection !== [0, 0];
    });

$distance = $intersections->map(function ($intersection) {
    return abs($intersection[0]) + abs($intersection[1]);
})->min();

echo '3.1: The Manhattan distance from the center to the closest intersection: ' . $distance . PHP_EOL;

$steps = $intersections->map(function ($intersection) use ($paths) {
    return $paths[0]->search($intersection) + $paths[1]->search($intersection);
})->min();

echo '3.2: The fewest combined steps to reach an intersection are: ' . $steps . PHP_EOL;