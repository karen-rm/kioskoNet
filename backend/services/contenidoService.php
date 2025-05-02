<?php

namespace App\Services;

use App\Models\ContenidoModel;

class ContenidoService
{
  private $contenidoModel;

  public function __construct()
  {
    $this->contenidoModel = new ContenidoModel(); // Instanciamos el modelo
  }

 public function agregarTitulo($isbn, $categoria,  $catalogoData, $detallesData)
{
    // Verificar si el título ya existe en la base de datos (Catalogo)
    $tituloExistente = $this->contenidoModel->verificarTituloExistente($isbn, $categoria);
    
    if ($tituloExistente) {
        // Si el título ya existe, devolver un mensaje de error
        return json_encode(['error' => 'El título con este ISBN ya existe.']);
    }

    // Si no existe, agregar el título al Catalogo
    $this->contenidoModel->agregarTitulo($isbn,$categoria, $catalogoData);

    // Agregar los detalles a la colección Detalles
    $this->contenidoModel->agregarDetalles($isbn, $detallesData);

    // Devolver el éxito
    return json_encode(['success' => 'Título agregado con éxito.']);
}




}
