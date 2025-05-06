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
    // Hacemos la solicitud GET
    $response = $this->firebase->request('Catalogo/' . $categoria, $isbn, 'GET');

    // Intentamos decodificar
    $decoded = json_decode($response, true); // ← usamos true para array asociativo

    // Si hay un error o el documento no existe (devuelve null)
    if (isset($decoded['error']) || is_null($decoded)) {
      return false; // No existe
    }

    // Si está vacío como array vacío o string vacío
    if (is_array($decoded) && count($decoded) === 0) {
      return false; // No existe
    }

    return true; // Existe
  }




  // Agregar un título a Firebase
  public function agregarTitulo($isbn, $categoria, $titulo)
  {
    // El título se manda como string, no como array u objeto
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

  public function eliminarTitulo($isbn, $categoria){
    return $this->firebase->request("Catalogo/{$categoria}", $isbn, 'DELETE');
  }

  public function eliminarDetalles($isbn){
    return $this->firebase->request('Detalles/', $isbn, 'DELETE', null);
  }

}
