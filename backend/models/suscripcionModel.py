from dataclasses import dataclass

@dataclass
class Suscripcion:
    usuario: str
    plan: str
    estado: str
    fecha_activacion: str
    fecha_expiracion: str
