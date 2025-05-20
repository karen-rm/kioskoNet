import { solicitarSuscripcion } from "../service/suscripcionService.js";

document.addEventListener("DOMContentLoaded", () => {
  const btnSolicitar = document.getElementById("btnSolicitar");
  const formPago = document.getElementById("formEmpresa");

  btnSolicitar.addEventListener("click", async (e) => {
    e.preventDefault();

    // Leer valores del formulario
    const username = formEmpresa.username.value.trim();
    const plan = formEmpresa.plan.value.trim();

    if (!username || !plan) {
      alert("Usuario y plan son obligatorios.");
      return;
    }

    try {
      const data = await solicitarSuscripcion(username, plan);
      alert(data.message || "Suscripción solicitada correctamente");
      formEmpresa.reset();
    } catch (error) {
      alert("Error: " + error.message);
    }
  });
});

