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

function getQuickestWay($cities, $firstTown) {

    $quickest = removeTown($cities, $firstTown);
    $currentTown = $firstTown;
    $distanceTab = array();
    $tmpLongLat = array();



    foreach ($quickest as $key=>$data) {
        $distanceTab[$key] = getDistanceFromCity($cities[$currentTown], $data);
    }
    $aKeys = array_keys($distanceTab);

    var_dump($distanceTab);

    return $quickest;
}


function getDistanceFromCity($city1, $city2) {
    $_city1 = explode(" ", $city1);
    $_city2 = explode(" ", $city2);
    $distance = distanceCalculation($_city1[1], $_city1[0], $_city2[1], $_city2[0]);
    echo "Distance ";
    var_dump($distance);
    echo " Fin distance <br>";

    return $distance;
}

function removeTown($cities, $town) {

    unset($cities[$town]);
    return $cities;
}


