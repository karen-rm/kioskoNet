<?php

namespace App\Controllers;

use App\Services\ContenidoService;

class ContenidoController
{
  
  // Método para agregar un nuevo título
  public static function agregarTitulo($datos)
  {
  
    $titulo = $datos['titulo'];
    $isbn = $datos['isbn'];
    $titulo = $datos['titulo'];
    $autor = $datos['autor'];
    $editorial = $datos['editorial'];
    $anio = $datos['anio'];
    $genero = $datos['genero'];
    $precio = $datos['precio'];
    $categoria = $datos["categoria"];

    // Llamamos al servicio
    return ContenidoService::guardarTitulo($isbn, $titulo, $autor, $editorial, $anio, $genero, $precio, $categoria);
  }

  
}
