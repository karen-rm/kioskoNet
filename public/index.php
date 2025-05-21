<?php

use Slim\Factory\AppFactory;


// Cargar el autoloader de Composer 
require __DIR__ . '/../vendor/autoload.php';

// Crear la instancia de la aplicación Slim
$app = AppFactory::create();
$app->setBasePath("/ServiciosWeb/ProyectoFinal/kioskoNet/public");


// Archivo que contiene las rutas
require __DIR__ . '/../backend/routers/contenidoRouters.php';
require __DIR__ . '/../backend/routers/catalogoRouters.php';

// Ejecutar la aplicación
$app->run();
