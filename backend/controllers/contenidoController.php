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

  public function obtenerDetalles($datos)
  {

    $isbn = $datos['isbn'] ?? null;


    if (empty($isbn)) {
      return [
        'status' => 400,
        'message' => 'El ISBN es necesario para recuperar los detalles.'
      ];
    }


    return $this->servicio->obtenerDetalles($isbn);
  }


  public function agregarTitulo($datos)
  {
    $validacion = $this->verificarCampos($datos);
    if ($validacion !== null) {
      return $validacion;
    }

    // Llamar al servicio
    return $this->servicio->guardarTitulo(
      $datos['isbn'],
      $datos['titulo'],
      $datos['autor'] ?? null,
      $datos['editorial'],
      $datos['anio'],
      $datos['genero'],
      $datos['precio'],
      $datos['categoria'],
      $datos['revista'] ?? null
    );
  }

  public function editarTitulo($datos)
  {
    $validacion = $this->verificarCampos($datos);
    if ($validacion !== null) {
      return $validacion;
    }

    // Llamar al servicio
    return $this->servicio->editarTitulo(
      $datos['isbn'],
      $datos['titulo'],
      $datos['autor'] ?? null,
      $datos['editorial'],
      $datos['anio'],
      $datos['genero'],
      $datos['precio'],
      $datos['categoria'],
      $datos['revista'] ?? null
    );
  }

  public function verificarCampos($datos)
  {

    if (!is_array($datos)) {
      return ['status' => 400, 'message' => 'No se recibieron datos válidos'];
    }

    $requeridosRevista = ['isbn', 'titulo', 'revista', 'editorial', 'anio', 'genero', 'precio', 'categoria'];
    $requeridos = ['isbn', 'titulo', 'autor', 'editorial', 'anio', 'genero', 'precio', 'categoria'];

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
