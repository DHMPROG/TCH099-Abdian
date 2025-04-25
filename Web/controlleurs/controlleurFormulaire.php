<?php
include_once(__DIR__ . "/controlleur.abstract.php");

class ControleurFormulaire extends Controleur {
    public function executerAction(): string {
        /* Logique pour le traitement du formulaire
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $this->traiterFormulaire();
        }
            */
        return "formulaireVoyageur.php"; // Vue par défaut pour le formulaire
    }

    /*
    private function traiterFormulaire(): void {
        // Logique pour traiter le formulaire soumis
        // Par exemple, valider les données et les enregistrer dans la base de données
    }
        */
}