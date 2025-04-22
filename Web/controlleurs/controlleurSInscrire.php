<?php
// filepath: c:\Users\amine\OneDrive\Documents\GitHub\TCH099-Abdian\Web\controlleurs\controlleurSInscrire.php


include_once("controlleurs/controleur.abstract.php");
include_once("modele/dao/UserDAO.php");
include_once("modele/roleClass.php");
include_once("modele/UserClass.php");

class SeInscrire extends Controleur
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

    // ******************* Méthode executerAction
    public function executerAction(): string
    {
        // Vérifiez si le formulaire de création de compte est soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["prenom"])) {
            // Vérifier si l'utilisateur est admin et peut attribuer un rôle
            if ($this->isAdmin() && isset($_POST['role'])) {
                // Si l'utilisateur est admin, utiliser le rôle fourni dans le formulaire
                $role = new Role((int)$_POST['role'], $_POST['roleName'] ?? "Client");
            } else {
                // Sinon, attribuer le rôle "Client" par défaut
                $role = new Role(3, "Client");
            }

            // Création de l'utilisateur
            $nouvelUtilisateur = new Utilisateur(
                $_POST['prenom'],
                $_POST['nom'],
                $_POST['email'],
                $_POST['motDePasse'],
                $_POST['motDePasse'], // Mot de passe en clair pour le hachage
                $_POST['telephone'] ?? ""
            );

            // Associer le rôle à l'utilisateur
            $nouvelUtilisateur->setRole($role);

            // Enregistrer l'utilisateur dans la base de données
            $resultat = UserDAO::inserer($nouvelUtilisateur);

            // Rediriger en fonction du résultat
            if ($resultat) {
                header("Location: ?action=seConnecter&message=Compte créé avec succès !");
                exit;
            } else {
                $this->messagesErreur[] = "Impossible de créer le compte.";
            }
        }

        // Retourner la vue pour la page de création de compte
        return "inscription.php";
    }
}