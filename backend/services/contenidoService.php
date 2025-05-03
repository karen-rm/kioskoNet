<?php

namespace App\Services;

use App\Models\ContenidoModel;

class ContenidoService
{


  public static function guardarTitulo($isbn, $titulo, $autor, $editorial, $anio, $genero, $precio, $categoria, $revista)
  {
    $modelo = new ContenidoModel();

    // Verificar si ya existe
    if ($modelo->verificarTituloExistente($isbn, $categoria)) {
      return "El título con ISBN {$isbn} ya existe en la categoría '{$categoria}'";
    }

    // Datos para guardar
    
    $resCatalogo = $modelo->agregarTitulo($isbn, $categoria, $titulo);
    
    // Detalles dependiendo del tipo
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

    // Guardar en Firebase
    $resCatalogo = $modelo->agregarTitulo($isbn, $categoria, $resCatalogo);
    $resDetalles = $modelo->agregarDetalles($isbn, $detalles);

    return "Título agregado correctamente. \nCatálogo: $resCatalogo \nDetalles: $resDetalles";
  }
}
