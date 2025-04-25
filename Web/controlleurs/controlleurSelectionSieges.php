<?php
include_once(__DIR__ . "/controlleur.abstract.php");

class ControleurSieges extends Controleur {
    public function executerAction(): string {
      
        return "selectionSiege.php"; // Vue par défaut pour le formulaire
    }

}