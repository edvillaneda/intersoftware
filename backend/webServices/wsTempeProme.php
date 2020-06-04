<?php
require_once('../../libs/WebService.php');
require_once('../../config/config.php');

$new = new WebService();

$dataPost = array(
   "start_date" => "2020-06-01 15:53:00.688705",
   "end_date" => "2020-06-01 15:55:00.688705"
);

$data = $new->sendPost($urlTempeProme, $dataPost);
$data = explode(":", $data->result);

$jsonString = "";
foreach ($data as $key => $value) {
   $jsonString .= "'$value'";
   $jsonString .= ($key + 1 < count($data)) ? ', ' : '';
}

echo "[" . $jsonString . "]";
