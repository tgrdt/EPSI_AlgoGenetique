<?php
/**
 * Created by PhpStorm.
 * User: tgrdt
 * Date: 13/06/2018
 * Time: 08:43
 */

// Récupération des villes du JSon

$json = file_get_contents('cities.json');
$datas = json_decode($json);
$cities = array();

foreach ($datas as $key=>$data) {
    $cities[$key] = $data->city ;
}

?>
<head>
    <script src="jquery-2.2.4.js"></script>
    <link href="bootstrap.css" rel="stylesheet">
</head>
<html>
<div class="container">
    <br />
    <br />
    <div class="panel panel-default">
        <div class="panel-heading text-center"><h3>Algorithmes génétiques</h3></div>
        <div class="panel-body">
            <form method="POST" action="journey.php">
                <label>Taille population initiale :</label>
                <input type="text" name="nb" class="form-control">
                <br />
                <input type="submit" class="btn btn-primary">
            </form>
        </div>
    </div>
</div>
</html>

