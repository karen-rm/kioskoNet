from flask import Blueprint
from controllers.suscripcionController import obtener_suscripcion_controller
from controllers.suscripcionController import cancelar_controller
from controllers.suscripcionController import solicitar_suscripcion_controller

suscripcion_bp = Blueprint("suscripcion_bp", __name__)
suscripcion_bp.route('/suscripcion', methods=['POST'])(solicitar_suscripcion_controller)
suscripcion_bp.route("/suscripcion/<username>", methods=["GET"])(obtener_suscripcion_controller)
suscripcion_bp.route("/suscripcion/cancelar/<username>", methods=["PUT"])(cancelar_controller)