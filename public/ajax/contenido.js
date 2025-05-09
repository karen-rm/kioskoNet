$(document).ready(function () {

  //Control de la navbar
  const links = document.querySelectorAll('nav a');
  const modal = document.getElementById('Modal');
  const openModalBtn = document.getElementById('openModalBtn');
  const closeModalBtn = document.getElementById('closeModalBtn');
  const btnSalir = document.getElementById('btnLogout');

  links.forEach((link) => {
    link.addEventListener('click', function () {
      // Eliminar la clase 'active' de todos los enlaces
      links.forEach((link) => link.classList.remove('active'));

      // Añadir la clase 'active' al enlace clickeado
      this.classList.add('active');
    });
  });

  //Control del modal

  openModalBtn.onclick = function () {
    modal.style.display = 'block';
  };

  closeModalBtn.onclick = function () {
    modal.style.display = 'none';
  };

  // Cuando el usuario hace clic fuera del modal, también lo cierra
  window.onclick = function (event) {
    if (event.target == modal) {
      modal.style.display = 'none';
    }
  };

  //Botón cerrar sesión 
  btnSalir.addEventListener("click", () =>{
    window.location.href = "../pages/login.html";
  });

  

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
      },
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
      },
    });
  });

  //Inicialización de la tabla 
  cargarTabla();

});
