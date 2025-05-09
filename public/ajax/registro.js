document.addEventListener("DOMContentLoaded", () => {
  const btnRegistrar = document.getElementById("registrarBtn");
  const mensaje = document.getElementById("mensaje-registro");

  btnRegistrar.addEventListener("click", async () => {
    const datos = {
      username: document.getElementById("username").value.trim(),
      password: parseInt(document.getElementById("password").value.trim()),
      correo: document.getElementById("correo").value.trim(),
      nombre: document.getElementById("nombre").value.trim(),
      telefono: document.getElementById("telefono").value.trim()
    };

    if (Object.values(datos).some(val => !val)) {
      mensaje.textContent = "Completa todos los campos.";
      return;
    }

    const { data, status } = await registrarCliente(datos);

    if (status === 201) {
      mensaje.style.color = "green";
      mensaje.textContent = data.message;
      setTimeout(() => {
      window.location.href = "login.html";
      }, 2000);
    } else {
      mensaje.style.color = "red";
      mensaje.textContent = data.message;
    }
  });
});
