document.addEventListener('DOMContentLoaded', () => {
    fetch('/kioskoNet/backend/services/catalogoService.php')

        .then(response => {
            if (!response.ok) throw new Error("Algo falló");
            return response.json();
        })
        .then(data => {
            const main = document.getElementById('contenido');
            main.innerHTML = ''; // Limpia antes de pintar 

            for (const [categoria, productos] of Object.entries(data)) {
                if (!productos) continue; // Si no hay datos sigue

                // Crea la sección de cada categoría
                const section = document.createElement('section');
                section.innerHTML = `<h2>${categoria.toUpperCase()}</h2>`;
                
                // Tablas
                const tabla = document.createElement('table');
                tabla.innerHTML = `
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Acción</th> <!-- Pa' futuros botones -->
                    </tr>
                `;

           
                    // Dentro de tu .then(data => { ... }) en catalogo.js
                    for (const [id, nombre] of Object.entries(productos)) {
                        tabla.innerHTML += `
                            <tr>
                                <td>${id}</td>
                                <td>${nombre || 'Sin nombre'}</td>
                                <td>
                            
                                    <button 
                                        class="btn-ver" 
                                        onclick="location.href='mostrarDetalle-screen.html?id=${id}'"
                                    >
                                        👀 Ver
                                    </button>
                               
                                </td>
                            </tr>
                        `;
                    }

                section.appendChild(tabla);
                main.appendChild(section);
            }
        })
        .catch(error => {
            console.error("Error fetching data:", error);
            document.getElementById('contenido').innerHTML = `
                <p class="error">💥 Error: ${error.message}</p>
            `;
        });
});