<?php

use App\Controllers\TituloController;

$app->get('/titulo/{id}', [TituloController::class, 'obtenerTitulo']);
$app->put('/titulo/{id}', [TituloController::class, 'agregarTitulo']);
$app->delete('/titulo/{id}', [TituloController::class, 'eliminarTitulo']);
