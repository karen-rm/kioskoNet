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
      // Solicitud GET
      $response = $this->firebase->request('Catalogo/' . $categoria, $isbn, 'GET');

      // Si la respuesta está vacía o contiene un error, significa que no existe
      $decoded = json_decode($response);

      if (empty($decoded)) {
          return false; // No existe
      } else {
          return true; // El título ya existe
      }
  }



  // Agregar un título a Firebase
  public function agregarTitulo($isbn, $categoria, $data)
  {
    return $this->firebase->request('Catalogo/' . $categoria, $isbn, 'POST', $data);
  }

    public function agregarDetalles($isbn, $data)
  {
    return $this->firebase->request('Detalles/' , $isbn, 'POST', $data);
  }



  
}
