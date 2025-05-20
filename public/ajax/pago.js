document.getElementById("formPago").addEventListener("submit", async function (e) {
    e.preventDefault();

    const username = document.getElementById("username").value.trim();
    const plan = document.getElementById("plan").value;
    const monto = parseFloat(document.getElementById("monto").value);

    const resultadoDiv = document.getElementById("resultado");
    resultadoDiv.textContent = "";
    resultadoDiv.className = "resultado";

    if (!username || !plan || !monto || monto <= 0) {
        resultadoDiv.textContent = "Por favor llena todos los campos correctamente.";
        resultadoDiv.classList.add("error");
        return;
    }

    // Llamar al servicio
    const { data, status, error } = await simularPago({ username, plan, monto });

    if (error) {
        resultadoDiv.textContent = error;
        resultadoDiv.classList.add("error");
        return;
    }

    if (status >= 200 && status < 300) {
        resultadoDiv.textContent = data.message || "Pago exitoso.";
        resultadoDiv.classList.add("success");
    } else {
        resultadoDiv.textContent = data.message || "Error al procesar el pago.";
        resultadoDiv.classList.add("error");
    }
});

window.addEventListener("DOMContentLoaded", () => {
  const params = new URLSearchParams(window.location.search);
  const plan = params.get("plan");
  const monto = params.get("monto");

  if(plan) document.getElementById("plan").value = plan;
  if(monto) document.getElementById("monto").value = monto;
});


