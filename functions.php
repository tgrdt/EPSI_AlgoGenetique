<?php
/**
 * Created by PhpStorm.
 * User: tgrdt
 * Date: 13/06/2018
 * Time: 09:16
 */

function distanceCalculation($point1_lat, $point1_long, $point2_lat, $point2_long, $unit = 'km', $decimals = 2) {
    // Calcul de la distance en degrés
    $degrees = rad2deg(acos((sin(deg2rad($point1_lat))*sin(deg2rad($point2_lat))) + (cos(deg2rad($point1_lat))*cos(deg2rad($point2_lat))*cos(deg2rad($point1_long-$point2_long)))));

    // Conversion de la distance en degrés à l'unité choisie (kilomètres, milles ou milles nautiques)
    switch($unit) {
        case 'km':
            $distance = $degrees * 111.13384; // 1 degré = 111,13384 km, sur base du diamètre moyen de la Terre (12735 km)
            break;
        case 'mi':
            $distance = $degrees * 69.05482; // 1 degré = 69,05482 milles, sur base du diamètre moyen de la Terre (7913,1 milles)
            break;
        case 'nmi':
            $distance =  $degrees * 59.97662; // 1 degré = 59.97662 milles nautiques, sur base du diamètre moyen de la Terre (6,876.3 milles nautiques)
    }
    return round($distance, $decimals);
}

function createPopulation($cities, $nbIteration) {

    $population = array();
    for($i = 0; $i < $nbIteration; $i++) {

        $population[$i]= createCombination($cities, $population);
    }
    return $population;
}

function createCombination($cities, $previousCombinations) {
    $unique = false;
    $sizeCombinaison = count($cities) - 1;
    $numberUsed = array();
    $combination = array();

    while($unique == false) {

        foreach($cities as $key=>$data) {
            $aKeys = array_keys($cities);
            $randNumber = rand(0, $sizeCombinaison);
            $numberAlreadyUsed = true;
            $combinationToPush = array();
            if(count($numberUsed) != 0 ) {
                while($numberAlreadyUsed == true) {
                    $randNumber = rand(0, $sizeCombinaison);
                    if(in_array($randNumber, $numberUsed) == false){
                        $numberAlreadyUsed = false;
                        array_push($numberUsed, $randNumber);
                    }
                }
            } else if(count($numberUsed )== 0 ) {
                array_push($numberUsed, $randNumber);
            }

            $randTown = $aKeys[$randNumber];
            $combinationToPush[$randTown] = $cities[$randTown];
            $combination[$randTown] = $cities[$randTown];
        }

        if(in_array($previousCombinations, $combination) == false) {
            $unique = true;
        }
    }

    return $combination;

}

function calculationOfAllWays($allWays){
    $allWaysCalculated = array();
    $iteratorAllWays = 0;

    foreach ($allWays as $way) {

        $aKeys = array_keys($way);
        $oneWayCalculated = array();
        for($i = 1; $i < (count($way) -1); $i++) {
            if($i == 1) {
                $oneWayCalculated[0] = getDistanceFromCity($way[$aKeys[0]], $way[$aKeys[$i]]);
            } else {
                $oneWayCalculated[$i - 1] = getDistanceFromCity($way[$aKeys[$i]], $way[$aKeys[$i +1]]);
            }
        }

        $allWaysCalculated[$iteratorAllWays] = getTotalDistance($oneWayCalculated);
        $iteratorAllWays++;

    }


    return $allWaysCalculated;
}

function getTotalDistance($way){
    $totalDistance = 0;
    for($i = 0; $i < count($way); $i++) {
        $totalDistance += $way[$i];
    }

    return $totalDistance;
}

function getDistanceFromCity($city1, $city2) {
    $_city1 = explode(" ", $city1);
    $_city2 = explode(" ", $city2);
    $distance = distanceCalculation($_city1[1], $_city1[0], $_city2[1], $_city2[0], 'km',  2);

    return $distance;
}

function removeTown($cities, $town) {

    unset($cities[$town]);
    return $cities;
}

function getElite($allWays, $allWaysCalculated, $nbIteration) {
    asort($allWaysCalculated,SORT_NUMERIC);
    $i = 0;
    $eliteArrayCombination = array();
    if($nbIteration % 2 == 0) {
        $sizeElite = $nbIteration / 2;
    } else{
        $sizeElite = ($nbIteration - 1) / 2;
    }

    foreach ($allWaysCalculated as $key=>$way) {
        if($i < $sizeElite) {
         //   echo $i." key ".$key." distance : ".$way."<br>";
            $eliteArrayCombination[$i] = $allWays[$key];
        }
        $i++;
    }

    return $eliteArrayCombination;
}

function bestCombination($population) {

    $populationCalculated = calculationOfAllWays($population);
    asort($populationCalculated, SORT_NUMERIC);
    $keyBestWay = key($populationCalculated);
    $optimalWay = $population[$keyBestWay];
    return $optimalWay;
}

function bestCombinationDistance($population) {
    $populationCalculated = calculationOfAllWays($population);
    asort($populationCalculated, SORT_NUMERIC);
    $optimalWay = current($populationCalculated);
    return $optimalWay;
}
