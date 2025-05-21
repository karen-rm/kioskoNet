// Función que llama al endpoint /pago con POST y datos JSON
async function simularPago({ username, plan, monto }) {
    try {
        const response = await fetch("http://localhost:5000/api/pago", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ username, plan, monto })
        });

        const data = await response.json();

        return { data, status: response.status };
    } catch (error) {
        return { error: "Error en la conexión con el servidor." };
    }
}

