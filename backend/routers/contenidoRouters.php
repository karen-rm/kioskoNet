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
    $resultado = ContenidoController::agregarTitulo($datos);

    $status = $resultado['status'] ?? 500;
    $json = json_encode([
        'status' => $status,
        'message' => $resultado['message'] ?? 'Error desconocido'
    ]);

    $response->getBody()->write($json);
    return $response
        ->withStatus($status)
        ->withHeader('Content-Type', 'application/json');
});


error_log("Rutas cargadas correctamente desde contenidoRouters.php");




