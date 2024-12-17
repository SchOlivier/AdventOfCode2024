<?php
// $path = 'exampleInput';
$path = 'puzzleInput';
$file = fopen($path, 'r');

$grid = [];
while ($line = trim(fgets($file))) {
    $grid[] = str_split($line);
}

$countXMAS = 0;
$countX_MAS = 0;
for ($row = 0; $row < count($grid); $row++) {
    for ($col = 0; $col < count($grid[$row]); $col++) {
        $countXMAS += countXMAS($row, $col);
        $countX_MAS += isX_MAS($row, $col) ? 1 : 0;
    }
}

echo "\nPart 1 - Number of XMAS : " . $countXMAS . "\n";
echo "\nPart 1 - Number of X-MAS : " . $countX_MAS . "\n";

function countXMAS(int $row, int $col): int
{
    $count = 0;
    global $grid;
    if ($grid[$row][$col] != 'X') return 0;

    // top
    if (
        $row >= 3 &&
        $grid[$row - 1][$col] == 'M' &&
        $grid[$row - 2][$col] == 'A' &&
        $grid[$row - 3][$col] == 'S'
    ) {
        $count++;
        // echo "[$row, $col] : top\n";
    }

    // top right
    if (
        $row >= 3 &&
        $col <= count($grid[0]) - 4 &&
        $grid[$row - 1][$col + 1] == 'M' &&
        $grid[$row - 2][$col + 2] == 'A' &&
        $grid[$row - 3][$col + 3] == 'S'
    ) {
        $count++;
        // echo "[$row, $col] : top right\n";
    }

    // top left
    if (
        $row >= 3 &&
        $col >= 3 &&
        $grid[$row - 1][$col - 1] == 'M' &&
        $grid[$row - 2][$col - 2] == 'A' &&
        $grid[$row - 3][$col - 3] == 'S'
    ) {
        $count++;
        // echo "[$row, $col] : top left\n";
    }

    // left
    if (
        $col >= 3 &&
        $grid[$row][$col - 1] == 'M' &&
        $grid[$row][$col - 2] == 'A' &&
        $grid[$row][$col - 3] == 'S'
    ) {
        $count++;
        // echo "[$row, $col] : left\n";
    }

    // right
    if (
        $col <= count($grid[0]) - 4 &&
        $grid[$row][$col + 1] == 'M' &&
        $grid[$row][$col + 2] == 'A' &&
        $grid[$row][$col + 3] == 'S'
    ) {
        $count++;
        // echo "[$row, $col] : right\n";
    }

    // bottom
    if (
        $row <= count($grid) - 4 &&
        $grid[$row + 1][$col] == 'M' &&
        $grid[$row + 2][$col] == 'A' &&
        $grid[$row + 3][$col] == 'S'
    ) {
        $count++;
        // echo "[$row, $col] : bottom\n";
    }

    // bottom right
    if (
        $row <= count($grid) - 4 &&
        $col <= count($grid[0]) - 4 &&
        $grid[$row + 1][$col + 1] == 'M' &&
        $grid[$row + 2][$col + 2] == 'A' &&
        $grid[$row + 3][$col + 3] == 'S'
    ) {
        $count++;
        // echo "[$row, $col] : bottom right\n";
    }

    // bottom left
    if (
        $row <= count($grid) - 4 &&
        $col >= 3 &&
        $grid[$row + 1][$col - 1] == 'M' &&
        $grid[$row + 2][$col - 2] == 'A' &&
        $grid[$row + 3][$col - 3] == 'S'
    ) {
        $count++;
        // echo "[$row, $col] : bottom left\n";
    }

    return $count;
}

function isX_MAS(int $row, int $col): bool
{
    global $grid;
    if ($grid[$row][$col] != 'A') return false;
    if ($row == 0 || $col == 0 || $row == count($grid)-1 || $col == count($grid[0])-1) return false;

    $string = $grid[$row - 1][$col - 1] . $grid[$row + 1][$col + 1] . $grid[$row + 1][$col - 1] . $grid[$row - 1][$col + 1];
    return in_array($string, ['MSMS', 'MSSM', 'SMSM', 'SMMS']);
}
