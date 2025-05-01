<?php

namespace App\Controllers;

use App\Services\GestionarTituloService;

class TituloController
{
  private $tituloService;

  public function __construct()
  {
    $this->tituloService = new GestionarTituloService(); // Instanciamos el servicio
  }

  // Método para obtener un título
  public function obtenerTitulo($request, $response, $args)
  {
    $id = $args['id'];
    $titulo = $this->tituloService->obtenerTitulo($id); // Llamamos al servicio
    $response->getBody()->write($titulo);
    return $response;
  }

  // Método para agregar un título
  public function agregarTitulo($request, $response, $args)
  {
    $data = $request->getParsedBody();
    $id = $args['id'];
    $result = $this->tituloService->agregarTitulo($id, $data); // Llamamos al servicio
    $response->getBody()->write($result);
    return $response;
  }

  // Método para eliminar un título
  public function eliminarTitulo($request, $response, $args)
  {
    $id = $args['id'];
    $result = $this->tituloService->eliminarTitulo($id); // Llamamos al servicio
    $response->getBody()->write($result);
    return $response;
  }
}
