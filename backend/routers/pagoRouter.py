from flask import Blueprint
from controllers.pagoController import simular_pago_controller

pago_bp = Blueprint("pago_bp", __name__)
pago_bp.route("/pago", methods=["POST"])(simular_pago_controller)
