<?php
require_once __DIR__ . '/../../modele/dao/connexionBD.class.php';
require_once __DIR__ . '/../../modele/VolClass.php';
require_once __DIR__ . '/../../modele/dao/VolDao.php';
require_once __DIR__ . '/../restControllerVols.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Extraire l'URI (ex: /api/vols/V001)
$requestUri = $_SERVER['REQUEST_URI'];
$scriptPath = dirname($_SERVER['SCRIPT_NAME']);
$cleanedUri = str_replace($scriptPath, '', $requestUri);

// Enlève les slashes en trop et explose
$uriParts = explode('/', trim($cleanedUri, '/'));
$idVol = $uriParts[2] ?? null;

// Méthode HTTP (GET, POST, PUT, DELETE)
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Gère PUT et DELETE (json dans php://input)
if ($requestMethod === 'PUT' || $requestMethod === 'DELETE') {
    parse_str(file_get_contents("php://input"), $_REQUEST);
}

// Lancer le contrôleur
$controller = new RestControllerVols($requestMethod, $idVol);
$response = $controller->processRequest();

// Envoyer la réponse
header($response['status_code_header']);
echo json_encode($response['body']);
?>