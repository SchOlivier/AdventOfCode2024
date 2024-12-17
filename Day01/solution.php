<?php
// $path = 'exampleInput';
$path = 'puzzleInput';
$file = fopen($path, 'r');

$list1 = [];
$list2 = [];

while ($line = trim(fgets($file))) {
    preg_match("/(\d+)\s+(\d+)/", $line, $matches);
    $list1[]=$matches[1];
    $list2[]=$matches[2];
}

sort($list1);
sort($list2);

$distance = 0;
for($i=0; $i<count($list1); $i++){
    $distance+= abs($list1[$i] - $list2[$i]);
}

echo "\nPart 1 - Distance : " . $distance . "\n";

$occurences = array_count_values($list2);
$similarity = 0;

foreach($list1 as $key){
    $similarity += $key * ($occurences[$key] ?? 0);
}

echo "\nPart 2 - Similarity : " . $similarity . "\n";