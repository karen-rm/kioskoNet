class Pago:
    def __init__(self, usuario, plan, monto, fecha, estado):
        self.usuario = usuario
        self.plan = plan
        self.monto = monto
        self.fecha = fecha
        self.estado = estado

    def to_dict(self):
        return {
            "Usuario": self.usuario,
            "Plan": self.plan,
            "Monto": self.monto,
            "Fecha": self.fecha,
            "Estado": self.estado
        }
