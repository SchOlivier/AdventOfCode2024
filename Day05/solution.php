<?php
// $path = 'exampleInput';
$path = 'puzzleInput';
$file = fopen($path, 'r');

$rules = [];
while ($line = trim(fgets($file))) {
    $rule = explode("|", $line);
    $rules[$rule[0]][] = $rule[1];
}

// echo "\n\n----- Rules -----\n";
// print_r($rules);

$updates = [];
while ($line = trim(fgets($file))) {
    $updates[] = explode(',', $line);
}

$part1 = 0;
$part2 = 0;
foreach ($updates as $update) {
    $check = checkUpdate($update);
    if ($check['isValid']) {
        $part1 += getMiddlePage($update);
    }
    else {
        while(!$check['isValid']){
            $i = $check['keysToSwap'][0];
            $j = $check['keysToSwap'][1];
            $tmp = $update[$i];
            $update[$i] = $update[$j];
            $update[$j] = $tmp;
            $check = checkUpdate($update);
        } 
        $part2 += getMiddlePage($update);
    }
}

echo "\nPart 1 - Sum of pages : " . $part1 . "\n";
echo "\nPart 2 - Sum of pages : " . $part2 . "\n";

function checkUpdate($update): array
{
    global $rules;

    // echo "\n\n--- [" . implode(",", $update) . "]----\n";
    for ($i = 0; $i < count($update) - 1; $i++) {
        $left = $update[$i];
        for ($j = $i+1; $j < count($update); $j++) {
            $right = $update[$j];
            if (isset($rules[$right]) && in_array($left, $rules[$right])) {
                // echo "\nInvalid, $left is before $right\n";
                return ['isValid' => false, 'keysToSwap' => [$i, $j]];
            }
        }
    }
    return ['isValid' => true, 'keysToSwap' => []];
}

function getMiddlePage(array $update): int
{
    // 1,2,3,4,5
    return $update[(count($update) - 1) / 2];
}
