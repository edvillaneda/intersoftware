<?php
require_once('../../libs/WebService.php');

$new = new WebService();

$url = "http://localhost/intersoftware/test/wsTest.php";
$dataPost = array("id" => 69);


$data = json_decode($new->sendPost($url, $dataPost));
$data = explode(":", $data->result);

$jsonString = "";
foreach ($data as $value) {
   $jsonString .= "'$value', ";
}

echo "[" . $jsonString . "]";
