<?php
// filepath: c:\Users\amine\OneDrive\Documents\GitHub\TCH099-Abdian\Web\controlleurs\controlleurAccueil.php

include_once __DIR__ . "/controlleur.abstract.php";

class ControleurAccueil extends Controleur {
    public function executerAction(): string {
        // Logique pour la page d'accueil (si nécessaire)
        return "accueil.php"; // Vue par défaut pour l'accueil
    }
}
?>