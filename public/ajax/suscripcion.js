import { obtenerSuscripcion } from '../services/suscripcionService.js';

const formBuscar = document.getElementById('formBuscar');
const resultadoDiv = document.getElementById('resultado');
const mensajeDiv = document.getElementById('mensaje');
const btnCancelar = document.getElementById('btnCancelar');
const accionesDiv = document.getElementById('acciones');

let usuarioActual = null;

const nombresPlanes = {
  "BAS001": "Básico",
  "FAM001": "Familiar",
  "PRE001": "Premium"
};

formBuscar.addEventListener('submit', async (e) => {
  e.preventDefault();
  resultadoDiv.classList.add('oculto');
  accionesDiv.classList.add('oculto');
  mensajeDiv.textContent = '';
  mensajeDiv.style.color = 'red';

  usuarioActual = document.getElementById('username').value.trim();

  if (!usuarioActual) {
    mensajeDiv.textContent = 'Por favor ingresa un nombre de usuario';
    return;
  }

  try {
    const suscripcion = await obtenerSuscripcion(usuarioActual);

    if (!suscripcion) {
      mensajeDiv.textContent = 'No se encontró suscripción para este usuario.';
      return;
    }

    mostrarSuscripcion(suscripcion);
    accionesDiv.classList.remove('oculto');
    mensajeDiv.textContent = '';
  } catch (error) {
    mensajeDiv.textContent = error.message || 'Error al obtener suscripción.';
  }
});

btnCancelar.addEventListener('click', async () => {
  if (!usuarioActual) return;

  if (!confirm('¿Seguro que deseas cancelar tu suscripción?')) return;

  try {
    const response = await fetch(`http://localhost:5000/api/suscripcion/cancelar/${encodeURIComponent(usuarioActual)}`, {
      method: 'PUT',
      headers: { 'Content-Type': 'application/json' }
    });

    const data = await response.json();

    if (response.ok) {
      mensajeDiv.style.color = 'green';
      mensajeDiv.textContent = data.message || 'Suscripción cancelada correctamente.';
      resultadoDiv.classList.add('oculto');
      accionesDiv.classList.add('oculto');
    } else {
      mensajeDiv.style.color = 'red';
      mensajeDiv.textContent = data.message || 'Error al cancelar suscripción.';
    }
  } catch (error) {
    mensajeDiv.style.color = 'red';
    mensajeDiv.textContent = 'Error en la conexión con el servidor.';
  }
});

function mostrarSuscripcion(suscripcion) {
  resultadoDiv.innerHTML = '';
  resultadoDiv.classList.remove('oculto');

  const plan = suscripcion.plan || 'Desconocido';
  const nombrePlan = nombresPlanes[plan] || plan;
  const estado = suscripcion.estado || 'Desconocido';
  const fechaActivacion = suscripcion.fecha_activacion || '-';
  const fechaExpiracion = suscripcion.fecha_expiracion || '-';

  const html = `
    <p><strong>Plan:</strong> ${nombrePlan}</p>
    <p><strong>Estado:</strong> ${estado}</p>
    <p><strong>Fecha Activación:</strong> ${fechaActivacion}</p>
    <p><strong>Fecha Expiración:</strong> ${fechaExpiracion}</p>
  `;

  resultadoDiv.innerHTML = html;
}
