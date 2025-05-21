$(document).ready(function() {
    const urlParams = new URLSearchParams(window.location.search);
    const isbn = urlParams.get('isbn');

    if (isbn) {
        $.ajax({
            url: `http://localhost:8080/ServiciosWeb/ProyectoFinal/kioskoNet/public/detalles?isbn=${isbn}`,
            method: 'GET',
            dataType: 'json',
            success: function(respuesta) {
                const detallesDiv = $('#detalles-imagen');
                const textoDiv = $('#detalles-texto');

                detallesDiv.empty();
                textoDiv.empty();

                const detalles = respuesta.detalles || respuesta; // Ajusta según estructura JSON recibida

                Object.entries(detalles).forEach(([clave, valor]) => {
                    if (clave.toLowerCase() === 'imagen' && valor) {
                        detallesDiv.append(
                            `<img src="../${valor}" alt="Imagen del libro" style="width:170px; height:190px; margin-left: 2px; margin-top: 10px; border-radius: 5px;">`
                        );
                    } else {
                        textoDiv.append(`<p><b>${clave}:</b> ${valor || '-'}</p>`);
                    }
                });
            },
            error: function() {
                $('#detalle-contenido').html('<p class="error">Error al cargar detalles.</p>');
            }
        });
    } else {
        alert("No se encontró el isbn en la URL");
    }
});
