from flask import Flask
from flask_cors import CORS
from routers.accesosRouter import accesos_bp
from routers.suscripcionRouter import suscripcion_bp
from routers.webhookRouter import webhookRouter
from routers.pagoRouter import pago_bp

app = Flask(__name__)
app.register_blueprint(accesos_bp, url_prefix="/api")
app.register_blueprint(suscripcion_bp, url_prefix='/api')
app.register_blueprint(webhookRouter)
app.register_blueprint(pago_bp, url_prefix='/api')

CORS(app) 

if __name__ == '__main__':
    app.run(debug=True)
 
