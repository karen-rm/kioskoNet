<?php

namespace App\Models;

use KioskoNet\FireBase;

class ContenidoModel
{
  private $firebase;

  public function __construct()
  {
    $this->firebase = new FireBase("kioskonet-fc6a6-default-rtdb");
  }

  // Función para verificar si el ISBN ya existe
  public function verificarTituloExistente($isbn, $categoria)
  {
    $response = $this->firebase->request('Catalogo/' . $categoria, $isbn, 'GET');

    $decoded = json_decode($response, true);

    if (isset($decoded['error']) || is_null($decoded)) {
      return false; // No existe
    }

    if (is_array($decoded) && count($decoded) === 0) {
      return false; // No existe
    }

    return true; // Existe
  }


  public function agregarTitulo($isbn, $categoria, $titulo)
  {
    return $this->firebase->request('Catalogo/' . $categoria . '/' . $isbn, '', 'PUT', $titulo);
  }

  public function agregarDetalles($isbn, $data)
  {
    return $this->firebase->request('Detalles/', $isbn, 'PUT', $data);
  }

  public function eliminarTitulo($isbn, $categoria)
  {
    return $this->firebase->request("Catalogo/{$categoria}", $isbn, 'DELETE');
  }

  public function eliminarDetalles($isbn)
  {
    return $this->firebase->request('Detalles/', $isbn, 'DELETE', null);
  }
}
