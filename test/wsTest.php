<?php

/*
  listar todos los posts o solo uno
 */
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $data = '';
  if (isset($_POST['start_date']) && isset($_POST['end_date'])) {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    $strJsonFileContents = file_get_contents("Datany_response.json");
    // Convert to array
    $data = json_decode($strJsonFileContents, true);

    // $data = 'L-91:M-02:X-80:J-04:V-05:S-104:D-07:L-08:M-09:M-10:J-11:V-12:S-13:D-34';
  } else {
    $data = '';
    header("HTTP/1.1 400 Bad Request");
  }


  header("HTTP/1.1 200 OK");
  // $arr = array('result' => $data);
  echo json_encode($data);
  exit();
}

//En caso de que ninguna de las opciones anteriores se haya ejecutado
header("HTTP/1.1 400 Bad Request");
