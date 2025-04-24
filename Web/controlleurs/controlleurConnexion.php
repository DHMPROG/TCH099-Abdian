<?php
// filepath: c:\Users\amine\OneDrive\Documents\GitHub\TCH099-Abdian\Web\controlleurs\controlleurConnexion.php

include_once(__DIR__ . "/controlleur.abstract.php");
include_once(__DIR__ . "/../modele/dao/UserDAO.php");
class SeConnecter extends Controleur
{
    // ******************* Attributs
    private $tabProduits;

    // ******************* Constructeur vide
    public function __construct()
    {
        parent::__construct();
        $this->tabProduits = array();
    }

    // ******************* Accesseurs
    public function getTabProduits(): array
    {
        return $this->tabProduits;
    }

    // ******************* Méthode exécuter action
    public function executerAction(): string
    {
        // Vérifier si l'utilisateur est déjà connecté
        if ($this->acteur == "utilisateur") {
            array_push($this->messagesErreur, "Vous êtes déjà connecté.");
            return "index.php";
        }

        // Vérifier si les informations POST sont présentes
        if (isset($_POST['email']) && isset($_POST['mot_passe'])) {
            $unUtilisateur = UserDAO::findByEmail($_POST['email']);
            
            // Vérification de l'existence de l'utilisateur
            if ($unUtilisateur == null) {
                array_push($this->messagesErreur, "Cet utilisateur n'existe pas.");
                return "connexion.php";
            }

            // Vérification du mot de passe
            if (!$unUtilisateur->verifyPassword($_POST['mot_passe'])) {
                array_push($this->messagesErreur, "Mot de passe incorrect.");
                return "connexion.php";
            }

            // Connexion réussie
            $this->acteur = "utilisateur";
            $_SESSION['utilisateurConnecte'] = $unUtilisateur;

            return "index.php";
        }

        // Gestion des messages d'erreur via GET
        if (isset($_GET['message'])) {
            $message = htmlspecialchars($_GET['message'], ENT_QUOTES, 'UTF-8');
            echo "<script>alert('$message');</script>";
        }
        
        return "connexion.php";
    }
}