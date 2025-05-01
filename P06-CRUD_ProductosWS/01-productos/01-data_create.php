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

$proyecto = 'kiosko-38acc-default-rtdb';
$coleccion = 'catalogo';

$data = '{
    "libros": {
        "LIB001": "Los juegos del hambre",
        "LIB002": "Los jóvenes élite",
        "LIB003": "Landline"
    }
}';


$res = create_document($proyecto, $coleccion, $data);
if( !is_null($res) ) {
    echo '<br>Insersión exitosa<br>';
} else {
    echo '<br>Insersión fallida<br>';
}

$data = '{
    "revistas": {
        "REV001": "Revista1",
        "REV002": "Revista2",
        "REV003": "Revista3"
    }
}';


$res = create_document($proyecto, $coleccion, $data);
if( !is_null($res) ) {
    echo '<br>Insersión exitosa<br>';
} else {
    echo '<br>Insersión fallida<br>';
}

$data = '{
    "comics": {
        "COM001": "Batman",
        "COM002": "El sorprendente hombre araña",
        "COM003": "Watchmen"
    }
}';


$res = create_document($proyecto, $coleccion, $data);
if( !is_null($res) ) {
    echo '<br>Insersión exitosa<br>';
} else {
    echo '<br>Insersión fallida<br>';
}

$data = '{
    "mangas": {
        "MAN001": "Las quintillizas",
        "MAN002": "Dont Toy With Me",
        "MAN003": "Dragón ball super",
        "MAN004": "Mis Nagatoro"
    }
}';

$res = create_document($proyecto, $coleccion, $data);
if( !is_null($res) ) {
    echo '<br>Insersión exitosa<br>';
} else {
    echo '<br>Insersión fallida<br>';
}

/*$data = '{
    "articulos": {
        "ART001": "Taza clásica Haus Classique",
        "ART002": "Tote Bag De Manta Negra Personalizada",
        "ART003": "Case Phone Matte Personalizada"
    }
}';

$res = create_document($proyecto, $coleccion, $data);
if( !is_null($res) ) {
    echo '<br>Insersión exitosa<br>';
} else {
    echo '<br>Insersión fallida<br>';
}*/
?>