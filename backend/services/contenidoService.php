<?php

namespace App\Services;

use App\Models\ContenidoModel;

class ContenidoService
{
  public static function guardarTitulo($isbn, $titulo, $autor, $editorial, $anio, $genero, $precio, $categoria, $revista)
  {
    $modelo = new ContenidoModel();

    // Verificar duplicado
    if ($modelo->verificarTituloExistente($isbn, $categoria)) {
      return [
        'status' => 409,
        'message' => "El título con ISBN {$isbn} ya existe en la categoría '{$categoria}'"
      ];
    }

    // Guardar en catálogo
    $resCatalogo = $modelo->agregarTitulo($isbn, $categoria, $titulo);

    // Preparar detalles
    $detalles = [
      'Editorial' => $editorial,
      'Año publicacion' => $anio,
      'Genero' => $genero,
      'Precio' => $precio,
      'Titulo' => $titulo,
    ];

    if ($categoria === 'Revista') {
      $detalles['Revista'] = $revista;
    } else {
      $detalles['Autor'] = $autor;
    }

    // Guardar detalles
    $resDetalles = $modelo->agregarDetalles($isbn, $detalles);

    // Validar respuestas de Firebase (opcional)
    $catalogoError = strpos($resCatalogo, 'error') !== false;
    $detallesError = strpos($resDetalles, 'error') !== false;

    if ($catalogoError || $detallesError) {
      return [
        'status' => 500,
        'message' => "Error al guardar en Firebase.",
        'data' => [
          'catalogo' => $resCatalogo,
          'detalles' => $resDetalles
        ]
      ];
    }

    // Todo bien
    return [
      'status' => 201,
      'message' => "Título agregado correctamente.",
      'data' => [
        'isbn' => $isbn,
        'categoria' => $categoria
      ]
    ];
  }
}
