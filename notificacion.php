<?php
require_once('config/config.php');

// Crear un nuevo post
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

  $aforo = $_GET['aforo'];

  // Create Sever
  $server = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
  socket_set_option($server, SOL_SOCKET, SO_REUSEADDR, 1);
  socket_bind($server, $socketUrl, $socketPort);
  socket_listen($server);

  // Create Client
  $client = socket_accept($server);
  $request = socket_read($client, 5000);
  preg_match('#Sec-WebSocket-Key: (.*)\r\n#', $request, $matches);
  $key = base64_encode(pack(
    'H*',
    sha1($matches[1] . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11')
  ));
  $headers = "HTTP/1.1 101 Switching Protocols\r\n";
  $headers .= "Upgrade: websocket\r\n";
  $headers .= "Connection: Upgrade\r\n";
  $headers .= "Sec-WebSocket-Version: 13\r\n";
  $headers .= "Sec-WebSocket-Accept: $key\r\n\r\n";
  socket_write($client, $headers, strlen($headers));

  $content = $aforo;
  $response = chr(129) . chr(strlen($content)) . $content;
  socket_write($client, $response);
  socket_close($client);
  header("HTTP/1.1 200 OK");
  $arr = array('Status' => 1);
  echo json_encode($arr);
  exit();
}


//En caso de que ninguna de las opciones anteriores se haya ejecutado
header("HTTP/1.1 400 Bad Request");
