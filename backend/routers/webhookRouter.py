from flask import Blueprint, request, jsonify, Response 
from datetime import datetime 

webhookRouter = Blueprint('webhookRouter', __name__)

eventos = []

import os
import json

EVENTOS_FILE = './utils/eventos.json'
MAX_EVENTOS = 10

# Cargar eventos desde el archivo
def cargar_eventos():
    if os.path.exists(EVENTOS_FILE):
        with open(EVENTOS_FILE, 'r') as f:
            try:
                return json.load(f)
            except json.JSONDecodeError:
                return []
    return []

# Guardar un nuevo evento y limitar la cantidad
def guardar_evento(evento):
    eventos_actuales = cargar_eventos()
    eventos_actuales.append(evento)

    # Limitar a los últimos N eventos
    if len(eventos_actuales) > MAX_EVENTOS:
        eventos_actuales = eventos_actuales[-MAX_EVENTOS:]

    with open(EVENTOS_FILE, 'w') as f:
        json.dump(eventos_actuales, f, indent=2)


@webhookRouter.route('/webhook/titulo', methods=['POST']) 
def recibir_nuevo_titulo():
  data = request.get_json()
  
  nuevo_evento = {
    'titulo': data.get('titulo'),
    'isbn': data.get('isbn'),
    'categoria': data.get('categoria'),
    'hora': datetime.now().isoformat()
  }

  guardar_evento(nuevo_evento)

  print(f"[Webhook] Nuevo título: {data}")
  return jsonify({"status": "ok"}), 200

@webhookRouter.route('/stream')
def stream():
  def event_stream():
    last_index = 0
    while True:
      eventos_actuales = cargar_eventos()
      if len(eventos_actuales) > last_index:
        nuevo = eventos_actuales[last_index]
        last_index += 1
        yield f"data: {json.dumps(nuevo)}\n\n"
  return Response(event_stream(), content_type='text/event-stream')
