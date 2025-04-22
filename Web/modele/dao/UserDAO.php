<?php

require_once 'ConnexionBD.php';
require_once 'DAO.interface.php';
require_once '../modele/UserClass.php';

class UserDAO implements DAO {

    /**
     * Recherche un utilisateur par ID
     * @param string $id
     * @return Utilisateur|null
     */
    static public function chercher(string $id): ?Utilisateur {
        try {
            $connexion = ConnexionBD::getInstance();
        } catch (Exception $e) {
            throw new Exception("Impossible d'obtenir la connexion à la BD");
        }

        $user = null;
        $requete = $connexion->prepare(
            "SELECT * FROM Utilisateur WHERE id = :id"
        );
        $requete->bindParam(':id', $id, PDO::PARAM_INT);
        $requete->execute();

        if ($requete->rowCount() != 0) {
            $enr = $requete->fetch();
            $user = new Utilisateur(
                $enr['prenom'],
                $enr['nom'],
                $enr['email'],
                $enr['motDePasse'],
                $enr['motDePasse'], // Assuming motDePasseEnClair is not stored in DB
                $enr['telephone']
            );
            $user->setId($enr['id']);
        }

        $requete->closeCursor();
        ConnexionBD::close();

        return $user;
    }

    /**
     * Retourne tous les utilisateurs
     * @return array
     */
    static public function chercherTous(): array {
        try {
            $connexion = ConnexionBD::getInstance();
        } catch (Exception $e) {
            throw new Exception("Impossible d'obtenir la connexion à la BD");
        }

        $users = [];
        $requete = $connexion->prepare("SELECT * FROM Utilisateur");
        $requete->execute();

        foreach ($requete as $enr) {
            $user = new Utilisateur(
                $enr['prenom'],
                $enr['nom'],
                $enr['email'],
                $enr['motDePasse'],
                $enr['motDePasse'], // Assuming motDePasseEnClair is not stored in DB
                $enr['telephone']
            );
            $user->setId($enr['id']);
            $users[] = $user;
        }

        $requete->closeCursor();
        ConnexionBD::close();

        return $users;
    }

    /**
     * Retourne les utilisateurs correspondant à un filtre
     * @param string $filtre
     * @return array
     */
    static public function chercherAvecFiltre(string $filtre): array {
        try {
            $connexion = ConnexionBD::getInstance();
        } catch (Exception $e) {
            throw new Exception("Impossible d'obtenir la connexion à la BD");
        }

        $users = [];
        $requete = $connexion->prepare(
            "SELECT * FROM Utilisateur WHERE nom LIKE :filtre OR prenom LIKE :filtre"
        );
        $filtre = "%$filtre%";
        $requete->bindParam(':filtre', $filtre, PDO::PARAM_STR);
        $requete->execute();

        foreach ($requete as $enr) {
            $user = new Utilisateur(
                $enr['prenom'],
                $enr['nom'],
                $enr['email'],
                $enr['motDePasse'],
                $enr['motDePasse'], // Assuming motDePasseEnClair is not stored in DB
                $enr['telephone']
            );
            $user->setId($enr['id']);
            $users[] = $user;
        }

        $requete->closeCursor();
        ConnexionBD::close();

        return $users;
    }

    /**
     * Insère un nouvel utilisateur dans la base de données
     * @param object $objet
     * @return bool
     */
    static public function inserer(object $objet): bool {
        try {
            $connexion = ConnexionBD::getInstance();
        } catch (Exception $e) {
            throw new Exception("Impossible d'obtenir la connexion à la BD");
        }

        $requete = $connexion->prepare(
            "INSERT INTO Utilisateur (prenom, nom, email, motDePasse, telephone, dateInscription) 
             VALUES (:prenom, :nom, :email, :motDePasse, :telephone, :dateInscription)"
        );

        $requete->bindParam(':prenom', $objet->getPrenom(), PDO::PARAM_STR);
        $requete->bindParam(':nom', $objet->getNom(), PDO::PARAM_STR);
        $requete->bindParam(':email', $objet->getEmail(), PDO::PARAM_STR);
        $requete->bindParam(':motDePasse', $objet->getMotDePasse(), PDO::PARAM_STR);
        $requete->bindParam(':telephone', $objet->getTelephone(), PDO::PARAM_STR);
        $requete->bindParam(':dateInscription', $objet->getDateInscription()->format('Y-m-d H:i:s'), PDO::PARAM_STR);

        $success = $requete->execute();
        if ($success) {
            $objet->setId((int)$connexion->lastInsertId());
        }

        return $success;
    }

    /**
     * Met à jour un utilisateur existant
     * @param object $objet
     * @return bool
     */
    static public function modifier(object $objet): bool {
        try {
            $connexion = ConnexionBD::getInstance();
        } catch (Exception $e) {
            throw new Exception("Impossible d'obtenir la connexion à la BD");
        }

        $requete = $connexion->prepare(
            "UPDATE Utilisateur 
             SET prenom = :prenom, nom = :nom, email = :email, 
                 motDePasse = :motDePasse, telephone = :telephone 
             WHERE id = :id"
        );

        $requete->bindParam(':id', $objet->getId(), PDO::PARAM_INT);
        $requete->bindParam(':prenom', $objet->getPrenom(), PDO::PARAM_STR);
        $requete->bindParam(':nom', $objet->getNom(), PDO::PARAM_STR);
        $requete->bindParam(':email', $objet->getEmail(), PDO::PARAM_STR);
        $requete->bindParam(':motDePasse', $objet->getMotDePasse(), PDO::PARAM_STR);
        $requete->bindParam(':telephone', $objet->getTelephone(), PDO::PARAM_STR);

        return $requete->execute();
    }

    /**
     * Supprime un utilisateur de la base de données
     * @param object $objet
     * @return bool
     */
    static public function supprimer(object $objet): bool {
        try {
            $connexion = ConnexionBD::getInstance();
        } catch (Exception $e) {
            throw new Exception("Impossible d'obtenir la connexion à la BD");
        }

        $requete = $connexion->prepare("DELETE FROM Utilisateur WHERE id = :id");
        $requete->bindParam(':id', $objet->getId(), PDO::PARAM_INT);

        return $requete->execute();
    }
}