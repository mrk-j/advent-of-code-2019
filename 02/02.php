<?php

require(__DIR__ . '/../vendor/autoload.php');

$opcodes = collect(explode(',', file_get_contents('input.txt')))->map(function ($value) {
    return (int)$value;
});

$program = function ($opcodes, $noun, $verb) {
    $position = 0;

    $opcodes->put(1, $noun);
    $opcodes->put(2, $verb);

    while (in_array($opcode = $opcodes[$position], [1, 2, 99])) {
        if ($opcode === 99) {
            break;
        }

        list($positionA, $positionB, $positionResult) = $opcodes->slice($position + 1, 3)->values();

        if ($opcode === 1) {
            $opcodes->put($positionResult, $opcodes[$positionA] + $opcodes[$positionB]);
        } elseif ($opcode === 2) {
            $opcodes->put($positionResult, $opcodes[$positionA] * $opcodes[$positionB]);
        } else {
            throw new Exception('Unknown opcode ' . $opcode);
        }

        $position += 4;
    }

    return $opcodes[0];
};

echo '2.1: The value left at position 0 is: ' . $program(clone $opcodes, 12, 2) . PHP_EOL;

foreach (range(0, 99) as $noun) {
    foreach (range(0, 99) as $verb) {
        try {
            $result = $program(clone $opcodes, $noun, $verb);

            if ($result === 19690720) {
                echo '2.2 100 * noun + verb: ' . (100 * $noun + $verb) . PHP_EOL;

                break 2;
            }
        } catch (Exception $e) {

        }
    }
}