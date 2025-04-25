<?php

require_once 'connexionBD.class.php';
require_once 'DAO.interface.php';
require_once(__DIR__ . "/../UserClass.php");

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

        $requete = $connexion->prepare(
            "SELECT * FROM Utilisateur WHERE id = :id"
        );
        $requete->bindParam(':id', $id, PDO::PARAM_INT);
        $requete->execute();

        $user = null;
        if ($requete->rowCount() !== 0) {
            $enr = $requete->fetch();
            // On passe directement le hash stocké en base
            $user = new Utilisateur(
                $enr['prenom'],
                $enr['nom'],
                $enr['email'],
                $enr['mot_de_passe'],
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
     * @return Utilisateur[]
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
                $enr['mot_de_passe'],
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
     * @return Utilisateur[]
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
        $like = "%{$filtre}%";
        $requete->bindParam(':filtre', $like, PDO::PARAM_STR);
        $requete->execute();

        foreach ($requete as $enr) {
            $user = new Utilisateur(
                $enr['prenom'],
                $enr['nom'],
                $enr['email'],
                $enr['mot_de_passe'],
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
     * @param Utilisateur $objet
     * @return bool
     */
    static public function inserer(object $objet): bool {
        try {
            $connexion = ConnexionBD::getInstance();
        } catch (Exception $e) {
            throw new Exception("Impossible d'obtenir la connexion à la BD");
        }

        // 1) On hash le mot de passe clair
        $hash = $objet->hashPassword($objet->getMotDePasse());

        $requete = $connexion->prepare(
            "INSERT INTO Utilisateur 
                (prenom, nom, email, mot_de_passe, telephone, date_inscription) 
             VALUES 
                (:prenom, :nom, :email, :mot_de_passe, :telephone, :date_inscription)"
        );
        $requete->bindValue(':prenom',          $objet->getPrenom(), PDO::PARAM_STR);
        $requete->bindValue(':nom',             $objet->getNom(),    PDO::PARAM_STR);
        $requete->bindValue(':email',           $objet->getEmail(),  PDO::PARAM_STR);
        $requete->bindValue(':mot_de_passe',    $hash,               PDO::PARAM_STR);
        $requete->bindValue(':telephone',       $objet->getTelephone(), PDO::PARAM_STR);
        $requete->bindValue(
            ':date_inscription', 
            $objet->getDateInscription()->format('Y-m-d H:i:s'),
            PDO::PARAM_STR
        );

        $success = $requete->execute();
        if ($success) {
            // MAJ de l'objet avec l'ID et le hash
            $objet->setId((int)$connexion->lastInsertId());
            $objet->setMotDePasse($hash);
        }

        return $success;
    }

    /**
     * Met à jour un utilisateur existant
     * @param Utilisateur $objet
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
             SET prenom = :prenom, 
                 nom    = :nom, 
                 email  = :email, 
                 mot_de_passe = :mot_de_passe, 
                 telephone    = :telephone 
             WHERE id = :id"
        );
        $requete->bindValue(':id',            $objet->getId(),       PDO::PARAM_INT);
        $requete->bindValue(':prenom',        $objet->getPrenom(),   PDO::PARAM_STR);
        $requete->bindValue(':nom',           $objet->getNom(),      PDO::PARAM_STR);
        $requete->bindValue(':email',         $objet->getEmail(),    PDO::PARAM_STR);
        $requete->bindValue(':mot_de_passe',  $objet->getMotDePasse(), PDO::PARAM_STR);
        $requete->bindValue(':telephone',     $objet->getTelephone(), PDO::PARAM_STR);

        return $requete->execute();
    }

    /**
     * Supprime un utilisateur de la base de données
     * @param Utilisateur $objet
     * @return bool
     */
    static public function supprimer(object $objet): bool {
        try {
            $connexion = ConnexionBD::getInstance();
        } catch (Exception $e) {
            throw new Exception("Impossible d'obtenir la connexion à la BD");
        }

        $requete = $connexion->prepare(
            "DELETE FROM Utilisateur WHERE id = :id"
        );
        $requete->bindValue(':id', $objet->getId(), PDO::PARAM_INT);
        return $requete->execute();
    }

    /**
     * Recherche un utilisateur par email
     * @param string $email
     * @return Utilisateur|null
     */
    static public function findByEmail(string $email): ?Utilisateur {
        try {
            $connexion = ConnexionBD::getInstance();
        } catch (Exception $e) {
            throw new Exception("Impossible d'obtenir la connexion à la BD");
        }

        $requete = $connexion->prepare(
            "SELECT * FROM Utilisateur WHERE email = :email"
        );
        $requete->bindValue(':email', $email, PDO::PARAM_STR);
        $requete->execute();

        if ($requete->rowCount() !== 0) {
            $enr = $requete->fetch();
            $user = new Utilisateur(
                $enr['prenom'],
                $enr['nom'],
                $enr['email'],
                $enr['mot_de_passe'],
                $enr['telephone']
            );
            $user->setId($enr['id']);
            return $user;
        }

        return null;
    }

    /**
     * Vérifie si un utilisateur existe par email
     * @param string $email
     * @return bool
     */
    static public function existsByEmail(string $email): bool {
        try {
            $connexion = ConnexionBD::getInstance();
        } catch (Exception $e) {
            throw new Exception("Impossible d'obtenir la connexion à la BD");
        }

        $requete = $connexion->prepare(
            "SELECT COUNT(*) as count FROM Utilisateur WHERE email = :email"
        );
        $requete->bindParam(':email', $email, PDO::PARAM_STR);
        $requete->execute();

        $result = $requete->fetch();
        return $result['count'] > 0;
    }
}
