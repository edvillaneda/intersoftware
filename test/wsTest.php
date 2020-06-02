<?php
/*
  listar todos los posts o solo uno
 */
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $data = '';
  if (isset($_POST['id'])) {
    $id = $_POST['id'];

    switch ($id) {
      case 1:
        $data = 'L-91:M-02:X-80:J-04:V-05:S-104:D-07:L-08:M-09:M-10:J-11:V-12:S-13:D-34';
        break;

      case 2:
        $data = 'd-1:d-2:d-3:d-4:d-5:d-6:d-7:d-8:d-9:d-10';
        break;

      default:
        $data = '';
        header("HTTP/1.1 400 Bad Request");
        break;
    }
  }


  header("HTTP/1.1 200 OK");
  $arr = array('result' => $data);
  echo json_encode($arr);
  exit();
}


//En caso de que ninguna de las opciones anteriores se haya ejecutado
header("HTTP/1.1 400 Bad Request");
