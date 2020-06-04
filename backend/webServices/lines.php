<?php
require_once('../../config/config.php');
require_once('../../libs/WebService.php');


$new = new WebService();

// $dataPost = array("id" => 69);

$dataPost = array(
   "start_date" => "2020-06-01 15:53:00.688705",
   "end_date" => "2020-06-01 15:55:00.688705"
);

$data = $new->sendPost(URL_WEB_SERVICE, $dataPost);

$cantidad = count($data->results->data);
// $dataCol = intdiv($cantidad, CHART_LINES_COLUMNS);
$dataCol = intdiv($cantidad, 8);

foreach ($data->results->data as $key => $value) {
   foreach ($value as $subKey => $subValue) {

      $interval[$subKey][$key] = $subValue;
   }
}
// echo "<pre>";


// echo var_dump($interval['persons']) . "<br><br><br>";

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

      // echo $r . '-' . $cont . "<br>";
      switch ($subKey) {
         case 'created_at':
            $promedio['created_at'][$cont] = $subValue[$i];
            break;

         case 'persons':
            $suma['persons'][$cont] += $subValue[$i];
            // echo ($suma['persons'][$cont] /14) . "<br>";
            $promedio['persons'][$cont] = $suma['persons'][$cont] / $dataCol;
         break;
      }

      if ($r == $dataCol - 1 && $contar == false) {
         // echo "---<br>";
         $cont++;
      }
      $contar = false;
   }
   // echo var_dump($suma) . "<br><br>";
}
// echo var_dump($promedio) . "<br>";
// echo "</pre>";

echo json_encode($promedio);
