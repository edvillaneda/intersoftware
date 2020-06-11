function getParameterByName(name) {
  name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
  var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
  return results === null
    ? ""
    : decodeURIComponent(results[1].replace(/\+/g, " "));
}

var valueAforo = getParameterByName("aforo");
var valueTemp = getParameterByName("temperatura");

//alert("Hay un aumento en el aforo de: "+prodId+ " personas");

var socket;

function init() {
  // Apuntar a la IP/Puerto configurado en el contructor del WebServerSocket, que es donde está escuchando el socket.
  var host = "ws://localhost:9000";
  try {
    socket = new WebSocket(host);
    socket.onmessage = function (msg) {
      var obj = JSON.parse(msg.data);
      var parms = "";

      switch (obj.titulo) {
        case "aforo":
          message = "Aforo Supera " + obj.valor + " personas";
          parms = "aforo=" + obj.valor + "&temperatura=0";
          break;
        case "temperatura":
          message =
            "Hemos detectado una temperatura mayor a " + obj.valor + "ºC";
          parms = "aforo=0&temperatura=" + obj.valor;
          break;
      }

      Push.create("Alerta de " + obj.titulo + "!!", {
        //Titulo de la notificación
        body: message, //Texto del cuerpo de la notificación
        icon: "assets/images/alert.png", //Icono de la notificación
        timeout: 10000, //Tiempo de duración de la notificación
        onClick: function () {
          //Función que se cumple al realizar clic cobre la notificación
          window.location =
            "http://localhost/intersoftware/alertas.html?" + parms; //Redirige a la siguiente web
          this.close(); //Cierra la notificación
        },
      });
    };
  } catch (ex) {
    // log(ex);
  }
  $("msg").focus();
  setTimeout(init, 1000);
}
