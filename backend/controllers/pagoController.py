from flask import request, jsonify
from services.pagoService import simular_pago

def simular_pago_controller():
    data = request.get_json()
    usuario = data.get("username")
    plan = data.get("plan")
    monto = data.get("monto")

    if not usuario or not plan or not monto:
        return jsonify({
            "success": False,
            "message": "Faltan datos obligatorios (username, plan, monto)."
        }), 400

    resultado, status = simular_pago(usuario, plan, monto)
    return jsonify(resultado), status
