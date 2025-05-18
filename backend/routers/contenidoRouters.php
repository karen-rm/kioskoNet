<?php
use App\Controllers\ContenidoController;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


$app->get('/obtener-catalogo', function ($request, Response $response) {
    $controller = new ContenidoController();
    $resultado = $controller->obtenerCatalogo();

    $response->getBody()->write(json_encode($resultado));
    return $response
        ->withStatus(200)
        ->withHeader('Content-Type', 'application/json');
});

$app->post('/recuperar-detalles', function (Request $request, Response $response) {

    
    $datos = $request->getParsedBody();
    error_log('ISBN recibido: ' . json_encode($datos));  

    
    $controller = new ContenidoController();
    $resultado = $controller->obtenerDetalles($datos);  

    
    $status = $resultado['status'] ?? 500;
    $json = json_encode([
        'status' => $status,
        'message' => $resultado['message'] ?? 'Error desconocido',
        'detalles' => $resultado['detalles'] ?? null  
    ]);


    $response->getBody()->write($json);
    return $response
        ->withStatus($status)
        ->withHeader('Content-Type', 'application/json');
});

$app->post('/imagen', function (Request $request, Response $response) {
    
    // Obtener el archivo de la imagen
    $file = $_FILES['img'];
    
    // Verificar si la imagen fue subida correctamente
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $response->getBody()->write(json_encode([
            'status' => 400,
            'message' => 'Error al subir la imagen.'
        ]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }

    // Definir la ruta donde se guardará la imagen
    $uploadDir = '../img/';
    $imagePath = $uploadDir . basename($file['name']); // Obtener la ruta completa de la imagen

    // Mover la imagen a la carpeta de imágenes
    if (!move_uploaded_file($file['tmp_name'], $imagePath)) {
        $response->getBody()->write(json_encode([
            'status' => 500,
            'message' => 'Error al guardar la imagen en el servidor.'
        ]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
    }

    // Devolver la ruta de la imagen guardada en el servidor
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

    $controller = new ContenidoController();
    $resultado = $controller->obtenerDetalles(['isbn' => $isbn]);

    $response->getBody()->write(json_encode($resultado));
    return $response->withStatus($resultado['status'])->withHeader('Content-Type', 'application/json');
});





error_log("Rutas cargadas correctamente desde contenidoRouters.php");




