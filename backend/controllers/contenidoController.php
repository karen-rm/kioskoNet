<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Services\ContenidoService;

class ContenidoController
{
  private $contenidoService;

  public function __construct()
  {
    $this->contenidoService = new ContenidoService(); // Instanciamos el servicio
  }


  // Método para agregar un nuevo título
  public function agregarTitulo(Request $request, Response $response, $args)
  {
    // Obtener los datos del cuerpo de la solicitud
    $data = $request->getParsedBody();


    // Extraer los valores del formulario
    $isbn = $data['isbn'];
    $titulo = $data['titulo'];
    $autor = $data['autor'];
    $editorial = $data['editorial'];
    $anio = $data['anio'];
    $genero = $data['genero'];
    $precio = $data['precio'];
    $categoria = $request["categoria"];

    // Organizar los datos para agregar al Catalogo
    $catalogoData = [
      'titulo' => $titulo,
    ];

    // Organizar los datos para agregar a Detalles
    $detallesData = [
      'autor' => $autor,
      'anio' => $anio,
      'editorial' => $editorial,
      'genero' => $genero,
      'precio' => $precio,
      'titulo' => $titulo,
    ];

    // Llamar al servicio para verificar si el título ya existe
    $result = $this->contenidoService->agregarTitulo($isbn, $categoria, $catalogoData, $detallesData);

    // Devolver la respuesta del servicio
    $response->getBody()->write($result);
    return $response;
  }

  
}
