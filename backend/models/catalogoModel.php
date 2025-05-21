<?php

namespace App\Models;

use KioskoNet\FireBase;

class CatalogoModel
{
  private $firebase;

  public function __construct()
  {
    $this->firebase = new FireBase("kioskonet-fc6a6-default-rtdb");
  }

  public function obtenerCatalogo()
  {
    $response = $this->firebase->request('Catalogo/', '', 'GET');

    error_log("Respuesta bruta: $response");

    if (empty($response) || $response === 'null') {
      return [];
    }

    $decoded = json_decode($response, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
      error_log("Error al decodificar: " . json_last_error_msg());
      return [];
    }

    return $decoded;
  }


  public function obtenerDetalles($isbn)
  {
    $isbn = trim($isbn);

    if (empty($isbn)) {
      return null;
    }

    $response = $this->firebase->request('Detalles/', $isbn, 'GET');

    if ($response === false || $response === 'null' || empty($response)) {
      return null;
    }

    $decoded = json_decode($response, true);
    if (json_last_error() !== JSON_ERROR_NONE || !is_array($decoded)) {
      return null;
    }

    return $decoded;
  }
}
