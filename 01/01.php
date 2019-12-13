<?php

require(__DIR__ . '/../vendor/autoload.php');

$input = explode(PHP_EOL, file_get_contents('input.txt'));

$fuelRequirement = collect($input)->map(function ($mass) {
    return floor($mass / 3) - 2;
})->sum();

echo sprintf('1.1: The total fuel requirement is: %s' . PHP_EOL, $fuelRequirement);

$fuelCalculator = function ($mass) use (&$fuelCalculator) {
    $fuel = floor($mass / 3) - 2;

    if ($fuel <= 0) {
        return 0;
    }

    $fuel += $fuelCalculator($fuel);

    return $fuel;
};

$fuelRequirement = collect($input)->map($fuelCalculator)->sum();

echo sprintf('1.2: The total fuel requirement is: %s' . PHP_EOL, $fuelRequirement);