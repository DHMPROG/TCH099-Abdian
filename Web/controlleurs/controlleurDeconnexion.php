<?php
// filepath: controlleurs/controlleurDeconnexion.php

include_once(__DIR__ . "/controlleur.abstract.php");

class SeDeconnecter extends Controleur
{
    public function __construct()
    {
        parent::__construct();
    }

    public function executerAction(): string
    {
        // Démarre la session si besoin
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        // Détruit toutes les données de session
        $_SESSION = [];
        session_destroy();


        // Retourner la vue d'accueil (ou celle que tu souhaites)
        return "accueil.php";
    }
}
