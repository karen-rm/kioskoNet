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
$coleccion = 'detalles';

$data = '{
    "LIB001": {
        "Autor": "Suzanne Collins",
        "Nombre": "Los juegos del hambre",
        "Editorial": "Editorial Molino",
        "Fecha": 2012,
        "Precio": 459.00,
        "Descuento": 0.0
    }
}';


$res = create_document($proyecto, $coleccion, $data);
if( !is_null($res) ) {
    echo '<br>Insersión exitosa<br>';
} else {
    echo '<br>Insersión fallida<br>';
}

$data = '{
    "LIB002": {
        "Autor": "Marie Lu",
        "Nombre": "Los jovenes elite",
        "Editorial": "Editorial Hidra",
        "Fecha": 2016,
        "Precio": 664.34,
        "Descuento": 0.50
    }
}';


$res = create_document($proyecto, $coleccion, $data);
if( !is_null($res) ) {
    echo '<br>Insersión exitosa<br>';
} else {
    echo '<br>Insersión fallida<br>';
}

$data = '{
    "LIB003": {
        "Autor": "Rainbow Rowell",
        "Nombre": "Landline",
        "Editorial": "St. Martins Press",
        "Fecha": 1985,
        "Precio": 889.22,
        "Descuento": 0.12
    }
}';


$res = create_document($proyecto, $coleccion, $data);
if( !is_null($res) ) {
    echo '<br>Insersión exitosa<br>';
} else {
    echo '<br>Insersión fallida<br>';
}

$data = '{
    "COM001": {
        "Autor": "Frank Miller",
        "Nombre": "Batman",
        "Editorial": "DC Comics",
        "Fecha": 1987,
        "Precio": 567.60,
        "Descuento": 0.25
    }
}';


$res = create_document($proyecto, $coleccion, $data);
if( !is_null($res) ) {
    echo '<br>Insersión exitosa<br>';
} else {
    echo '<br>Insersión fallida<br>';
}

$data = '{
    "COM002": {
        "Autor": "J.M. DeMatteis",
        "Nombre": "El sorprendente hombre araña",
        "Editorial": "Marvel Comics",
        "Fecha": 1987,
        "Precio": 834.50,
        "Descuento": 0.15
    }
}';

$res = create_document($proyecto, $coleccion, $data);
if( !is_null($res) ) {
    echo '<br>Insersión exitosa<br>';
} else {
    echo '<br>Insersión fallida<br>';
}

$data = '{
    "COM003": {
        "Autor": "Alan Moore",
        "Nombre": "Watchmen",
        "Editorial": "DC Comics",
        "Fecha": 1986,
        "Precio": 400.00,
        "Descuento": 0.10
    }
}';

$res = create_document($proyecto, $coleccion, $data);
if( !is_null($res) ) {
    echo '<br>Insersión exitosa<br>';
} else {
    echo '<br>Insersión fallida<br>';
}

$data = '{
    "MAN001": {
        "Autor": "Negi Haruba",
        "Nombre": "Las quintillizas",
        "Editorial": "Norma Editorial",
        "Fecha": 2020,
        "Precio": 180.90,
        "Descuento": 0.0
    }
}';

$res = create_document($proyecto, $coleccion, $data);
if( !is_null($res) ) {
    echo '<br>Insersión exitosa<br>';
} else {
    echo '<br>Insersión fallida<br>';
}

$data = '{
    "MAN002": {
        "Autor": "Nanashi",
        "Nombre": "Dont Toy With Me",
        "Editorial": "Vertical Comics",
        "Fecha": 2017,
        "Precio": 155.75,
        "Descuento": 0.0
    }
}';

$res = create_document($proyecto, $coleccion, $data);
if( !is_null($res) ) {
    echo '<br>Insersión exitosa<br>';
} else {
    echo '<br>Insersión fallida<br>';
}

$data = '{
    "MAN003": {
        "Autor": "Akira Toriyama y Toyotarou",
        "Nombre": "Dragon ball super",
        "Editorial": "Planeta Comic",
        "Fecha": 2015,
        "Precio": 199.20,
        "Descuento": 0.15
      }
}';


$res = create_document($proyecto, $coleccion, $data);
if( !is_null($res) ) {
    echo '<br>Insersión exitosa<br>';
} else {
    echo '<br>Insersión fallida<br>';
}

$data = '{
    "MAN004": {
        "Autor": "Nanashi (774)",
        "Nombre": "Miss Nagatoro",
        "Editorial": "Vertical Comics",
        "Fecha": 2017,
        "Precio": 285.40,
        "Descuento": 0.10
      }
}';

$res = create_document($proyecto, $coleccion, $data);
if( !is_null($res) ) {
    echo '<br>Insersión exitosa<br>';
} else {
    echo '<br>Insersión fallida<br>';
}
?>