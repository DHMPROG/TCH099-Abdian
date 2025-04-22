<?php
// filepath: c:\Users\amine\OneDrive\Documents\GitHub\TCH099-Abdian\Web\controlleurs\controlleurRechercheVols.php

include_once("controlleurs/controleur.abstract.php");
include_once("modele/dao/VolDao.php");

class RechercherVols extends Controleur {
    // ******************* Attributs
    private $tabVols;

    // ******************* Constructeur vide
    public function __construct() {
        parent::__construct();
        $this->tabVols = array();
    }

    // ******************* Accesseurs
    public function getTabVols(): array {
        return $this->tabVols;
    }

    // ******************* Méthode executerAction
    public function executerAction(): string {
        // Vérifier si les critères de recherche sont fournis
        if (isset($_POST['departureAirport'], $_POST['arrivalAirport'], $_POST['departureDate'])) {
            $departureAirport = $_POST['departureAirport'];
            $arrivalAirport = $_POST['arrivalAirport'];
            $departureDate = $_POST['departureDate'];

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
        return "rechercheVols.php";
    }
}
?>