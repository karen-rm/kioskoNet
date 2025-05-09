from dataclasses import dataclass
from datetime import datetime

@dataclass
class Usuario:
    username: str
    password: str
    correo: str
    nombre: str
    telefono: str
    fecha_registro: str = datetime.now().strftime("%Y-%m-%d")
