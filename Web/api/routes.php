<?php
// En-têtes pour le CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Gérer les requêtes OPTIONS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

include_once "restControllerVols.php";

// Nettoyage de l'URI
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$scriptPath = dirname($_SERVER['SCRIPT_NAME']);
$cleanedUri = str_replace($scriptPath . "/", "", $requestUri);

// Découper les segments
$uriParts = explode('/', trim($cleanedUri, '/'));
$resource = $uriParts[0] ?? '';
$idVol = $uriParts[1] ?? null;

// Méthode HTTP
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Routing
if ($resource === 'vol') {
    $controller = new RestControllerVols($requestMethod, $idVol);
    $response = $controller->processRequest();

    header('Content-Type: application/json');
    header($response['status_code_header']);
    echo $response['body'];
} else {
    http_response_code(404);
    echo json_encode(['message' => 'Resource Not Found']);
}
?>