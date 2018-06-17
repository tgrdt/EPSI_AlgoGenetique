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

                $allWays = createPopulation($cities, nbIteration);

                $allWaysCalculated = calculationOfAllWays($allWays);

                asort($allWaysCalculated,SORT_NUMERIC);
                echo "<br>Distance la plus courte : ".current($allWaysCalculated)." <br>";
                var_dump($allWaysCalculated);
                sort($allchemins,SORT_NUMERIC);

            } ?>
        </div>
    </div>
</div>
</html>
