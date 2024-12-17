<?php
// $path = 'exampleInput';
$path = 'puzzleInput';
$file = fopen($path, 'r');

$grid = [];
$pos = [0, 0];
while ($line = trim(fgets($file))) {
    $grid[] = str_split($line);
    if (strpos($line, '^') !== false) {
        $startingPos = [count($grid) - 1, strpos($line, '^')];
    }
}

define("HEIGHT", count($grid));
define("WIDTH", count($grid[0]));
define("VECTORS", [
    'u' => [-1, 0],
    'd' => [1, 0],
    'l' => [0, -1],
    'r' => [0, 1]
]);
define("NEXTVECTOR", [
    'u' => 'r',
    'r' => 'd',
    'd' => 'l',
    'l' => 'u'
]);
define("START", $startingPos);

$dir = 'u';
$obstacles = [];
$visited = [];

navigate($grid, $startingPos, $dir, $visited, $obstacles, true);
unset($obstacles[implode(',', $startingPos)]);

echo "\nPart 1 - cells visited : " . count($visited) . "\n";
echo "Part 2 - possible obstacles : " . count($obstacles) . "\n\n";

// returns true if the grid is exited normally, and false if the path is looping
function navigate(array $grid, array $pos, string $dir, array &$visited, array &$obstacles, bool $checkForPossibleLoops): bool
{
    while (true) {
        if (isset($visited[implode(',', $pos)]) && in_array($dir, $visited[implode(',', $pos)])) {
            return false;
        }

        $visited[implode(',', $pos)][] = $dir;

        $v = VECTORS[$dir];
        $nextPos = [
            $pos[0] + $v[0],
            $pos[1] + $v[1]
        ];

        if (
            $nextPos[0] < 0 || $nextPos[0] == WIDTH ||
            $nextPos[1] < 0 || $nextPos[1] == HEIGHT
        )
            return true;

        if ($grid[$nextPos[0]][$nextPos[1]] == '#') {
            $dir = NEXTVECTOR[$dir];
        } else {
            if ($checkForPossibleLoops && !isset($visited[implode(',', $nextPos)])) {
                $newGrid = $grid;
                $newGrid[$nextPos[0]][$nextPos[1]] = '#';
                $newDir = NEXTVECTOR[$dir];
                $newVisited = $visited;
                if (!navigate($newGrid, $pos, $newDir, $newVisited, $obstacles, false)) {
                    $obstacles[implode(',', $nextPos)] = 1;
                }
            }
            $pos = $nextPos;
        }
    }
}