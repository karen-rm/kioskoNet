from firebase_admin import db
from utils.conexionFirebase import init_firebase
from datetime import datetime, timedelta
from models.pagoModel import Pago

def generar_clave_pago():
    ref = db.reference("Pagos")
    pagos = ref.get()

    if not pagos:
        return "PAG001"

    claves_existentes = list(pagos.keys())
    numeros = [int(k.replace("PAG", "")) for k in claves_existentes if k.startswith("PAG")]

    siguiente_numero = max(numeros) + 1 if numeros else 1
    return f"PAG{str(siguiente_numero).zfill(3)}"

def simular_pago(usuario, plan, monto):
    init_firebase()

    fecha_actual = datetime.now()
    fecha_activacion = fecha_actual.strftime("%Y-%m-%d")
    fecha_expiracion = (fecha_actual + timedelta(days=30)).strftime("%Y-%m-%d")

    # Verificar si es usuario empresa
    ref_usuario = db.reference(f"Registros/{usuario}")
    datos_usuario = ref_usuario.get()

    es_usuario_empresa = datos_usuario and datos_usuario.get("Tipo") == "Empresa"
    empresa_id = datos_usuario.get("EmpresaID") if es_usuario_empresa else None

    ref_suscripcion = db.reference(f"Suscripciones/{usuario}")
    suscripcion_actual = ref_suscripcion.get()

    # Caso: Usuario empresa
    if es_usuario_empresa:
        if not suscripcion_actual:
            ref_suscripcion.set({
                "Estado": "Activo",
                "Fecha activacion": fecha_activacion,
                "Fecha expiracion": fecha_expiracion,
                "Plan": plan,
                "Empresa": empresa_id
            })
            return {
                "success": True,
                "message": f"Suscripción creada para {usuario} a través de su empresa "
            }, 201
        else:
            return {
                "success": True,
                "message": f"{usuario} ya tiene una suscripción activa cubierta por su empresa. No se requiere pago."
            }, 200

    # Evitar pago duplicado en el mismo día
    ref_pagos = db.reference("Pagos")
    pagos_existentes = ref_pagos.get()

    if pagos_existentes:
        for pago in pagos_existentes.values():
            if pago["Usuario"] == usuario and pago["Fecha"] == fecha_activacion:
                return {
                    "success": False,
                    "message": f"Ya se ha registrado un pago para el usuario {usuario} el día de hoy."
                }, 409

    # Registrar nuevo pago
    clave_pago = generar_clave_pago()
    nuevo_pago = Pago(usuario, plan, monto, fecha_activacion, "Exitoso")
    ref_pagos.child(clave_pago).set(nuevo_pago.to_dict())

    # Crear o actualizar suscripción
    ref_suscripcion.set({
        "Estado": "Activo",
        "Fecha activacion": fecha_activacion,
        "Fecha expiracion": fecha_expiracion,
        "Plan": plan
    })

    return {
        "success": True,
        "message": f"Pago registrado y suscripción activada",
        "pago_id": clave_pago
    }, 201
