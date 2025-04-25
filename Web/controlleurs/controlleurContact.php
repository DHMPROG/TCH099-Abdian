<?php
include_once __DIR__ . "/controlleur.abstract.php";

class ControleurContact extends Controleur {
    public function executerAction(): string {
        // Logique pour la page de contact (si nécessaire)
        return "contact.php"; // Vue par défaut pour le contact
    }
}