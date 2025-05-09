from firebase_admin import db
from datetime import datetime
from utils.conexionFirebase import init_firebase
from models.accesosModel import Usuario

def iniciar_sesion(username, password):
    init_firebase()
    ref = db.reference('Accesos')
    accesos = ref.get()

    for tipo_usuario, usuarios in accesos.items():
        if username in usuarios and str(usuarios[username]) == str(password):
            return {"tipo": tipo_usuario, "usuario": username}

    return None

def registrar_cliente(data):
    init_firebase()

    username = data.get("username")
    password = data.get("password")
    correo = data.get("correo")
    nombre = data.get("nombre")
    telefono = data.get("telefono")

    if not all([username, password, correo, nombre, telefono]):
        return {"success": False, "message": "Faltan campos obligatorios"}, 400

    ref_accesos = db.reference("Accesos/Cliente")
    ref_usuarios = db.reference("Usuarios")

    if ref_accesos.child(username).get() is not None:
        return {"success": False, "message": "El usuario ya existe"}, 409

    # Crear instancia del modelo Usuario
    nuevo_usuario = Usuario(
        username=username,
        password=password,
        correo=correo,
        nombre=nombre,
        telefono=telefono
    )

    # Guardar en Accesos
    ref_accesos.child(nuevo_usuario.username).set(nuevo_usuario.password)

    # Guardar en Usuarios
    ref_usuarios.child(nuevo_usuario.username).set({
        "Correo": nuevo_usuario.correo,
        "Nombre": nuevo_usuario.nombre,
        "Telefono": nuevo_usuario.telefono,
        "Fecha registro": nuevo_usuario.fecha_registro
    })

    return {"success": True, "message": "Usuario registrado correctamente"}, 201

def validar_credenciales(username, password):
    init_firebase()
    ref = db.reference('Accesos')
    accesos = ref.get()

    for tipo_usuario, usuarios in accesos.items():
        if username in usuarios and usuarios[username] == password:
            return {"success": True, "message": "Credenciales válidas", "tipo": tipo_usuario}

    return {"success": False, "message": "Credenciales inválidas"}
