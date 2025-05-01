<?php

namespace App\Models;

use KioskoNet\FireBase;

class TituloModel
{
  private $firebase;

  public function __construct()
  {
    $this->firebase = new FireBase("kioskonet-fc6a6-default-rtdb");
  }

  // Obtener título de Firebase
  public function obtenerTitulo($id)
  {
    return $this->firebase->request('titulos', $id, 'GET');
  }

  // Agregar un título a Firebase
  public function agregarTitulo($id, $data)
  {
    return $this->firebase->request('titulos', $id, 'PUT', $data);
  }

  // Eliminar un título de Firebase
  public function eliminarTitulo($id)
  {
    return $this->firebase->request('titulos', $id, 'DELETE');
  }
}
