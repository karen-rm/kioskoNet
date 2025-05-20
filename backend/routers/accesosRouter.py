from flask import Blueprint
from controllers.accesosController import login_controller
from controllers.accesosController import registro_controller
from controllers.accesosController import validar_controller

accesos_bp = Blueprint("accesos_bp", __name__)
accesos_bp.route("/login", methods=["POST"])(login_controller)  
accesos_bp.route("/cliente", methods=["POST"])(registro_controller)  
accesos_bp.route('/validar', methods=['POST'])(validar_controller)

