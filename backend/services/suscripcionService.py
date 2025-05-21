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

def solicitar_suscripcion(username, plan_id, empresa_nombre=None):
    init_firebase()
    ref_plan = db.reference("Plan")
    ref_empresa = db.reference("Empresa")

    # Primero buscar si es plan empresarial o plan normal
    # Supongamos que si plan_id == "Empresarial" (o "empresa"), buscamos en Empresa
    if plan_id.lower() == "empresarial":
        # Buscar empresa por nombre (empresa_nombre debe venir del frontend)
        empresas = ref_empresa.get() or {}
        empresa_encontrada = None
        empresa_key = None

        for key, datos in empresas.items():
            if datos.get("Nombre", "").lower() == empresa_nombre.lower():
                empresa_encontrada = datos
                empresa_key = key
                break
        
        if not empresa_encontrada:
            return {"success": False, "message": "Empresa no encontrada"}, 404
        
        # Guardar suscripción empresarial con datos de la empresa encontrada
        ref_suscripciones = db.reference(f"Suscripciones/{username}")
        ref_suscripciones.set({
            "Estado": "Activo",
            "Fecha activacion": "2025-05-01",
            "Fecha expiracion": "2025-06-01",
            "Plan": plan_id,
            "Empresa": empresa_key,  # guarda el id de empresa
            "Numero accesos": empresa_encontrada.get("Numero accesos"),
            "Tipo suscripcion": empresa_encontrada.get("Tipo suscripcion"),
        })

        return {"success": True, "message": f"Suscripción empresarial creada para la empresa {empresa_nombre}"}, 201

    else:
        # Plan normal, buscar en Plan como antes
        planes = ref_plan.get() or {}
        plan_encontrado = None
        for categoria, subplanes in planes.items():
            if plan_id in subplanes:
                plan_encontrado = subplanes[plan_id]
                break

        if not plan_encontrado:
            return {"success": False, "message": "Plan no encontrado"}, 404

        ref_suscripciones = db.reference(f"Suscripciones/{username}")
        ref_suscripciones.set({
            "Estado": "Activo",
            "Fecha activacion": "2025-05-01",
            "Fecha expiracion": "2025-06-01",
            "Plan": plan_id
        })

        return {"success": True, "message": f"Suscripción creada con éxito"}, 201
