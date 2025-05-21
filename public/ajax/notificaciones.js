$(document).ready(function () {
  const evtSource = new EventSource('http://localhost:5000/stream');
  const contenedorToast = document.getElementById("notificaciones") || document.body;
  const contenedorTabla = document.getElementById("tabla-container");

  // Crear tabla e insertar encabezado solo una vez
  const tabla = document.createElement('table');
  tabla.style.width = '100%';
  tabla.style.borderCollapse = 'collapse';
  tabla.border = '1';

  const thead = document.createElement('thead');
  const encabezado = document.createElement('tr');

  ['Asunto', 'Título', 'ISBN', 'Categoría', 'Hora'].forEach(texto => {
    const th = document.createElement('th');
    th.textContent = texto;
    encabezado.appendChild(th);
  });

  thead.appendChild(encabezado);
  tabla.appendChild(thead);

  const tbody = document.createElement('tbody');
  tabla.appendChild(tbody);

  contenedorTabla.appendChild(tabla);

  evtSource.onmessage = function (e) {
    const data = JSON.parse(e.data);
    console.log("Nuevo título recibido:", data);

    // Toast
    const toast = document.createElement('div');
    toast.className = 'toast';
    toast.textContent = `Nuevo título agregado: "${data.titulo}" (${data.categoria})`;
    contenedorToast.appendChild(toast);

    setTimeout(() => {
      toast.style.opacity = '0';
      setTimeout(() => contenedorToast.removeChild(toast), 500);
    }, 3000);

    // Tabla
    const fila = document.createElement('tr');

    function crearCelda(texto) {
      const td = document.createElement('td');
      td.textContent = texto || 'N/A';
      return td;
    }

    fila.appendChild(crearCelda('Nuevo título agregado'));
    fila.appendChild(crearCelda(data.titulo));
    fila.appendChild(crearCelda(data.isbn));
    fila.appendChild(crearCelda(data.categoria));
    fila.appendChild(crearCelda(data.hora));

    // Insertar al principio (los últimos eventos arriba)
    tbody.prepend(fila);
  };
});
