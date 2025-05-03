<?php

namespace App\Controllers;

use App\Services\ContenidoService;

class ContenidoController
{
  public static function agregarTitulo($datos)
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
          return ['status' => 422, 'message' => "Error: El campo '$campo' es obligatorio para revistas."];
        }
      }
    } else {
      foreach ($requeridos as $campo) {
        if (empty($datos[$campo])) {
          return ['status' => 422, 'message' => "Error: El campo '$campo' es obligatorio para libros."];
        }
      }
    }

    // Llamar al servicio
    return ContenidoService::guardarTitulo(
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
}
