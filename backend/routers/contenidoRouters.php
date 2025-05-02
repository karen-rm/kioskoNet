<?php
use App\Controllers\ContenidoController;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/*$app->post('/agregar-titulo', function (Request $request, Response $response) {
    $datos = $request->getParsedBody();
    $titulo = $datos['titulo'] ?? '';

    // Aquí podrías llamar a tu controlador
    // $resultado = ContenidoController::guardarTitulo($datos);

    $response->getBody()->write("Recibido: $titulo");
    return $response->withHeader('Content-Type', 'text/plain');
});*/

$app->get('/prueba', function (Request $request, Response $response) {
    $response->getBody()->write("Ruta de prueba OK");
    return $response;
});

$app->post('/agregar-titulo', function (Request $request, Response $response) {
    $datos = $request->getParsedBody();
    $titulo = $datos['titulo'] ?? 'No recibido';
    $response->getBody()->write("Recibido: $titulo");
    return $response->withHeader('Content-Type', 'text/plain');
});

error_log("Rutas cargadas correctamente desde contenidoRouters.php");




