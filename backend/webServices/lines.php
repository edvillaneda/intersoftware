<?php
require_once('../../config/config.php');
require_once('../../libs/WebService.php');


$new = new WebService();

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
$cantidad = count($data->results->data);
$dataCol = intdiv($cantidad, 8);

foreach ($data->results->data as $key => $value) {
   foreach ($value as $subKey => $subValue) {

      $interval[$subKey][$key] = $subValue;
   }
}

foreach ($interval as $subKey => $subValue) {
   if ($subKey != 'created_at' && $subKey != 'persons') {
      continue;
   }
   $valores = count($subValue);
   $dataCol = intdiv($valores, $valores / CHART_LINES_COLUMNS);

   $cont = 0;
   $suma = array();
   $contar = true;
   for ($i = 0; $i < $valores; $i++) {
      $r = ($i) % $dataCol;

      switch ($subKey) {
         case 'created_at':
            $promedio['created_at'][$cont] = $subValue[$i];
            break;

         case 'persons':
            $suma['persons'][$cont] += $subValue[$i];
            $promedio['persons'][$cont] = $suma['persons'][$cont] / $dataCol;
            break;
      }

      if ($r == $dataCol - 1 && $contar == false) {
         $cont++;
      }
      $contar = false;
   }
}

echo json_encode($promedio);
