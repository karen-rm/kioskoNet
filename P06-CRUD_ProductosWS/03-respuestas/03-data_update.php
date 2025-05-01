<?php
function update_document($project, $collection, $document, $fields) {
    $url = 'https://'.$project.'.firebaseio.com/'.$collection.'/'.$document.'.json';

    $ch =  curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);

    if( !is_null(json_decode($response)) ) {
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT" );  // en sustitución de curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/plain'));
        $response = curl_exec($ch);
    }

    curl_close($ch);

    // Se convierte a Object o NULL
    return json_decode($response);
}

$proyecto = 'tienda-e1876-default-rtdb';
$coleccion = 'respuestas';

$data = '"ERROR DESCONOCIDO"';

$res = update_document($proyecto, $coleccion, '998', $data);
if( !is_null($res) ) {
    echo '<br>Actualización exitosa<br>';
} else {
    echo '<br>Actualización fallida<br>';
}

?>