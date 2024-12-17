<?php
// $path = 'exampleInput';
$path = 'puzzleInput';
$file = fopen($path, 'r');

$row = 0;
$frequencies = [];
while ($line = trim(fgets($file))) {
    $width = strlen($line);
    $matches = [];
    preg_match_all('/[^\.]/', $line, $matches, PREG_OFFSET_CAPTURE);
    foreach ($matches[0] as $match) {
        $frequencies[$match[0]][] = [$row, $match[1]];
    }
    $row++;
}

define('HEIGHT', $row);
define('WIDTH', $width);

foreach ($frequencies as $f => $antennas) {
    $current = array_shift($antennas);
    while (!empty($antennas)) {
        foreach ($antennas as $a) {
            $dx = $a[0] - $current[0];
            $dy = $a[1] - $current[1];

            $nodes[] = [$a[0] + $dx, $a[1] + $dy];
            $nodes[] = [$current[0] - $dx, $current[1] - $dy];
        }
        $current = array_shift($antennas);
    }
}

$nodes = array_filter($nodes, function ($n) {
    return
        $n[0] >= 0 &&
        $n[1] >= 0 &&
        $n[0] < HEIGHT &&
        $n[1] < WIDTH;
});

$nodes = array_unique(array_map(function ($n) {
    return $n[0] . "," . $n[1];
}, $nodes));

echo "\nPart1 : nodes count : " . count($nodes) . "\n";

$nodes = [];
foreach ($frequencies as $f => $antennas) {
    $current = array_shift($antennas);
    $nodes[$current[0] . "," . $current[1]] = 1;
    while (!empty($antennas)) {
        foreach ($antennas as $a) {
            $dx = $a[0] - $current[0];
            $dy = $a[1] - $current[1];

            for ($i = 1; true; $i++) {
                $x = $current[0] - $i * $dx;
                $y = $current[1] - $i * $dy;
                if ($x < 0 || $x >= HEIGHT || $y < 0 || $y >= WIDTH) break;
                $nodes[$x . "," . $y] = 1;
            }

            for ($i = 1; true; $i++) {
                $x = $current[0] + $i * $dx;
                $y = $current[1] + $i * $dy;
                if ($x < 0 || $x >= HEIGHT || $y < 0 || $y >= WIDTH) break;
                $nodes[$x . "," . $y] = 1;
            }
        }
        $current = array_shift($antennas);
        $nodes[$current[0] . "," . $current[1]] = 1;
    }
}

echo "\nPart2 : nodes count : " . count($nodes) . "\n";
