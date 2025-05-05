<?php
use App\Controllers\ContenidoController;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


$app->get('/prueba', function (Request $request, Response $response) {
    $response->getBody()->write("Ruta de prueba OK");
    return $response;
});

$app->get('/obtener-catalogo', function ($request, Response $response) {
    $controller = new ContenidoController();
    $resultado = $controller->obtenerCatalogo();

    $response->getBody()->write(json_encode($resultado));
    return $response
        ->withStatus(200)
        ->withHeader('Content-Type', 'application/json');
});


$app->post('/agregar-titulo', function (Request $request, Response $response) {
    $datos = $request->getParsedBody();
    
    $controller = new ContenidoController();
    $resultado = $controller->agregarTitulo($datos);

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

$app->post('/editar-titulo', function (Request $request, Response $response){
    $datos = $request->getParsedBody();

    $controller = new ContenidoController();
    $resultado = $controller->editarTitulo($datos);

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




