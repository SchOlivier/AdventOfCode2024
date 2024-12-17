<?php
// $path = 'exampleInput-1';
// $path = 'exampleInput-2';
$path = 'puzzleInput';

$line = file_get_contents($path);
preg_match_all("/mul\((\d+),(\d+)\)/", $line, $matches);

$sumProd = 0;
for ($i = 0; $i < count($matches[0]); $i++) {
    $sumProd += $matches[1][$i] * $matches[2][$i];
}

echo "\nPart 1 - Sum of products : " . $sumProd . "\n";

preg_match_all("/mul\(\d+,\d+\)|do\(\)|don't\(\)/", $line, $matches);
$sumProd = 0;
$do = 1;
foreach ($matches[0] as $string) {
    switch ($string) {
        case "do()":
            $do = 1;
            break;
        case "don't()":
            $do = 0;
            break;
        default:
            preg_match("/(\d+),(\d+)/", $string, $numbers);
            $sumProd += $do * $numbers[1] * $numbers[2];
    }
}

echo "\nPart 2 - Sum of products : " . $sumProd . "\n";