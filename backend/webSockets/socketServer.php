#!/usr/bin/env php
<?php
//Ejecutar desde la línea de comandos de PHP.
//Ejemplo: "C:\xampp\php\php.exe" -q SocketServer.php
//Este archivo debe estar fuera de las carpetas HTTP públicas pues correrá como un servicio/daemon.

require_once('../../libs/Sockets.php');
require_once('../../config/config.php');



class SocketServer extends Sockets
{
  protected function process($user, $message)
  {
    echo 'user sent: ' . $message . PHP_EOL;
    foreach ($this->users as $currentUser) {
      if ($currentUser !== $user)
        $this->send($currentUser, $message);
    }
  }

  protected function connected($user)
  {
    echo 'user connected' . PHP_EOL;
  }

  protected function closed($user)
  {
    echo 'user disconnected' . PHP_EOL;
  }
}

/*
El primer parámetro es la IP donde escuchará las conexiones:
  127.0.0.1 -> aceptar conexiones solo de localhost
  w.x.y.z (valid local IP) -> aceptar conexiones solo de LAN, si la dirección (interfaz) no pertenece a la máquina devolverá un error
  0.0.0.0 -> aceptar conexiones en cualquier interfaz
*/

// $chatServer = new SocketServer("localhost","9000");
$chatServer = new SocketServer($socketUrl, $socketPort);

try {
  $chatServer->run();
} catch (Exception $e) {
  $chatServer->stdout($e->getMessage());
}
