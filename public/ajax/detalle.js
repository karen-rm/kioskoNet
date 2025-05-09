document.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const Catalogo = urlParams.get('Catalogo');
    const id = urlParams.get('id');

    fetch(`/kioskoNet/backend/services/detalleService.php?Catalogo=${Catalogo}&id=${id}`)
        .then(response => response.json())
        .then(detalle => {
            const contenedor = document.getElementById('detalle-contenido');
            
            if (!detalle || detalle.error) {
                contenedor.innerHTML = `<p class="error">Producto no encontrado</p>`;
                return;
            }

            contenedor.innerHTML = `
                <div class="detalle-card">
                    <h2>${detalle['Titulo'] || 'Sin título'}</h2>
                    <p><strong>Autor:</strong> ${detalle.Autor || 'No especificado'}</p>
                    <p><strong>Editorial:</strong> ${detalle.Editorial || '-'}</p>
                    <p><strong>Género:</strong> ${detalle.Genero || '-'}</p>
                    <p><strong>Año:</strong> ${detalle['Año publicacion'] || 'Desconocido'}</p>
                    <p><strong>Precio:</strong> $${detalle.Precio || '0.00'} MXN</p>
                </div>
            `;
        })
        .catch(error => {
            console.error("Error:", error);
            document.getElementById('detalle-contenido').innerHTML = `
                <p class="error">💥 Error al cargar detalles</p>
            `;
        });
});