<?php

namespace App\Controllers;

use App\Services\CatalogoService;

class CatalogoController
{
  private $servicio;

  public function __construct()
  {
    $this->servicio = new CatalogoService();
  }

  public function obtenerCatalogo()
  {
    return $this->servicio->obtenerCatalogo();
  }

  public function obtenerDetalles($isbn)
  {
    return $this->servicio->obtenerDetalles($isbn);
  }

}

