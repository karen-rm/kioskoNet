import firebase_admin
from firebase_admin import credentials, db

def init_firebase():
    # Solo inicializar si no está ya inicializado
    if not firebase_admin._apps:
        cred = credentials.Certificate("utils/claveFirebase.json")  
        firebase_admin.initialize_app(cred, {
            'databaseURL': 'https://kioskonet-fc6a6-default-rtdb.firebaseio.com/'  
        })

