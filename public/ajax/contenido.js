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
  let modoEdicion = false;


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
    modoEdicion = false;
    modal.style.display = 'block';
    $('#agregarTituloForm input[type="submit"]').val('Agregar título');


    // Limpiar formulario y habilitar campos
  $('#agregarTituloForm')[0].reset();
  $('#isbn').prop('readonly', false);
  $('#categoria').prop('disabled', false);
  $('#img').prop('required', true);
  };

  closeModalBtn.onclick = function () {
  modal.style.display = 'none';

  // Resetear formulario y estado
  $('#agregarTituloForm')[0].reset();
  $('#isbn').prop('readonly', false);
  $('#categoria').prop('disabled', false);
  $('#img').prop('required', true);
  modoEdicion = false;

  // Restaurar el texto del botón
  $('#agregarTituloForm input[type="submit"]').val('Agregar título');
};


  // Cuando el usuario hace clic fuera del modal, también lo cierra
  window.onclick = function (event) {
  if (event.target == modal) {
    modal.style.display = 'none';

    // Resetear también si se cierra haciendo clic fuera
    $('#agregarTituloForm')[0].reset();
    $('#isbn').prop('readonly', false);
    $('#categoria').prop('disabled', false);
    $('#img').prop('required', true);
    modoEdicion = false;

    // Restaurar el texto del botón
    $('#agregarTituloForm input[type="submit"]').val('Agregar título');
  }
};


  //Botón cerrar sesión
  btnSalir.addEventListener('click', () => {
    window.location.href = '../pages/login.html';
  });

  categoriaSelect.addEventListener('change', function () {
    const selectedValue = categoriaSelect.value;

    if (selectedValue === 'Revista') {
      autorField.closest('.form-row').style.display = 'none'; // Ocultamos el campo "Autor"
      revistaField.closest('.form-row').style.display = 'block'; // Mostramos el campo "Revista"
    } else {
      autorField.closest('.form-row').style.display = 'block'; // Mostramos el campo "Autor"
      revistaField.closest('.form-row').style.display = 'none'; // Ocultamos el campo "Revista"
    }
  });

  // Ejecutamos el cambio por defecto si hay un valor ya seleccionado
  categoriaSelect.dispatchEvent(new Event('change'));

  $('#agregarTituloForm').submit(function (e) {
  e.preventDefault();

  const formData = new FormData(this);

  $.ajax({
    url: 'http://localhost:8080/ServiciosWeb/ProyectoFinal/kioskoNet/public/imagen',
    type: 'POST',
    data: formData,
    processData: false,
    contentType: false,
    success: function (respuesta) {
      console.log('Imagen procesada');

      const datosTitulo = {
        isbn: $('#isbn').val(),
        titulo: $('#titulo').val(),
        categoria: $('#categoria').val(),
        autor: $('#autor').val(),
        revista: $('#revista').val(),
        editorial: $('#editorial').val(),
        anio: $('#anio').val(),
        genero: $('#genero').val(),
        precio: $('#precio').val(),
        img: respuesta.imagenUrl
      };

      const metodo = modoEdicion ? 'PUT' : 'POST';

      $.ajax({
        url: 'http://localhost:8080/ServiciosWeb/ProyectoFinal/kioskoNet/public/titulo',
        type: metodo,
        contentType: 'application/json',
        data: JSON.stringify(datosTitulo),
        success: function (respuesta) {
          alert(modoEdicion ? 'Título editado correctamente' : 'Título agregado correctamente');
          modal.style.display = 'none';
          cargarTabla();
        },
        error: function (xhr) {
          alert('Error al guardar el título');
          console.error(xhr.responseText);
        }
      });
    },
    error: function (xhr) {
      alert('Error al subir imagen');
      console.error(xhr.responseText);
    }
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
                <p id="detalles-${isbn}"><b>Cargando detalles...</b></p>
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
          console.log('presiono el producto con isbn: ' + isbn);
          const categoria = $(this).data('cat');
          const filaDetalles = $(this).next('.detalles-fila'); // Obtener la siguiente fila (detalles)

          filaDetalles.toggle();

          // Si los detalles aún no han sido cargados, obtén los detalles
          const detallesDiv = filaDetalles.find(`#detalles-${isbn}`);
          console.log(isbn);
          if (detallesDiv.text() === 'Cargando detalles...') {
            $.ajax({
              url: 'http://localhost:8080/ServiciosWeb/ProyectoFinal/kioskoNet/public/detalles?isbn=${isbn}',
              type: 'GET',
              success: function (respuesta) {
                console.log(respuesta);
                if (respuesta.success && respuesta.detalles) {
                  // Actualizar los detalles con la respuesta
                  detallesDiv.html(`
                  <p><b>Autor:</b> ${respuesta.detalles.Autor || 'N/A'}</p>
                  <p><b>Género:</b> ${respuesta.detalles.Genero || 'N/A'}</p>
                  <p><b>Precio:</b> ${respuesta.detalles.Precio || 'N/A'}</p>
                `);
                } else {
                  detallesDiv.html('<p><b>Detalles no disponibles.</b></p>');
                }
              },
              error: function (xhr) {
                detallesDiv.html('<p><b>Error al cargar los detalles.</b></p>');
                console.error(
                  'Error al obtener los detalles',
                  xhr.responseText
                );
              },
            });
          }
        });

        //  botón "Editar"
        $('.editar').on('click', function (event) {
          modoEdicion = true;

          event.stopPropagation(); // Evita que se dispare el evento de clic en la fila
          const filaDetalles = $(this).closest('.detalles-fila');
          const isbn = filaDetalles.prev('.fila-catalogo').data('isbn');
          const categoria = filaDetalles.prev('.fila-catalogo').data('cat');

          alert(`Editar item: ISBN: ${isbn}, Categoría: ${categoria}`);
          $.ajax({
           url: `http://localhost:8080/ServiciosWeb/ProyectoFinal/kioskoNet/public/detalles?isbn=${isbn}`,
            type: 'GET',
            contentType: 'application/json', // Asegúrate de enviar los datos como JSON
            data: JSON.stringify({ isbn: isbn }),
            success: function (respuesta) {
              console.log(respuesta);

              if (respuesta.detalles) {
                const detalles = respuesta.detalles;

                // Mostrar el modal
                modal.style.display = 'block';

                $('#agregarTituloForm input[type="submit"]').val('Guardar cambios');


                // Llenar campos del formulario
                $('#isbn').val(isbn).prop('readonly', true); // desactivar edición de ISBN
                $('#categoria').val(categoria).prop('disabled', true); // evitar cambiar categoría
                $('#titulo').val(detalles.Titulo || '');
                $('#editorial').val(detalles.Editorial || '');
                 $('#anio').val(detalles['Año publicacion'] || '');
                $('#genero').val(detalles.Genero || '');
                $('#precio').val(detalles.Precio || '');
                $('#img').prop('required', false); // no obligar imagen al editar

                // Mostrar u ocultar autor/revista según categoría
                $('#categoria').trigger('change');
                if (categoria === 'Revista') {
                  $('#revista').val(detalles.Revista || '');
                  $('#autor').val('');
                } else {
                  $('#autor').val(detalles.Autor || '');
                  $('#revista').val('');
                }
              } else {
                alert('No se encontraron los detalles del título.');
              }
            },
            error: function (xhr, status, error) {
              alert('Error al agregar título');
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
      url: 'http://localhost:8080/ServiciosWeb/ProyectoFinal/kioskoNet/public/titulo',
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
