<?php
use Slim\Factory\AppFactory;

// Cargar el autoloader de Composer 
require __DIR__ . '/../vendor/autoload.php';

// Crear la instancia de la aplicación Slim
$app = AppFactory::create();

// Archivo que contiene las rutas
require __DIR__ . '/../backend/routers/contenidoRouters.php';

// Ejecutar la aplicación
$app->run();
