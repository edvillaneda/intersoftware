<?php
require_once('../../libs/WebService.php');
require_once('../../libs/Datany.php');
require_once('../../config/config.php');


$new = new WebService();

// $dataPost = array("id" => 69);

$dataPost = array(
   "start_date" => "2020-06-01 15:53:00.688705",
   "end_date" => "2020-06-01 15:55:00.688705"
);


$data = $new->sendPost($urlWebService, $dataPost);

$cont = 0;
foreach ($data->results->interval->analytics as $key => $value) {
   $llave = false;
   switch ($key) {
      case 'events':
         $interval['valor'][$cont] .= $value;
         break;

      default:
         $interval['valor'][$cont] .= $value->mean;
         break;
   }
   $interval['titulo'][$cont] .= $key;
   $cont++;
}

echo json_encode($interval);
