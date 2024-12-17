<?php
// $path = 'exampleInput';
$path = 'puzzleInput';
$file = fopen($path, 'r');

while ($line = trim(fgets($file))) {
    $target = (int)substr($line, 0, strpos($line, ':'));
    $numbers = explode(' ', trim(substr($line, strpos($line, ':') + 1)));
    $tests[] = [$target, $numbers];
}

$sum1 = 0;
$sum2 = 0;
foreach ($tests as $test) {
    $target = $test[0];
    $numbers = $test[1];

    $result = array_shift($numbers);
    if (checkTest1($target, $result, $numbers)) $sum1 += $target;
    if (checkTest2($target, $result, $numbers)) $sum2 += $target;
}

echo "\nPart 1 - sum : $sum1\n";
echo "\nPart 2 - sum : $sum2\n";

function checkTest1(int $target, int $result, array $numbers): bool
{
    if ($result > $target) return false;
    if (empty($numbers)) return $result == $target;

    $n = array_shift($numbers);
    $resultPlus = $result + $n;
    $resultMult = $result * $n;

    return checkTest1($target, $resultPlus, $numbers) || checkTest1($target, $resultMult, $numbers);
}

function checkTest2(int $target, int $result, array $numbers): bool
{
    if ($result > $target) return false;
    if (empty($numbers)) return $result == $target;

    $n = array_shift($numbers);
    $resultPlus = $result + $n;
    $resultMult = $result * $n;
    $resultConcat = (int)($result . $n);

    return checkTest2($target, $resultPlus, $numbers) ||
        checkTest2($target, $resultMult, $numbers) ||
        checkTest2($target, $resultConcat, $numbers);
}
