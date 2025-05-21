<?php

namespace App\Services;

use App\Models\CatalogoModel;

header("Content-Type: application/json");

class CatalogoService
{
  private $modelo;

  public function __construct()
  {
    $this->modelo = new CatalogoModel();
  }

  public function obtenerCatalogo()
  {
    return $this->modelo->obtenerCatalogo();
  }

  public function obtenerDetalles($datos)
  {
    if (!isset($datos['isbn']) || empty($datos['isbn'])) {
      return [
        'status' => 400,
        'message' => 'El ISBN es necesario para recuperar los detalles.',
        'detalles' => null
      ];
    }

    $isbn = $datos['isbn'];
    $detalles = $this->modelo->obtenerDetalles($isbn);

    if (is_null($detalles)) {
      return [
        'status' => 404,
        'message' => 'Detalles no encontrados para el ISBN proporcionado.',
        'detalles' => null
      ];
    }

    return [
      'status' => 200,
      'message' => 'Detalles recuperados con éxito.',
      'detalles' => $detalles
    ];
  }
}
