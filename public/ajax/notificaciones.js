$(document).ready(function () {
 
const evtSource = new EventSource('http://localhost:5000/stream');

evtSource.onmessage = function(e) {
  const data = JSON.parse(e.data);
  console.log("Nuevo título recibido:", data);

  // Puedes hacer algo más visual:
  const contenedor = document.getElementById("notificaciones") || document.body;
  const alerta = document.createElement('div');
  alerta.textContent = `Nuevo título: ${data.titulo} (${data.categoria})`;
  alerta.style = "background:#dff0d8;padding:10px;margin:10px;border-left:5px solid green;";
  contenedor.prepend(alerta);
};


})