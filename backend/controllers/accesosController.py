from flask import request, jsonify
from services.accesosService import iniciar_sesion
from services.accesosService import registrar_cliente
from services.accesosService import validar_credenciales

def login_controller():
    data = request.get_json()
    username = data.get("username")
    password = data.get("password")

    resultado = iniciar_sesion(username, password)

    if resultado:
        return jsonify({"success": True, "tipo": resultado["tipo"], "usuario": resultado["usuario"]})
    else:
        return jsonify({"success": False, "message": "Credenciales inválidas"}), 401

def registro_controller():
    data = request.get_json()
    resultado, status = registrar_cliente(data)
    return jsonify(resultado), status

def validar_controller():
    data = request.get_json()
    username = data.get("username")
    password = data.get("password")

    resultado = validar_credenciales(username, password)
    status = 200 if resultado["success"] else 401
    return jsonify(resultado), status

