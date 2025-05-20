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
  
    // Usamos una ruta explícita para evitar claves aleatorias
    return $this->firebase->request('Catalogo/' . $categoria . '/' . $isbn, '', 'PUT', $titulo);
}



  public function agregarDetalles($isbn, $data)
  {
    return $this->firebase->request('Detalles/', $isbn, 'PUT', $data);
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
    $isbn = trim($isbn); // 🔧 importante para evitar espacios, saltos de línea

    if (empty($isbn)) {
        return null; // no continuar si está vacío
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




  public function eliminarTitulo($isbn, $categoria)
  {
    return $this->firebase->request("Catalogo/{$categoria}", $isbn, 'DELETE');
  }

  public function eliminarDetalles($isbn)
  {
    return $this->firebase->request('Detalles/', $isbn, 'DELETE', null);
  }
}
