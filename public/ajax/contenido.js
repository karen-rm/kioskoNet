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

  
});
