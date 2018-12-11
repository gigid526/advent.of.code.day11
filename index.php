<?php
$gridSize = 300;
$serialNumber = 6548;
//the first task
function calculateFuelCellsPower($x, $y, $serialNumber)
{
    $rackId = $x + 10;
    $powerLevelStart = $rackId * $y;
    $addedSerialNumber = $powerLevelStart + $serialNumber;
    $multipliedByRackId = $addedSerialNumber * $rackId;
    $hundreds = floor($multipliedByRackId / 100);
    if ($multipliedByRackId > 99 || $multipliedByRackId < (-99))
        $hundreds = substr($multipliedByRackId, (strlen($multipliedByRackId)-3), 1);
    else 
        $hundreds = 0;
    return $hundreds[0] - 5;
}
function preparePartialSums($serialNumber, $gridSize)
{
    for ($y = 1; $y <= $gridSize; $y++) {
        for ($x = 1; $x <= $gridSize; $x++) {
            $partialSums[$y][$x] = calculateFuelCellsPower($x, $y, $serialNumber)
                + (isset($partialSums[$y - 1][$x]) ? $partialSums[$y - 1][$x] : 0)
                + (isset($partialSums[$y][$x - 1]) ? $partialSums[$y][$x - 1] : 0)
                - (isset($partialSums[$y - 1][$x - 1]) ? $partialSums[$y - 1][$x - 1] : 0);
        }
    }
    return $partialSums;
}
$partialSums = preparePartialSums($serialNumber, $gridSize);
function findMaxPowerSquareCoordinates($partialSums, $gridSize)
{
    $size = 3;
    $maxPower = 0;
    $bestX = null;
    $bestY = null;
    for ($y = $size; $y <= $gridSize; $y++) {
        for ($x = $size; $x <= $gridSize; $x++) {
            $power = $partialSums[$y][$x]
                - (isset($partialSums[$y - $size][$x]) ? $partialSums[$y - $size][$x] : 0)
                - (isset($partialSums[$y][$x - $size]) ? $partialSums[$y][$x - $size] : 0)
                + (isset($partialSums[$y - $size][$x - $size]) ? $partialSums[$y - $size][$x - $size] : 0);
            if ($power > $maxPower) {
                $maxPower = $power;
                $bestX = $x - $size;
                $bestY = $y - $size;
            }
        }
    }
    echo (($bestX + 1) . " " . ($bestY + 1)) . PHP_EOL;
}
findMaxPowerSquareCoordinates($partialSums, $gridSize);
//the second task
function findMaxPowerSquareCoordinatesAndSize($partialSums, $gridSize)
{
    $maxPower = 0;
    $bestX = null;
    $bestY = null;
    $bestSize = 0;
    for ($size = 1; $size <= $gridSize; $size++) {
        for ($y = $size; $y <= $gridSize; $y++) {
            for ($x = $size; $x <= $gridSize; $x++) {
                $power = $partialSums[$y][$x]
                    - (isset($partialSums[$y - $size][$x]) ? $partialSums[$y - $size][$x] : 0)
                    - (isset($partialSums[$y][$x - $size]) ? $partialSums[$y][$x - $size] : 0)
                    + (isset($partialSums[$y - $size][$x - $size]) ? $partialSums[$y - $size][$x - $size] : 0);
                if ($power > $maxPower) {
                    $maxPower = $power;
                    $bestX = $x - $size;
                    $bestY = $y - $size;
                    $bestSize = $size;
                }
            }
        }
    }
    
    echo (($bestX + 1) . " " . ($bestY + 1) . " " . $bestSize) . PHP_EOL;
}
findMaxPowerSquareCoordinatesAndSize($partialSums, $gridSize);