<?php
include_once __DIR__ . "/controlleur.abstract.php";

class ControleurDestinations extends Controleur {
    public function executerAction(): string {
        // Logique pour la page des destinations (si nécessaire)
        return "destinations.php"; // Vue par défaut pour les destinations
    }
}