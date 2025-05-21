$(document).ready(function () {
  $.ajax({
    url: 'http://localhost:8080/ServiciosWeb/ProyectoFinal/kioskoNet/public/catalogo',
    method: 'GET',
    dataType: 'json',
    success: function (data) {
      const main = $('#contenido');
      main.empty();

      $.each(data, function (categoria, productos) {
        if (!productos) return true;

        // Crea la sección de cada categoría
        const section = $('<section>');
        section.append(`<h2>${categoria.toUpperCase()}</h2>`);

        // Tablas
        const tabla = $('<table>');
        tabla.append(`
          <tr>
            <th>ISBN</th>
            <th>Nombre</th>
            <th>Acción</th> 
          </tr>
        `);

        $.each(productos, function (isbn, nombre) {
          tabla.append(`
            <tr>
              <td>${isbn}</td>
              <td>${nombre || 'Sin nombre'}</td>
                <td>
                  <button class="btn-ver" onclick="location.href='detalle.html?isbn=${isbn}'">
                    👀 Ver
                  </button>
                </td>
              </tr>
          `);
        });

        section.append(tabla);
        main.append(section);
      });
    },
    error: function (xhr, status, error) {
      console.error('Error fetching data:', error);
      $('#contenido').html(`<p class="error"> Error: ${error}</p>`);
    },
  });

  // Función para cerrar sesión
  $('#btnCerrarSesion').click(function () {
    window.location.href = 'login.html'; 
  });

  // Función para obtener suscripción 
  $('#btnObtenerSuscripcion').click(function () {
    window.location.href = 'suscripcion.html'; 
  });

  // Función para visualizar suscripción
  $('#btnVisualizarSuscripcion').click(function () {
    window.location.href = 'buscarSuscripcion.html'; 
  });
});
