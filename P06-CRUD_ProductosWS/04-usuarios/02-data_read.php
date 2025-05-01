<?php

function read_document($project, $collection, $document) {
    $url = 'https://'.$project.'.firebaseio.com/'.$collection.'/'.$document.'.json';

    $ch =  curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);

    curl_close($ch);

    // Se convierte a Object o NULL
    return json_decode($response);
}

$proyecto = 'tienda-e1876-default-rtdb';
$coleccion = 'usuarios';

$res = read_document($proyecto, $coleccion, 'pruebas1');
if(!is_null($res)) {
    echo '<br>'.json_encode($res).'<br>';
} else {
    echo '<br>No se encontraron resultados<br>';
}

$res = read_document($proyecto, $coleccion, 'pruebas2');
if(!is_null($res)) {
    echo '<br>'.json_encode($res).'<br>';
} else {
    echo '<br>No se encontraron resultados<br>';
}

$res = read_document($proyecto, $coleccion, 'pruebas3');
if(!is_null($res)) {
    echo '<br>'.json_encode($res).'<br>';
} else {
    echo '<br>No se encontraron resultados<br>';
}

?>