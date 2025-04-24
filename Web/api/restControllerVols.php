<?php
include_once __DIR__ . '/../modele/dao/VolDAO.php';
include_once __DIR__ . '/../modele/VolClass.php';

class RestControllerVols {
    private $requestMethod;
    private $idVol;

    public function __construct($requestMethod, $idVol) {
        $this->requestMethod = $requestMethod;
        $this->idVol = $idVol;
    }

    public function processRequest(): array {
        switch ($this->requestMethod) {
            case 'GET':
                if (isset($_GET['depart']) && isset($_GET['arrivee']) && isset($_GET['date'])) {
                    return $this->getVolsParDepartArriveeEtDate($_GET['depart'], $_GET['arrivee'], $_GET['date']);
                }
                elseif (isset($_GET['depart']) && isset($_GET['arrivee'])) {
                    return $this->getVolsParDepartEtArrivee($_GET['depart'], $_GET['arrivee']);
                } 
                elseif ($this->idVol) {
                    return $this->getVol($this->idVol);
                } else {
                    return $this->getAllVols();
                }
            case 'POST':
                return $this->createVolFromRequest();
            case 'PUT':
                if ($this->idVol) {
                    return $this->updateVolFromRequest($this->idVol);
                }
                return $this->unprocessableEntityResponse();
            case 'DELETE':
                if ($this->idVol) {
                    return $this->deleteVolFromRequest($this->idVol);
                }
                return $this->unprocessableEntityResponse();
            default:
                return $this->responseJson(405, ["message" => "Method Not Allowed"]);
        }
    }

    private function getAllVols(): array {
        $vols = VolDAO::chercherTous();
        return $this->responseJson(200, $vols);
    }

    private function getVol($id): array {
        $vol = VolDAO::chercher($id);
        if (!$vol) return $this->notFoundResponse();
        return $this->responseJson(200, $vol);
    }
    private function getVolsParDepartEtArrivee(string $depart, string $arrivee): array {
        $vols = VolDAO::chercherParAeroports($depart, $arrivee);
        if (empty($vols)) {
            return $this->notFoundResponse();
        }
        return $this->responseJson(200, $vols);
    }

    private function getVolsParDepartArriveeEtDate(string $depart, string $arrivee, string $date): array {
        $vols = VolDAO::chercherParAeroportsEtDate($depart, $arrivee, $date);
        if (empty($vols)) {
            return $this->notFoundResponse();
        }
        return $this->responseJson(200, $vols);
    }
    private function createVolFromRequest(): array {
        $data = json_decode(file_get_contents('php://input'), true);
        if (!$this->validateVol($data)) return $this->unprocessableEntityResponse();

        $vol = new Vol(
            $data['id'], $data['airline'], $data['flightNumber'], $data['aircraftModele'],
            $data['departureDate'], $data['departureTime'], $data['departureAirport'], $data['departureCode'],
            $data['arrivalDate'], $data['arrivalTime'], $data['arrivalAirport'], $data['arrivalCode'],
            $data['duration'], $data['stops'], $data['stopDetails'], $data['price']
        );

        $result = VolDAO::inserer($vol);
        return $result ? $this->responseJson(201, ["message" => "Vol created"]) : $this->serverErrorResponse();
    }

    private function updateVolFromRequest($id): array {
        $data = json_decode(file_get_contents('php://input'), true);
        if (!$this->validateVol($data)) return $this->unprocessableEntityResponse();

        $vol = new Vol(
            $id, $data['airline'], $data['flightNumber'], $data['aircraftModele'],
            $data['departureDate'], $data['departureTime'], $data['departureAirport'], $data['departureCode'],
            $data['arrivalDate'], $data['arrivalTime'], $data['arrivalAirport'], $data['arrivalCode'],
            $data['duration'], $data['stops'], $data['stopDetails'], $data['price']
        );

        $result = VolDAO::modifier($vol);
        return $result ? $this->responseJson(200, ["message" => "Vol updated"]) : $this->serverErrorResponse();
    }

    private function deleteVolFromRequest($id): array {
        $result = VolDAO::supprimer($id);
        return $result ? $this->responseJson(200, ["message" => "Vol deleted"]) : $this->serverErrorResponse();
    }

    private function validateVol($data): bool {
        return isset($data['id'], $data['airline'], $data['flightNumber'], $data['aircraftModele'],
            $data['departureDate'], $data['departureTime'], $data['departureAirport'], $data['departureCode'],
            $data['arrivalDate'], $data['arrivalTime'], $data['arrivalAirport'], $data['arrivalCode'],
            $data['duration'], $data['stops'], $data['price']);
    }

    private function responseJson($statusCode, $data): array {
        header('Content-Type: application/json');
        return [
            'status_code_header' => "HTTP/1.1 $statusCode " . $this->getStatusMessage($statusCode),
            'body' => $data
        ];
    }

    private function notFoundResponse(): array {
        return $this->responseJson(404, ["message" => "Vol not found"]);
    }

    private function unprocessableEntityResponse(): array {
        return $this->responseJson(422, ["message" => "Invalid input"]);
    }

    private function serverErrorResponse(): array {
        return $this->responseJson(500, ["message" => "Internal server error"]);
    }

    private function getStatusMessage($code): string {
        $statusMessages = [
            200 => "OK",
            201 => "Created",
            404 => "Not Found",
            405 => "Method Not Allowed",
            422 => "Unprocessable Entity",
            500 => "Internal Server Error"
        ];
        return $statusMessages[$code] ?? "Unknown Status";
    }
}
