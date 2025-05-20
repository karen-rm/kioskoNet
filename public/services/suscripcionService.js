export async function solicitarSuscripcion(username, plan) {
  if (!username) throw new Error("El usuario es obligatorio");

  const response = await fetch("http://localhost:5000/api/suscripcion", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ username, plan })
  });

  if (!response.ok) {
    const errData = await response.json();
    throw new Error(errData.message || "Error solicitando suscripción");
  }

  return response.json();
}
