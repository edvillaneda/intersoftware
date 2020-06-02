<?php
require_once('../../libs/WebService.php');
require_once('../../config/config.php');

$new = new WebService();

$data = array("id" => 69);


$resultado = json_decode($new->sendPost($urlTempeProme, $data));

$resultado = $resultado->{'Result'};

$resultado = explode(":", $resultado);

$jsonString = "";
foreach ($resultado as $value) {
   $jsonString .= "'$value', ";
}

echo "[" . $jsonString . "]";
