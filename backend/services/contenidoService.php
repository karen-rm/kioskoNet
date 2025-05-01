<?php

namespace App\Services;

use App\Models\TituloModel;

class GestionarTituloService
{
  private $tituloModel;

  public function __construct()
  {
    $this->tituloModel = new TituloModel(); // Instanciamos el modelo
  }

  // Obtener un título
  public function obtenerTitulo($id)
  {
    return $this->tituloModel->obtenerTitulo($id); // Llama al modelo para obtener el título
  }

  // Agregar un título
  public function agregarTitulo($id, $data)
  {
    return $this->tituloModel->agregarTitulo($id, $data); // Llama al modelo para agregar un título
  }

  // Eliminar un título
  public function eliminarTitulo($id)
  {
    return $this->tituloModel->eliminarTitulo($id); // Llama al modelo para eliminar un título
  }
}
