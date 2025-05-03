<?php

namespace App\Controllers;

use App\Services\ContenidoService;

class ContenidoController
{

  // Método para agregar un nuevo título
  public static function agregarTitulo($datos)
  {
    // Validar campos requeridos


    if ($datos['categoria'] === 'Revista') {
      $requeridos = ['isbn', 'titulo', 'revista', 'editorial', 'anio', 'genero', 'precio', 'categoria'];
      foreach ($requeridos as $campo) {
        if (empty($datos[$campo])) {
          return "Error: El campo '$campo' es obligatorio.";
        }
      }
    } else {
      $requeridos = ['isbn', 'titulo', 'autor', 'editorial', 'anio', 'genero', 'precio', 'categoria'];
      foreach ($requeridos as $campo) {
        if (empty($datos[$campo])) {
          return "Error: El campo '$campo' es obligatorio.";
        }
      }
    }

    // Llamamos al servicio
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
