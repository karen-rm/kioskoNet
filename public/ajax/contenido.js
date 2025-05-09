$(document).ready(function () {
  //Control de la navbar
  const links = document.querySelectorAll('nav a');
  const modal = document.getElementById('Modal');
  const openModalBtn = document.getElementById('openModalBtn');
  const closeModalBtn = document.getElementById('closeModalBtn');
  const btnSalir = document.getElementById('btnLogout');
  const categoriaSelect = document.getElementById('categoria');
  const autorField = document.getElementById('autor');
  const revistaField = document.getElementById('revista');

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
  btnSalir.addEventListener('click', () => {
    window.location.href = '../pages/login.html';
  });

  categoriaSelect.addEventListener('change', function () {
    const selectedValue = categoriaSelect.value;

    if (selectedValue === 'Revista') {
      // Si seleccionamos "Revista", ocultamos "Autor" y mostramos "Revista"
      autorField.closest('.form-row').style.display = 'none'; // Ocultamos el campo "Autor"
      revistaField.closest('.form-row').style.display = 'block'; // Mostramos el campo "Revista"
    } else {
      // Si seleccionamos cualquier otro valor, mostramos "Autor" y ocultamos "Revista"
      autorField.closest('.form-row').style.display = 'block'; // Mostramos el campo "Autor"
      revistaField.closest('.form-row').style.display = 'none'; // Ocultamos el campo "Revista"
    }
  });

  // Ejecutamos el cambio por defecto si hay un valor ya seleccionado
  categoriaSelect.dispatchEvent(new Event('change'));

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
        console.log(respuesta);
        const tabla = $('#tabla-catalogo tbody');
        tabla.empty(); // Limpiar tabla

        Object.entries(respuesta).forEach(([categoria, items]) => {
          const filaCategoria = `
          <tr style="background-color: #eee;">
            <td colspan="4"><strong>${categoria}</strong></td>
          </tr>`;
          tabla.append(filaCategoria);

          Object.entries(items).forEach(([isbn, titulo]) => {
            const fila = `
            <tr class="fila-catalogo" data-isbn="${isbn}" data-cat="${categoria}">
              <td>${isbn}</td>
              <td>${titulo}</td>
              <td>${categoria}</td>
              <td><button class="eliminar" data-isbn="${isbn}" data-cat="${categoria}">Eliminar</button></td>
            </tr>`;

            // Crear la fila de detalles
            const filaDetalles = `
            <tr class="detalles-fila" style="display: none;">
              <td colspan="4" style="background-color: #f9f9f9; padding: 10px;">
                <strong>Detalles:</strong><br>
                <p><b>ISBN:</b> ${isbn}</p>
                <p><b>Título:</b> ${titulo}</p>
                <p><b>Categoría:</b> ${categoria}</p>
                <div class="detalles-especificos">
                  ${
                    categoria === 'Revista'
                      ? `<p><b>Revista:</b> ${titulo}</p>`
                      : `<p><b>Autor:</b> ${titulo}</p>`
                  }
                </div>
                <button class="editar">Editar</button>
              </td>
            </tr>`;

            tabla.append(fila);
            tabla.append(filaDetalles);
          });
        });

        // Evento de clic para mostrar/ocultar detalles
        $('.fila-catalogo').on('click', function () {
          const isbn = $(this).data('isbn');
          const categoria = $(this).data('cat');
          const filaDetalles = $(this).next('.detalles-fila'); // Obtener la siguiente fila (detalles)

          // Toggle de visibilidad
          filaDetalles.toggle(); // Muestra u oculta los detalles
        });

        // Evento de clic para el botón "Editar"
        $('.editar').on('click', function (event) {
          event.stopPropagation(); // Evita que se dispare el evento de clic en la fila
          const filaDetalles = $(this).closest('.detalles-fila');
          const isbn = filaDetalles.prev('.fila-catalogo').data('isbn');
          const categoria = filaDetalles.prev('.fila-catalogo').data('cat');

          // Aquí podrías abrir un formulario o permitir la edición directa de los detalles
          alert(`Editar item: ISBN: ${isbn}, Categoría: ${categoria}`);
          // Crear el objeto JSON con el ISBN que se va a enviar
          const jsonIsbn = {
            isbn: isbn  // Solo se manda el ISBN
          };

          $.ajax({
            url: 'http://localhost:8080/ServiciosWeb/ProyectoFinal/kioskoNet/public/recuperar-detalles',
            type: 'POST',
            data: jsonIsbn,
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
