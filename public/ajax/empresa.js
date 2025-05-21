document.getElementById('empresaForm').addEventListener('submit', function(e) {
  e.preventDefault();

  const username = document.getElementById('username').value.trim();
  const empresa = document.getElementById('empresa').value.trim();

  if (!username || !empresa) {
    mostrarMensaje("Por favor llena todos los campos", true);
    return;
  }

  const datos = {
    username: username,
    plan: "Empresarial",
    empresa: empresa
  };

  fetch('http://localhost:5000/api/suscripcion', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(datos)
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      mostrarMensaje("Suscripción empresarial solicitada con éxito.", false);
      this.reset();
    } else {
      mostrarMensaje(data.message || "Error al solicitar la suscripción.", true);
    }
  })
  .catch(() => {
    mostrarMensaje("Error en la conexión con el servidor.", true);
  });
});

function mostrarMensaje(msg, esError) {
  const mensajeDiv = document.getElementById('mensaje');
  mensajeDiv.textContent = msg;
  mensajeDiv.style.color = esError ? 'red' : 'green';
}

document.getElementById('btnCancelar').addEventListener('click', function() {
  window.location.href = '../pages/suscripcion.html';
});
