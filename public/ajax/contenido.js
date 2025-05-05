$(document).ready(function () {
  $('#agregarTituloForm').submit(function (e) {
    e.preventDefault(); // Previene que se recargue la página

    const datosFormulario = $(this).serialize(); // Recupera los datos del form

    $.ajax({
      url: 'http://localhost:8080/ServiciosWeb/ProyectoFinal/kioskoNet/public/agregar-titulo',
      type: 'POST',
      data: datosFormulario,
      success: function (respuesta) {
        alert('Título agregado correctamente');
        console.log(respuesta);
      },
      error: function (xhr, status, error) {
        alert('Error al agregar título');
        console.error(xhr.responseText);
      },
    });
  });

  $.ajax({
    url: 'http://localhost:8080/ServiciosWeb/ProyectoFinal/kioskoNet/public/obtener-catalogo',
    type: 'GET',
    success: function (respuesta) {

      console.log(respuesta); 

       const tabla = $('#tabla-catalogo tbody');
      tabla.empty();

      // Agrupar por categoría (Libro, Revista, etc.)
      Object.entries(respuesta).forEach(([categoria, items]) => {
        // Insertar encabezado por categoría
        const filaCategoria = `
          <tr style="background-color: #eee;">
            <td colspan="4"><strong>${categoria}</strong></td>
          </tr>`;
        tabla.append(filaCategoria);

        // Agregar cada título de la categoría
        Object.entries(items).forEach(([isbn, titulo]) => {
          const fila = `
            <tr>
              <td>${isbn}</td>
              <td>${titulo}</td>
              <td>${categoria}</td>
              <td><button class="eliminar" data-isbn="${isbn}" data-cat="${categoria}">Eliminar</button></td>
            </tr>`;
          tabla.append(fila);
        });
      });

    },
    error: function (xhr, status, error) {
      alert('Error al obtener el catálogo');
      console.error(xhr.responseText);
    },
  });
  
});
