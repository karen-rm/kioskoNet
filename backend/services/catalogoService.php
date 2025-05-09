<?php
header('Content-Type: application/json'); // Para que se lea como JSON y no como HTML


// Función para leer datos registrados de la base de datos 
function getFirebaseData($documento) {
    global $proyecto, $coleccion;
    $url = "https://$proyecto.firebaseio.com/$coleccion/$documento.json";
    
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false
    ]);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    return json_decode($response, true); // Lo convierte en array
}

$proyecto = 'kioskonet-fc6a6-default-rtdb'; 
$coleccion = 'Catalogo';

// Datos  de cada categoría
$data = [
    'Libro' => getFirebaseData('Libro'),
    'Comic' => getFirebaseData('Comic'),
    'Manga' => getFirebaseData('Manga'),
    'Revista' => getFirebaseData('Revista')
];

// Filtra lo que no existe 
$dataFiltrada = array_filter($data, fn($item) => !is_null($item));

echo json_encode($dataFiltrada, JSON_PRETTY_PRINT); // Mera estetica al formar el json 
?>