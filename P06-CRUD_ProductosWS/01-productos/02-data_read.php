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
$coleccion = 'productos';

$res = read_document($proyecto, $coleccion, 'libros');
if(!is_null($res)) {
    echo '<br>'.json_encode($res).'<br>';
} else {
    echo '<br>No se encontraron resultados<br>';
}

$res = read_document($proyecto, $coleccion, 'comics');
if(!is_null($res)) {
    echo '<br>'.json_encode($res).'<br>';
} else {
    echo '<br>No se encontraron resultados<br>';
}

$res = read_document($proyecto, $coleccion, 'mangas');
if(!is_null($res)) {
    echo '<br>'.json_encode($res).'<br>';
} else {
    echo '<br>No se encontraron resultados<br>';
}

?>