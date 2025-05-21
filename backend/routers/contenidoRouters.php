<?php
use App\Controllers\ContenidoController;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app->post('/imagen', function (Request $request, Response $response) {
    
    $file = $_FILES['img'];
    
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $response->getBody()->write(json_encode([
            'status' => 400,
            'message' => 'Error al subir la imagen.'
        ]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }

    $uploadDir = '../img/';
    $imagePath = $uploadDir . basename($file['name']); 

    if (!move_uploaded_file($file['tmp_name'], $imagePath)) {
        $response->getBody()->write(json_encode([
            'status' => 500,
            'message' => 'Error al guardar la imagen en el servidor.'
        ]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
    }

    $response->getBody()->write(json_encode([
        'status' => 200,
        'imagenUrl' => $imagePath
    ]));
    return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
});

//Microservicio agregar titulo
$app->post('/titulo', function (Request $request, Response $response) {
    
    $datosTitulo = json_decode($request->getBody(), true);
    
    $controller = new ContenidoController();
    $resultado = $controller->agregarTitulo($datosTitulo);

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

//Microservicio editar titulo
$app->put('/titulo', function (Request $request, Response $response){
    $datosNuevosTitulo = json_decode($request->getBody(), true);

    $controller = new ContenidoController();
    $resultado = $controller->editarTitulo($datosNuevosTitulo);

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

//Microservicio eliminar titulo
$app->delete('/titulo', function (Request $request, Response $response) {
    $datos = json_decode($request->getBody()->getContents(), true);

    
    $controller = new ContenidoController();
    $resultado = $controller->eliminarTitulo($datos);

    $status = $resultado['status'] ?? 503;
    $json = json_encode([
        'status' => $status,
        'message' => $resultado['message'] ?? 'Error desconocido en el servidor al eliminar'
    ]);

    $response->getBody()->write($json);
    return $response
        ->withStatus($status)
        ->withHeader('Content-Type', 'application/json');
});


error_log("Rutas cargadas correctamente desde contenidoRouters.php");




