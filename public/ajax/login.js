document.addEventListener("DOMContentLoaded", () => {
  const btnLogin = document.getElementById("loginBtn");
  const errorMsg = document.getElementById("mensaje-error");

  btnLogin.addEventListener("click", async () => {
    const username = document.getElementById("username").value.trim();
    const password = document.getElementById("password").value.trim();

    if (!username || !password) {
      errorMsg.textContent = "Por favor completa ambos campos.";
      return;
    }

    const { data, status } = await iniciarSesion(username, password);

    if (status === 200 && data.success) {
      if (data.tipo === "Administrador") {
        window.location.href = "../pages/admin.html";
      } else {
        window.location.href = "../pages/cliente.html";
      }
    } else {
      errorMsg.textContent = data.message || "Error al iniciar sesión";
    }
  });
});
