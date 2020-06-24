<?php
require_once('../../libs/WebService.php');
require_once('../../config/config.php');


$new = new WebService();

// $dataPost = array("id" => 69);

$end_date = date("Y-m-d H:i:s.000000");
$start_date = date("Y-m-d H:i:s.000000", strtotime($ahora) - 60 * 60);

// $dataPost = array(
//    "start_date" => "2020-06-01 15:53:00.688705",
//    "end_date" => "2020-06-01 15:55:00.688705"
// );

$dataPost = array(
   "start_date" => $start_date,
   "end_date" => $end_date
);


$data = $new->sendPost(URL_WEB_SERVICE, $dataPost);

$cont = 0;
foreach ($data->results->interval->analytics as $key => $value) {

   if ($key == 'events') {
      continue;
   }

   $interval['titulo'][$cont] .= ucfirst($key);
   $interval['valor'][$cont] .= $value->mean;
   $cont++;
}

echo json_encode($interval);
