<?php
require_once('../../libs/WebService.php');
require_once('../../config/config.php');

$new = new WebService();

$dataPost = array("id" => 2);

$data = $new->sendPost($urlTempeProme, $dataPost);
$data = explode(":", $data->result);

$jsonString = "";
foreach ($data as $key => $value) {
   $jsonString .= "'$value'";
   $jsonString .= ($key + 1 < count($data)) ? ', ' : '';
}

echo "[" . $jsonString . "]";
