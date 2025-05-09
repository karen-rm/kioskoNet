<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");  // Evita problemas de CORS

$id = $_GET['id'] ?? '';
if (empty($id)) {
    echo json_encode(['error' => 'Falta el ID del producto']);
    exit;
}

$proyecto = 'kioskonet-fc6a6-default-rtdb';
$url = "https://$proyecto.firebaseio.com/Detalles/$id.json";

$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => false
]);

$response = curl_exec($ch);
curl_close($ch);

echo $response;  // Devuelve el JSON tal cual de Firebase
?>