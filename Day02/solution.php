<?php
// $path = 'exampleInput';
$path = 'puzzleInput';
$file = fopen($path, 'r');

$nbSafe = 0;
$nbSafeIsh = 0;
while ($line = trim(fgets($file))) {
    $report = explode(" ", $line);
    $nbSafe += isSafe($report);
    $nbSafeIsh += isSafeIsh($report);
}

echo "\nPart 1 - Number of safe reports : " . $nbSafe . "\n";
echo "\nPart 2 - Number of safe-ish reports : " . $nbSafeIsh . "\n";

function isSafe(array $report): int
{
    $direction = $report[1] - $report[0] > 0 ? 1 : -1;

    for ($i = 1; $i < count($report); $i++) {
        $diff = $report[$i] - $report[$i - 1];
        if ($direction * $diff < 0) return 0;
        if (abs($diff) < 1 || abs($diff) > 3) return 0;
    }
    return 1;
}

function isSafeIsh(array $report): int
{
    if(isSafe($report)) return 1;

    for($i = 0; $i < count($report); $i++){
        $smallReport = $report;
        unset($smallReport[$i]);
        $smallReport = array_values($smallReport);
        if(isSafe($smallReport)) return 1;
    }
    return 0;
}
