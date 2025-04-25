<?php
// filepath: c:\Users\amine\OneDrive\Documents\GitHub\TCH099-Abdian\Web\controlleurs\controleurManufacture.class.php
include_once(__DIR__ . "/controlleur.abstract.php");
include_once(__DIR__ . "/controlleurAcceuil.php");
include_once(__DIR__ . "/controlleurRechercheVols.php");
include_once(__DIR__ . "/controlleurConnexion.php");
include_once(__DIR__ . "/controlleurSInscrire.php");
include_once(__DIR__ . "/controlleurContact.php");
include_once(__DIR__ . "/controlleurDestinations.php");


class ManufactureControleur {
    /**
     * Crée une instance du contrôleur approprié en fonction de l'action
     * @param string $action
     * @return Controleur
     * @throws Exception
     */
    public static function creerControleur(string $action): Controleur {
        switch ($action) {
            case "rechercherVols": return new RechercherVols();
            case "seConnecter": return new SeConnecter();
            case "seInscrire": return new SeInscrire();
            case "accueil": return new ControleurAccueil();
            case "": return new ControleurAccueil();
            case "contact": return new ControleurContact();
            case "destinations": return new ControleurDestinations();
            default: throw new Exception("Action inconnue : " . $action);
        }
    }
}
?>