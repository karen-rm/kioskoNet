from flask import request, jsonify
from services.suscripcionService import obtener_suscripcion
from services.suscripcionService import cancelar_suscripcion
from services.suscripcionService import solicitar_suscripcion

def obtener_suscripcion_controller(username):
    suscripcion = obtener_suscripcion(username)

    if suscripcion:
        return jsonify({
            "success": True,
            "suscripcion": suscripcion.__dict__
        }), 200
    else:
        return jsonify({
            "success": False,
            "message": "No se encontró suscripción para este usuario"
        }), 404

def cancelar_controller(username):
    resultado, status = cancelar_suscripcion(username)
    return jsonify(resultado), status

def solicitar_suscripcion_controller():
    data = request.get_json()
    username = data.get("username")
    plan = data.get("plan")
    empresa = data.get("empresa")  # Nuevo campo opcional

    if not username or not plan:
        return jsonify({
            "success": False,
            "message": "Faltan datos obligatorios: username o plan."
        }), 400

    # Se pasa el nombre de empresa solo si existe
    resultado, status = solicitar_suscripcion(username, plan, empresa)
    return jsonify(resultado), status


