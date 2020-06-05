<?php
require_once('../../libs/WebService.php');
require_once('../../config/config.php');

$new = new WebService();

// $dataPost = array("id" => 69);

$dataPost = array(
   "start_date" => "2020-06-01 15:53:00.688705",
   "end_date" => "2020-06-01 15:55:00.688705"
);


$data = $new->sendPost(URL_WEB_SERVICE, $dataPost);

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
// print_r(json_encode($interval));


// echo "[" . $jsonString . "]";

$jsonString = '['."'".$resultado[0]."',"."'".$resultado[1]."',"."'".$resultado[2]."',"."'".$resultado[3]."',"."'".$resultado[4]."',"."'".$resultado[5]."',"."'".$resultado[6]."',"."'".$resultado[7]."',"."'".$resultado[8]."',"."'".$resultado[9]."',"."'".$resultado[10]."',"."'".$resultado[11]."',"."'".$resultado[12]."',"."'".$resultado[13]."',".']';


/*$jsonString=
'['.
"'L-51', 'M-02', 'X-03', 'J-04', 'V-05', 'S-06', 'D-07','L-08', 'M-09', 'M-10', 'J-11', 'V-12', 'S-13', 'D-14'"
.']';*/

echo $jsonString;
