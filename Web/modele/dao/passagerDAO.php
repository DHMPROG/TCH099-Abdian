<?php

require_once 'ConnexionBD.php';
require_once 'DAO.interface.php';
require_once '../modele/passagerClass.php';

class PassagerDAO implements DAO {

    /**
     * Recherche un passager par ID
     * @param string $id
     * @return Passager|null
     */
    static public function chercher(string $id): ?Passager {
        try {
            $connexion = ConnexionBD::getInstance();
        } catch (Exception $e) {
            throw new Exception("Impossible d'obtenir la connexion à la BD");
        }

        $passager = null;
        $requete = $connexion->prepare(
            "SELECT * FROM Passager WHERE id = :id"
        );
        $requete->bindParam(':id', $id, PDO::PARAM_INT);
        $requete->execute();

        if ($requete->rowCount() != 0) {
            $enr = $requete->fetch();
            $passager = new Passager(
                $enr['id'],
                $enr['id_utilisateur'],
                $enr['prenom'],
                $enr['deuxieme_prenom'],
                $enr['nom'],
                $enr['date_naissance'],
                $enr['email'],
                $enr['telephone'],
                $enr['urgence_prenom'],
                $enr['urgence_nom'],
                $enr['urgence_email'],
                $enr['urgence_telephone']
            );
        }

        $requete->closeCursor();
        ConnexionBD::close();

        return $passager;
    }

    /**
     * Retourne tous les passagers
     * @return array
     */
    static public function chercherTous(): array {
        try {
            $connexion = ConnexionBD::getInstance();
        } catch (Exception $e) {
            throw new Exception("Impossible d'obtenir la connexion à la BD");
        }

        $passagers = [];
        $requete = $connexion->prepare("SELECT * FROM Passager");
        $requete->execute();

        foreach ($requete as $enr) {
            $passager = new Passager(
                $enr['id'],
                $enr['id_utilisateur'],
                $enr['prenom'],
                $enr['deuxieme_prenom'],
                $enr['nom'],
                $enr['date_naissance'],
                $enr['email'],
                $enr['telephone'],
                $enr['urgence_prenom'],
                $enr['urgence_nom'],
                $enr['urgence_email'],
                $enr['urgence_telephone']
            );
            $passagers[] = $passager;
        }

        $requete->closeCursor();
        ConnexionBD::close();

        return $passagers;
    }

    /**
     * Retourne les passagers correspondant à un filtre
     * @param string $filtre
     * @return array
     */
    static public function chercherAvecFiltre(string $filtre): array {
        try {
            $connexion = ConnexionBD::getInstance();
        } catch (Exception $e) {
            throw new Exception("Impossible d'obtenir la connexion à la BD");
        }

        $passagers = [];
        $requete = $connexion->prepare(
            "SELECT * FROM Passager WHERE nom LIKE :filtre OR prenom LIKE :filtre"
        );
        $filtre = "%$filtre%";
        $requete->bindParam(':filtre', $filtre, PDO::PARAM_STR);
        $requete->execute();

        foreach ($requete as $enr) {
            $passager = new Passager(
                $enr['id'],
                $enr['id_utilisateur'],
                $enr['prenom'],
                $enr['deuxieme_prenom'],
                $enr['nom'],
                $enr['date_naissance'],
                $enr['email'],
                $enr['telephone'],
                $enr['urgence_prenom'],
                $enr['urgence_nom'],
                $enr['urgence_email'],
                $enr['urgence_telephone']
            );
            $passagers[] = $passager;
        }

        $requete->closeCursor();
        ConnexionBD::close();

        return $passagers;
    }

    /**
     * Insère un nouveau passager dans la base de données
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
            "INSERT INTO Passager (id_utilisateur, prenom, deuxieme_prenom, nom, date_naissance, email, telephone, urgence_prenom, urgence_nom, urgence_email, urgence_telephone) 
             VALUES (:id_utilisateur, :prenom, :deuxieme_prenom, :nom, :date_naissance, :email, :telephone, :urgence_prenom, :urgence_nom, :urgence_email, :urgence_telephone)"
        );

        $requete->bindParam(':id_utilisateur', $objet->getIdUtilisateur(), PDO::PARAM_INT);
        $requete->bindParam(':prenom', $objet->getPrenom(), PDO::PARAM_STR);
        $requete->bindParam(':deuxieme_prenom', $objet->getDeuxiemePrenom(), PDO::PARAM_STR);
        $requete->bindParam(':nom', $objet->getNom(), PDO::PARAM_STR);
        $requete->bindParam(':date_naissance', $objet->getDateNaissance(), PDO::PARAM_STR);
        $requete->bindParam(':email', $objet->getEmail(), PDO::PARAM_STR);
        $requete->bindParam(':telephone', $objet->getTelephone(), PDO::PARAM_STR);
        $requete->bindParam(':urgence_prenom', $objet->getUrgencePrenom(), PDO::PARAM_STR);
        $requete->bindParam(':urgence_nom', $objet->getUrgenceNom(), PDO::PARAM_STR);
        $requete->bindParam(':urgence_email', $objet->getUrgenceEmail(), PDO::PARAM_STR);
        $requete->bindParam(':urgence_telephone', $objet->getUrgenceTelephone(), PDO::PARAM_STR);

        $success = $requete->execute();
        if ($success) {
            $objet->id = (int)$connexion->lastInsertId();
        }

        return $success;
    }

    /**
     * Met à jour un passager existant
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
            "UPDATE Passager 
             SET id_utilisateur = :id_utilisateur, prenom = :prenom, deuxieme_prenom = :deuxieme_prenom, 
                 nom = :nom, date_naissance = :date_naissance, email = :email, telephone = :telephone, 
                 urgence_prenom = :urgence_prenom, urgence_nom = :urgence_nom, urgence_email = :urgence_email, 
                 urgence_telephone = :urgence_telephone 
             WHERE id = :id"
        );

        $requete->bindParam(':id', $objet->getId(), PDO::PARAM_INT);
        $requete->bindParam(':id_utilisateur', $objet->getIdUtilisateur(), PDO::PARAM_INT);
        $requete->bindParam(':prenom', $objet->getPrenom(), PDO::PARAM_STR);
        $requete->bindParam(':deuxieme_prenom', $objet->getDeuxiemePrenom(), PDO::PARAM_STR);
        $requete->bindParam(':nom', $objet->getNom(), PDO::PARAM_STR);
        $requete->bindParam(':date_naissance', $objet->getDateNaissance(), PDO::PARAM_STR);
        $requete->bindParam(':email', $objet->getEmail(), PDO::PARAM_STR);
        $requete->bindParam(':telephone', $objet->getTelephone(), PDO::PARAM_STR);
        $requete->bindParam(':urgence_prenom', $objet->getUrgencePrenom(), PDO::PARAM_STR);
        $requete->bindParam(':urgence_nom', $objet->getUrgenceNom(), PDO::PARAM_STR);
        $requete->bindParam(':urgence_email', $objet->getUrgenceEmail(), PDO::PARAM_STR);
        $requete->bindParam(':urgence_telephone', $objet->getUrgenceTelephone(), PDO::PARAM_STR);

        return $requete->execute();
    }

    /**
     * Supprime un passager de la base de données
     * @param object $objet
     * @return bool
     */
    static public function supprimer(object $objet): bool {
        try {
            $connexion = ConnexionBD::getInstance();
        } catch (Exception $e) {
            throw new Exception("Impossible d'obtenir la connexion à la BD");
        }

        $requete = $connexion->prepare("DELETE FROM Passager WHERE id = :id");
        $requete->bindParam(':id', $objet->getId(), PDO::PARAM_INT);

        return $requete->execute();
    }
}