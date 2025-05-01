<?php

namespace KioskoNet;

class FireBase
{
  private $proyecto;
 
  public function __construct($proyecto)
  {
    $this->proyecto = $proyecto;
  }

  public function request($collection, $document = '', $method = 'GET', $data = null): string
  {
    // Construcción de la URL
    $url = 'https://' . $this->proyecto . '.firebaseio.com/' . $collection;
    if (!empty($document)) {
      $url .= '/' . $document;
    }
    $url .= '.json';


    // Inicializar cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

    // Si hay datos, codificarlos como JSON
    if ($data !== null) {
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
      curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    }

    // Ejecutar petición
    $response = curl_exec($ch);

    // Verificar errores
    if (curl_errno($ch)) {
      $error_msg = curl_error($ch);
      curl_close($ch);
      return json_encode(['error' => $error_msg]);
    }

    curl_close($ch);

    // Validar respuesta
    if (is_null($response) || empty($response)) {
      return json_encode(['error' => 'Respuesta vacía o nula']);
    }

    // Decodificar para verificar validez
    $decoded = json_decode($response);
    if (is_null($decoded)) {
      return json_encode(['error' => 'Error al decodificar respuesta']);
    }

    return json_encode($decoded);
  }
}
