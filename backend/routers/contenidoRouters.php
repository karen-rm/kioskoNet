<?php
use App\Controllers\ContenidoController;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


$app->get('/prueba', function (Request $request, Response $response) {
    $response->getBody()->write("Ruta de prueba OK");
    return $response;
});

$app->post('/agregar-titulo', function (Request $request, Response $response) {
    $datos = $request->getParsedBody();
    // Llamar al controlador
    $resultado = ContenidoController::agregarTitulo($datos);

    // Responder al cliente
    $response->getBody()->write($resultado);
    return $response->withHeader('Content-Type', 'text/plain');
});

error_log("Rutas cargadas correctamente desde contenidoRouters.php");




