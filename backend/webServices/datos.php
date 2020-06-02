<?php
require_once('../../libs/WebService.php');

$new = new WebService();

$url = "http://localhost/intersoftware/test/wsTest.php";
$data = array("id" => 69);


$resultado = json_decode($new->sendPost($url, $data));

$resultado = $resultado->{'Result'};

$resultado = explode(":", $resultado);


// $jsonString = "'" . $resultado[0] . "'," . "'" . $resultado[1] . "'," . "'" . $resultado[2] . "'," . "'" . $resultado[3] . "'," . "'" . $resultado[4] . "'," . "'" . $resultado[5] . "'," . "'" . $resultado[6] . "'," . "'" . $resultado[7] . "'," . "'" . $resultado[8] . "'," . "'" . $resultado[9] . "'," . "'" . $resultado[10] . "'," . "'" . $resultado[11] . "'," . "'" . $resultado[12] . "'," . "'" . $resultado[13] . "',";
$jsonString = "";
foreach ($resultado as $value) {
   $jsonString .= "'$value', ";
}



echo "[" . $jsonString . "]";
