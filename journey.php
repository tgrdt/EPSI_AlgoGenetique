<?php
/**
 * Created by PhpStorm.
 * User: tgrdt
 * Date: 13/06/2018
 * Time: 08:44
 */
?>

<head>
    <script src="jquery-2.2.4.js"></script>
    <link href="bootstrap.css" rel="stylesheet">
</head>
<html>
<br />
<div class="container">
    <div class="panel panel-default">
        <div class="panel-body">
            <a class="btn-lg btn-primary" role="button" href="index.php" style="position: fixed; right: 25%; top:7%">&nbsp;&nbsp;Retour&nbsp;&nbsp;</a>
            <?php
            include 'functions.php';
            ini_set('memory_limit', '-1');
            set_time_limit(10000);
            if(!empty($_POST)) {



                $json = file_get_contents('cities.json');
                $datas = json_decode($json);
                define('nbIteration', $_POST['nb']);
                $cities = array();
                $allWays = array(); $allWaysCalculated = array();
                $array = array();
                $nb = 0;



                echo '<h1> Population initiale : ' . nbIteration .' </h1>';
                echo '<br />';

                foreach ($datas as $data) {
                    $cities[$data->city] = $data->lan . ' ' .$data->lng;
                }

      //          echo " JSON = ";
      //          var_dump($cities);
      //          echo "<br> Fin JSON <br>";

                $allWays = createPopulation($cities, nbIteration);
      //          echo "<br>Population : <br>";
      //          var_dump($allWays);
                $allWaysCalculated = calculationOfAllWays($allWays);
      //          echo "<br>Distance : <br>";
      //          var_dump($allWaysCalculated);
                $bestWay = bestCombination($allWays);
                $bestWayDistance = bestCombinationDistance($allWays);
                // asort($allWaysCalculated,SORT_NUMERIC);
                // echo "<br>Distance la plus courte : ".current($allWaysCalculated)." <br>";
                echo "<br>Distance la plus courte : ".$bestWayDistance." <br>";
                echo " Le chemin est composé des villes suivantes : <br>";
                foreach ($bestWay as $key=>$city){
                    echo $key."<br>";
                }

                $elitePopulation = getElite($allWays, $allWaysCalculated, nbIteration);

                for($x =0; $x < 10; $x++) {
                    $elitePopulation = coreFunction($elitePopulation, nbIteration);
                }

                $bestWay = bestCombination($elitePopulation);
                $bestWayDistance = bestCombinationDistance($elitePopulation);
               // asort($allWaysCalculated,SORT_NUMERIC);
               // echo "<br>Distance la plus courte : ".current($allWaysCalculated)." <br>";
                echo "<br>Distance la plus courte : ".$bestWayDistance." <br>";
                echo " Le chemin est composé des villes suivantes : <br>";
                foreach ($bestWay as $key=>$city){
                    echo $key."<br>";
                }
              //  var_dump($allWaysCalculated);
              //  sort($allchemins,SORT_NUMERIC);

            } ?>
        </div>
    </div>
</div>
</html>
