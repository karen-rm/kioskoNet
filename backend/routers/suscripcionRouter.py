from flask import Blueprint
from controllers.suscripcionController import obtener_suscripcion_controller
from controllers.suscripcionController import cancelar_controller

suscripcion_bp = Blueprint("suscripcion_bp", __name__)
suscripcion_bp.route("/suscripcion", methods=["POST"])(obtener_suscripcion_controller)
suscripcion_bp.route('/suscripcion/cancelar', methods=['POST'])(cancelar_controller)
