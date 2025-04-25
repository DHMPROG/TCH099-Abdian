<?php
// filepath: c:\Users\amine\OneDrive\Documents\GitHub\TCH099-Abdian\Web\controlleurs\controlleurRechercheVols.php
include_once(__DIR__ . "/controlleur.abstract.php");
require_once(__DIR__ . "/../modele/dao/VolDao.php");

class RechercherVols extends Controleur {
    // ******************* Attributs
    private $tabVols;

    // ******************* Constructeur vide
    public function __construct() {
        parent::__construct();
        $this->tabVols = [];
    }

    // ******************* Accesseurs
    public function getTabVols(): array {
        return $this->tabVols;
    }

    // ******************* Méthode executerAction
    public function executerAction(): string {
        // Vérifier si les critères de recherche sont fournis
        if (isset($_GET['depart'], $_GET['arrivee'], $_GET['date_depart'])) {
            $departureAirport = $_GET['depart'];
            $arrivalAirport = $_GET['arrivee'];
            $departureDate = $_GET['date_depart'];

            // Rechercher les vols correspondant aux critères
            $this->tabVols = VolDAO::chercherParAeroportsEtDate($departureAirport, $arrivalAirport, $departureDate);

            // Vérifier si des vols ont été trouvés
            if (empty($this->tabVols)) {
                array_push($this->messagesErreur, "Aucun vol trouvé pour les critères spécifiés.");
            }
        } else {
            array_push($this->messagesErreur, "Veuillez fournir tous les critères de recherche.");
        }

        // Retourner la vue pour afficher les résultats
        return "recherchevols.php";
    }
}
?>