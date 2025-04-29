<?php

require_once __DIR__ . '/connexionBD.class.php';
require_once __DIR__ . '/DAO.interface.php';
require_once __DIR__ . '/../passagerClass.php';

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
            $passager = Passager::withIds(
                $enr['id'],
                $enr['id_utilisateur'],
                $enr['prenom'],
                $enr['deuxieme_prenom'],
                $enr['nom'],
                $enr['date_naissance'],
                $enr['email'],
                $enr['telephone']
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
            $passager = Passager::withIds(
                $enr['id'],
                $enr['id_utilisateur'],
                $enr['prenom'],
                $enr['deuxieme_prenom'],
                $enr['nom'],
                $enr['date_naissance'],
                $enr['email'],
                $enr['telephone']
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
            $passager = Passager::withIds(
                $enr['id'],
                $enr['id_utilisateur'],
                $enr['prenom'],
                $enr['deuxieme_prenom'],
                $enr['nom'],
                $enr['date_naissance'],
                $enr['email'],
                $enr['telephone']
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
            "INSERT INTO Passager (id_utilisateur, prenom, deuxieme_prenom, nom, date_naissance, email, telephone) 
             VALUES (:id_utilisateur, :prenom, :deuxieme_prenom, :nom, :date_naissance, :email, :telephone)"
        );

        $idUtilisateur = $objet->getIdUtilisateur();
        $prenom = $objet->getPrenom();
        $deuxiemePrenom = $objet->getDeuxiemePrenom();
        $nom = $objet->getNom();
        $dateNaissance = $objet->getDateNaissance();
        $email = $objet->getEmail();
        $telephone = $objet->getTelephone();

        $requete->bindParam(':id_utilisateur', $idUtilisateur, PDO::PARAM_INT);
        $requete->bindParam(':prenom', $prenom, PDO::PARAM_STR);
        $requete->bindParam(':deuxieme_prenom', $deuxiemePrenom, PDO::PARAM_STR);
        $requete->bindParam(':nom', $nom, PDO::PARAM_STR);
        $requete->bindParam(':date_naissance', $dateNaissance, PDO::PARAM_STR);
        $requete->bindParam(':email', $email, PDO::PARAM_STR);
        $requete->bindParam(':telephone', $telephone, PDO::PARAM_STR);

        $success = $requete->execute();
        if ($success) {
            $objet->setId((int)$connexion->lastInsertId());
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
                 nom = :nom, date_naissance = :date_naissance, email = :email, telephone = :telephone 
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
