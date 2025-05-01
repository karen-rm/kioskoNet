<?php

function create_document($project, $collection, $document) {
    $url = 'https://'.$project.'.firebaseio.com/'.$collection.'.json';

    $ch =  curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH" );  // en sustitución de curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $document);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/plain'));
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);

    curl_close($ch);

    // Se convierte a Object o NULL
    return json_decode($response);
}

$proyecto = 'tienda-e1876-default-rtdb';
$coleccion = 'respuestas';

/*$data = '{
    "200": "Categoria encontrada exitosamente.",
    "201": "ISBN encontrado exitosamente.",
    "300": "Categoria no encontrada.",
    "301": "ISBN no encontrado.",
    "500": "Usuario no reconocido.",
    "501": "Password no reconcido.",
    "998": "Error desconocido",
    "999": "Error no idetificado"
}';*/

/*$data='{
    "202": "Producto registrado correctamente.",
    "302": "El producto ya existe.",
    "303": "El JSON está mal formado."
}'; */

$data='{
    
    "203": "Producto actualizado correctamente.",
    "304": "El ISBN del producto no existe.",
    "303": "El JSON está mal formado.",
    "204": "Producto borrado correctamente."    
}';

$res = create_document($proyecto, $coleccion, $data);
if( !is_null($res) ) {
    echo '<br>Insersión exitosa<br>';
} else {
    echo '<br>Insersión fallida<br>';
}

?>