<?php

namespace App\Services;

use App\Models\ContenidoModel;

class ContenidoService
{


  public static function guardarTitulo($isbn, $titulo, $autor, $editorial, $anio, $genero, $precio, $categoria)
  {
    $modelo = new ContenidoModel();

    // Verificar si ya existe
    if ($modelo->verificarTituloExistente($isbn, $categoria)) {
      return "El título con ISBN {$isbn} ya existe en la categoría '{$categoria}'";
    }

    // Datos para guardar
    // Solo pasamos el valor plano del título
    $resCatalogo = $modelo->agregarTitulo($isbn, $categoria, $titulo);


    $datosDetalles = [
      'Autor' => $autor,
      'Año publicacion' => $anio,
      'Editorial' => $editorial,
      'Genero' => $genero,
      'Precio' => $precio,
      'Titulo' => $titulo,
    ];

    // Guardar en Firebase
    $resCatalogo = $modelo->agregarTitulo($isbn, $categoria, $resCatalogo);
    $resDetalles = $modelo->agregarDetalles($isbn, $datosDetalles);

    return "Título agregado correctamente. \nCatálogo: $resCatalogo \nDetalles: $resDetalles";
  }
}
