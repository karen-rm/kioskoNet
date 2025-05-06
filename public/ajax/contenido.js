$(document).ready(function () {
  cargarTabla();

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

  function cargarTabla() {
  $.ajax({
    url: 'http://localhost:8080/ServiciosWeb/ProyectoFinal/kioskoNet/public/obtener-catalogo',
    type: 'GET',
    success: function (respuesta) {
      const tabla = $('#tabla-catalogo tbody');
      tabla.empty(); // limpiar tabla

      Object.entries(respuesta).forEach(([categoria, items]) => {
        const filaCategoria = `
          <tr style="background-color: #eee;">
            <td colspan="4"><strong>${categoria}</strong></td>
          </tr>`;
        tabla.append(filaCategoria);

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
    error: function (xhr) {
      alert('Error al cargar el catálogo');
      console.error(xhr.responseText);
    }
  });
}


  // Botón eliminar
  $(document).on('click', '.eliminar', function () {
   
    const isbn = $(this).data('isbn');
    const categoria = $(this).data('cat');
    
    const datos = { isbn, categoria };
    const jsonDatos = JSON.stringify(datos);

    alert(jsonDatos); 
    //hacer confirmación 

      $.ajax({
        url: 'http://localhost:8080/ServiciosWeb/ProyectoFinal/kioskoNet/public/eliminar-titulo',
        type: 'DELETE',
        data: jsonDatos,
        contentType: 'application/json',
        success: function (respuesta) {
          console.log(respuesta); 
          alert('Eliminado correctamente');
          cargarTabla(); 
        },
        error: function (xhr) {
          alert('Error al eliminar');
          console.error(xhr.responseText);
        }
      });
  
  });
  
});
