<?php
// Inclusion des classes nécessaires pour la gestion des produits
include_once "../modele/DAO/ProductDAO.class.php";
include_once "../modele/Product.class.php";

class RestControllerVols 
{

    // attributs privés
    private $requestMethod;
    // Constructeur de la classe
    public function __construct($requestMethod, $productId) {
    
    }
    
  

    // Vérification de la validité des données du produit
    private function validateProduct($data) {
        return !empty($data['name']) && 
               !empty($data['category']) && 
               !empty($data['description']) && 
               isset($data['price']) && is_numeric($data['price']) && $data['price'] > 0 &&
               (!isset($data['quantity']) || is_int($data['quantity']));
    }

    // Génération des réponses HTTP standardisées
    private function responseJson($statusCode, $data) {
        return [
            'status_code_header' => "HTTP/1.1 $statusCode " . $this->getStatusMessage($statusCode),
            'body' => json_encode($data)
        ];
    }

    // Réponse 404 : Ressource non trouvée
    private function notFoundResponse() {
        return $this->responseJson(404, ["message" => "Resource not found"]);
    }

    // Réponse 422 : Données invalides
    private function unprocessableEntityResponse() {
        return $this->responseJson(422, ["message" => "Invalid input"]);
    }

    // Réponse 500 : Erreur serveur
    private function serverErrorResponse() {
        return $this->responseJson(500, ["message" => "Internal server error"]);
    }

    // Correspondance des codes d'état HTTP avec leurs messages
    private function getStatusMessage($code) {
        $statusMessages = [
            200 => "OK",
            201 => "Created",
            404 => "Not Found",
            422 => "Unprocessable Entity",
            500 => "Internal Server Error"
        ];
        return $statusMessages[$code] ?? "Unknown Status";
    }

    public function processRequest():array {
        switch ($this->requestMethod) {
            case "GET":
                if (1==1) {} else {}
                break;
            case "POST":
                break;
            case "PUT":
                if (1==1) {} else {}
                break;
            case "DELETE":
                if (1==1) {}
            
                break;
            default:
               

        }

        return $reponse;

    }
    public function getAllProducts() {
       
    }
    public function getProduct($productId):array{
       
    }

    public function createProductFromRequest() {
  
    }

    public function updateProductFromRequest($id) {
       
    }

    public function deleteProductFromRequest($id) {
    }

}