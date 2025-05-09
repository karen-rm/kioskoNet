from firebase_admin import db
from utils.conexionFirebase import init_firebase
from models.suscripcionModel import Suscripcion

def obtener_suscripcion(username):
    init_firebase()
    ref = db.reference(f"Suscripciones/{username}")
    data = ref.get()

    if not data:
        return None

    return Suscripcion(
        usuario=username,
        plan=data.get("Plan", ""),
        estado=data.get("Estado", ""),
        fecha_activacion=data.get("Fecha activacion", ""),
        fecha_expiracion=data.get("Fecha expiracion", "")
    )

def cancelar_suscripcion(username):
    init_firebase()
    ref = db.reference(f"Suscripciones/{username}")
    data = ref.get()

    if not data:
        return {"success": False, "message": "No existe una suscripción para este usuario"}, 404

    ref.update({
        "Estado": "Cancelado"
    })

    return {"success": True, "message": "Suscripción cancelada correctamente"}, 200
