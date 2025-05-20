<?php

namespace App\Controllers;

use App\Services\ContenidoService;

class ContenidoController
{
  private $servicio;

  public function __construct()
  {
    $this->servicio = new ContenidoService();
  }

  public function obtenerCatalogo()
  {
    return $this->servicio->obtenerCatalogo();
  }

  public function obtenerDetalles($isbn)
  {
    return $this->servicio->obtenerDetalles($isbn);
  }


  public function agregarTitulo($datosTitulo)
  {

    $validacion = $this->verificarCampos($datosTitulo);
    if ($validacion !== null) {
      return $validacion;
    }

    // Llamar al servicio
    return $this->servicio->guardarTitulo($datosTitulo);
  }

  public function editarTitulo($datosNuevosTitulo)
  {
    $validacion = $this->verificarCampos($datosNuevosTitulo);
    if ($validacion !== null) {
      return $validacion;
    }

    // Llamar al servicio
    return $this->servicio->editarTitulo($datosNuevosTitulo);

  }

  public function verificarCampos($datos)
  {

    if (!is_array($datos)) {
      return ['status' => 400, 'message' => 'No se recibieron datos válidos'];
    }

    $requeridosRevista = ['isbn', 'titulo', 'revista', 'editorial', 'anio', 'genero', 'precio', 'categoria', 'img'];
    $requeridos = ['isbn', 'titulo', 'autor', 'editorial', 'anio', 'genero', 'precio', 'categoria', 'img'];

    $categoria = $datos['categoria'] ?? '';

    if ($categoria === 'Revista') {
      foreach ($requeridosRevista as $campo) {
        if (empty($datos[$campo])) {
          return ['status' => 422, 'message' => "Error: El campo '$campo' es obligatorio."];
        }
      }
    } else {
      foreach ($requeridos as $campo) {
        if (empty($datos[$campo])) {
          return ['status' => 422, 'message' => "Error: El campo '$campo' es obligatorio."];
        }
      }
    }

    return null;
  }

  public function eliminarTitulo($datos)
  {

    if (empty($datos['isbn']) || empty($datos['categoria'])) {
      return ['status' => 400, 'message' => 'Datos incompletos para eliminar titulo.'];
    }

    // Llamar al servicio
    return $this->servicio->eliminarTitulo(
      $datos['isbn'],
      $datos['categoria'],
    );
  }
}
