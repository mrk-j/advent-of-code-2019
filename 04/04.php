<?php

require(__DIR__ . '/../vendor/autoload.php');

$input = explode('-', file_get_contents('input.txt'));

$filter = function ($password) use (&$part) {
    $hasAdjecent = collect(range(0, 9))->filter(function ($i) use ($password, $part) {
        if ($part === 1) {
            return strpos($password, $i . $i) !== false;
        }

        return strpos($password, $i . $i) !== false && strpos($password, $i . $i . $i) === false;
    })->count();

    if ($hasAdjecent === 0) {
        return false;
    }

    $digits = str_split($password);

    foreach ($digits as $i => $digit) {
        if ($i > 0 && $digit < $digits[$i - 1]) {
            return false;
        }
    }

    return true;
};

foreach ([1, 2] as $part) {
    $validPasswords = collect(range($input[0], $input[1]))->filter($filter);

    echo '4.' . $part . ': The number of passwords meeting all criteria: ' . $validPasswords->count() . PHP_EOL;
}