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

                echo " JSON = ";
                var_dump($cities);
                echo "<br> Fin JSON <br>";

                $allWays = createPopulation($cities, nbIteration, $datas);

                $allWaysCalculated = calculationOfAllWays($allWays);
                echo " <br>Distances calcul = <br>";
                var_dump($allWaysCalculated);
/*
                foreach ($combinaisons as $combinaison) {
                    $arrayvilles = explode(' ', $combinaison);
                    $total = 0;
                    $i = 0;
                    $a = 0;
                    $b = 1;
                    $c = 2;
                    $d = 3;
                    $nb++;
                    echo '<h3>Test du chemin n° '.$nb.'...</h3>';
                    while($i < 14) {
                        $distance = getDistance($arrayvilles[$a], $arrayvilles[$b], $arrayvilles[$c], $arrayvilles[$d]);
                        foreach ($datas as $data) {
                            if($data->lan == $arrayvilles[$a]){
                                $ville1 = $data->city;
                            }
                            if($data->lan == $arrayvilles[$c]){
                                $ville2 = $data->city;
                            }
                        }
                        $total = $total + $distance;
                        if($i == 0) {
                            echo 'De <b>' .$ville1 . '</b> à <b>' . $ville2 . '</b> ('.ceil($distance/1000).' km), ';
                            echo '<br />';
                        } else {
                            echo 'de <b>' .$ville1 . '</b> à <b>' . $ville2 . '</b> ('.ceil($distance/1000).' km), ';
                            echo '<br />';
                        }
                        $a = $c;
                        $b = $d;
                        $c = $c+2;
                        $d = $d+2;
                        $i++;

                    }
                    array_push($allchemins, $total);
                    echo '<br >';
                    echo 'Distance total de : <b>' . ceil($total/1000) .' Km.</b>';
                    echo '<br />';

                }

                */
                asort($allWaysCalculated,SORT_NUMERIC);
                echo "<br>Distance la plus court : ".current($allWaysCalculated);
                sort($allchemins,SORT_NUMERIC);
                echo '<br />';
                echo '<h2>Le chemin optimal trouvé est de : ' . ceil($allchemins[0]/1000) . ' Km.</h2>';
                echo '<br />';
            } ?>
        </div>
    </div>
</div>
</html>
