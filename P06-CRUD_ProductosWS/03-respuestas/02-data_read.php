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
$coleccion = 'respuestas';

$res = read_document($proyecto, $coleccion, '200');
if(!is_null($res)) {
    echo '<br>'.json_encode($res).'<br>';
} else {
    echo '<br>No se encontraron resultados<br>';
}

$res = read_document($proyecto, $coleccion, '201');
if(!is_null($res)) {
    echo '<br>'.json_encode($res).'<br>';
} else {
    echo '<br>No se encontraron resultados<br>';
}

$res = read_document($proyecto, $coleccion, '300');
if(!is_null($res)) {
    echo '<br>'.json_encode($res).'<br>';
} else {
    echo '<br>No se encontraron resultados<br>';
}

$res = read_document($proyecto, $coleccion, '301');
if(!is_null($res)) {
    echo '<br>'.json_encode($res).'<br>';
} else {
    echo '<br>No se encontraron resultados<br>';
}

$res = read_document($proyecto, $coleccion, '500');
if(!is_null($res)) {
    echo '<br>'.json_encode($res).'<br>';
} else {
    echo '<br>No se encontraron resultados<br>';
}

$res = read_document($proyecto, $coleccion, '501');
if(!is_null($res)) {
    echo '<br>'.json_encode($res).'<br>';
} else {
    echo '<br>No se encontraron resultados<br>';
}

$res = read_document($proyecto, $coleccion, '999');
if(!is_null($res)) {
    echo '<br>'.json_encode($res).'<br>';
} else {
    echo '<br>No se encontraron resultados<br>';
}

?>