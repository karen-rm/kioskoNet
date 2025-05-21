<?php
use App\Controllers\CatalogoController;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

//Microservicio explorar catálogo
$app->get('/catalogo', function ($request, Response $response) {
    $controller = new CatalogoController();
    $resultado = $controller->obtenerCatalogo();

    $response->getBody()->write(json_encode($resultado));
    return $response
        ->withStatus(200)
        ->withHeader('Content-Type', 'application/json');
});

//Microservicio obtener detalles del título
$app->get('/detalles', function (Request $request, Response $response) {
    $isbn = $request->getQueryParams()['isbn'] ?? null;

    if (!$isbn) {
        $response->getBody()->write(json_encode([
            'status' => 400,
            'message' => 'El ISBN es necesario.',
            'detalles' => null
        ]));
        return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
    }

    $controller = new CatalogoController();
    $resultado = $controller->obtenerDetalles(['isbn' => $isbn]);

    $response->getBody()->write(json_encode($resultado));
    return $response->withStatus($resultado['status'])->withHeader('Content-Type', 'application/json');
});
