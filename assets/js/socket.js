function getParameterByName(name) {
  name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
  var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
  return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}
//alert("Hay un aumento en el aforo de: "+prodId+ " personas");

var socket;

function init() {
  // Apuntar a la IP/Puerto configurado en el contructor del WebServerSocket, que es donde está escuchando el socket.
  var host = "ws://localhost:9000";
  try {
    socket = new WebSocket(host);
    socket.onmessage = function (msg) {
      Push.create("Aforo Supera " + msg.data + " personas", {
        //Titulo de la notificación
        body: "Presenta un Aforo de " + msg.data + " personas", //Texto del cuerpo de la notificación
        icon: "img/alert.png", //Icono de la notificación
        timeout: 10000, //Tiempo de duración de la notificación
        onClick: function () {
          //Función que se cumple al realizar clic cobre la notificación
          window.location = "http://localhost/intersoftware/alertas.html?aforo=" + msg.data; //Redirige a la siguiente web
          this.close(); //Cierra la notificación
        },
      });
    };
  } catch (ex) {
    log(ex);
  }
  $("msg").focus();
  setTimeout(init, 1000);
}
