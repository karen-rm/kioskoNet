async function registrarCliente(datos) {
  const response = await fetch("http://localhost:5000/api/cliente", {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify(datos)
  });

  const data = await response.json();
  return { data, status: response.status };
}
