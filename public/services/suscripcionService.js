export async function obtenerSuscripcion(username) {
  try {
    const response = await fetch(`http://localhost:5000/api/suscripcion/${encodeURIComponent(username)}`, {
      method: 'GET',
      headers: { 'Content-Type': 'application/json' }
    });

    if (!response.ok) {
      const err = await response.json();
      throw new Error(err.message || 'Error al obtener suscripción');
    }

    const data = await response.json();
    return data.suscripcion;
  } catch (error) {
    throw error;
  }
}
