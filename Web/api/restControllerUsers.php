<?php

require_once __DIR__ . '/../modele/dao/UserDAO.php';

class RestControllerUsers {
    private $requestMethod;

    public function __construct($requestMethod) {
        $this->requestMethod = $requestMethod;
    }

    public function processRequest(): array {
        switch ($this->requestMethod) {
            case 'POST':
                $input = json_decode(file_get_contents("php://input"), true);
                $endpoint = $_GET['action'] ?? null;

                if ($endpoint === 'login') {
                    return $this->login($input);
                } elseif ($endpoint === 'register') {
                    return $this->register($input);
                } else {
                    return $this->notFoundResponse();
                }

            default:
                return $this->methodNotAllowedResponse();
        }
    }

    private function login($data): array {
        if (empty($data['email']) || empty($data['motDePasse'])) {
            return $this->unprocessableEntityResponse("Email ou mot de passe manquant.");
        }

        $user = UserDAO::findByEmail($data['email']);
        if ($user && $user->verifyPassword($data['motDePasse'])) {
            return $this->okResponse([
                'message' => 'Connexion réussie',
                'utilisateur' => $user->jsonSerialize()
            ]);
        }

        return $this->unauthorizedResponse("Email ou mot de passe incorrect.");
    }

    private function register($data): array {
        if (UserDAO::existsByEmail($data['email'])) {
            return $this->unprocessableEntityResponse("Email déjà utilisé.");
        }

        $utilisateur = new Utilisateur(
            $data['prenom'],
            $data['nom'],
            $data['email'],
            $data['motDePasse'],
            $data['telephone']
        );

        $utilisateur->hashPassword($data['motDePasse']);
        $success = UserDAO::inserer($utilisateur);

        if ($success) {
            return $this->createdResponse([
                'message' => 'Utilisateur inscrit avec succès',
                'utilisateur' => $utilisateur->jsonSerialize()
            ]);
        }

        return $this->internalErrorResponse("Erreur lors de l'inscription.");
    }

    // Réponses standard
    private function okResponse($body): array {
        return ['status_code_header' => 'HTTP/1.1 200 OK', 'body' => $body];
    }

    private function createdResponse($body): array {
        return ['status_code_header' => 'HTTP/1.1 201 Created', 'body' => $body];
    }

    private function unprocessableEntityResponse($message): array {
        return ['status_code_header' => 'HTTP/1.1 422 Unprocessable Entity', 'body' => ['error' => $message]];
    }

    private function unauthorizedResponse($message): array {
        return ['status_code_header' => 'HTTP/1.1 401 Unauthorized', 'body' => ['error' => $message]];
    }

    private function notFoundResponse(): array {
        return ['status_code_header' => 'HTTP/1.1 404 Not Found', 'body' => ['error' => 'Action non trouvée']];
    }

    private function methodNotAllowedResponse(): array {
        return ['status_code_header' => 'HTTP/1.1 405 Method Not Allowed', 'body' => ['error' => 'Méthode non autorisée']];
    }
    private function internalErrorResponse(string $message): array {
        return [
            'status_code_header' => 'HTTP/1.1 500 Internal Server Error',
            'body' => ['error' => $message]
        ];
    }
}
