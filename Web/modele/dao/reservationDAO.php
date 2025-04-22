<?php

require_once 'ConnexionBD.php';
require_once 'DAO.interface.php';
require_once '../modele/reservationClass.php';

class ReservationDAO implements DAO {

    /**
     * Recherche une réservation par ID
     * @param string $id
     * @return Reservation|null
     */
    static public function chercher(string $id): ?Reservation {
        try {
            $connexion = ConnexionBD::getInstance();
        } catch (Exception $e) {
            throw new Exception("Impossible d'obtenir la connexion à la BD");
        }

        $reservation = null;
        $requete = $connexion->prepare(
            "SELECT * FROM Reservation WHERE id = :id"
        );
        $requete->bindParam(':id', $id, PDO::PARAM_INT);
        $requete->execute();

        if ($requete->rowCount() != 0) {
            $enr = $requete->fetch();
            $reservation = new Reservation(
                $enr['id_passager'],
                $enr['id_vol'],
                $enr['id_siege'],
                $enr['statut']
            );
            $reservation->setId($enr['id']);
        }

        $requete->closeCursor();
        ConnexionBD::close();

        return $reservation;
    }

    /**
     * Retourne toutes les réservations
     * @return array
     */
    static public function chercherTous(): array {
        try {
            $connexion = ConnexionBD::getInstance();
        } catch (Exception $e) {
            throw new Exception("Impossible d'obtenir la connexion à la BD");
        }

        $reservations = [];
        $requete = $connexion->prepare("SELECT * FROM Reservation");
        $requete->execute();

        foreach ($requete as $enr) {
            $reservation = new Reservation(
                $enr['id_passager'],
                $enr['id_vol'],
                $enr['id_siege'],
                $enr['statut']
            );
            $reservation->id = $enr['id'];
            $reservations[] = $reservation;
        }

        $requete->closeCursor();
        ConnexionBD::close();

        return $reservations;
    }

    /**
     * Retourne les réservations correspondant à un filtre
     * @param string $filtre
     * @return array
     */
    static public function chercherAvecFiltre(string $filtre): array {
        try {
            $connexion = ConnexionBD::getInstance();
        } catch (Exception $e) {
            throw new Exception("Impossible d'obtenir la connexion à la BD");
        }

        $reservations = [];
        $requete = $connexion->prepare(
            "SELECT * FROM Reservation WHERE statut LIKE :filtre"
        );
        $filtre = "%$filtre%";
        $requete->bindParam(':filtre', $filtre, PDO::PARAM_STR);
        $requete->execute();

        foreach ($requete as $enr) {
            $reservation = new Reservation(
                $enr['id_passager'],
                $enr['id_vol'],
                $enr['id_siege'],
                $enr['statut']
            );
            $reservation->id = $enr['id'];
            $reservations[] = $reservation;
        }

        $requete->closeCursor();
        ConnexionBD::close();

        return $reservations;
    }

    /**
     * Insère une nouvelle réservation dans la base de données
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
            "INSERT INTO Reservation (id_passager, id_vol, id_siege, date_reservation, statut) 
             VALUES (:id_passager, :id_vol, :id_siege, :date_reservation, :statut)"
        );

        $requete->bindParam(':id_passager', $objet->getIdPassager(), PDO::PARAM_INT);
        $requete->bindParam(':id_vol', $objet->getIdVol(), PDO::PARAM_INT);
        $requete->bindParam(':id_siege', $objet->getIdSiege(), PDO::PARAM_INT);
        $requete->bindParam(':date_reservation', $objet->getDateReservation(), PDO::PARAM_STR);
        $requete->bindParam(':statut', $objet->getStatut(), PDO::PARAM_STR);

        $success = $requete->execute();
        if ($success) {
            $objet->id = (int)$connexion->lastInsertId();
        }

        return $success;
    }

    /**
     * Met à jour une réservation existante
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
            "UPDATE Reservation 
             SET id_passager = :id_passager, id_vol = :id_vol, id_siege = :id_siege, 
                 statut = :statut 
             WHERE id = :id"
        );

        $requete->bindParam(':id', $objet->getId(), PDO::PARAM_INT);
        $requete->bindParam(':id_passager', $objet->getIdPassager(), PDO::PARAM_INT);
        $requete->bindParam(':id_vol', $objet->getIdVol(), PDO::PARAM_INT);
        $requete->bindParam(':id_siege', $objet->getIdSiege(), PDO::PARAM_INT);
        $requete->bindParam(':statut', $objet->getStatut(), PDO::PARAM_STR);

        return $requete->execute();
    }

    /**
     * Supprime une réservation de la base de données
     * @param object $objet
     * @return bool
     */
    static public function supprimer(object $objet): bool {
        try {
            $connexion = ConnexionBD::getInstance();
        } catch (Exception $e) {
            throw new Exception("Impossible d'obtenir la connexion à la BD");
        }

        $requete = $connexion->prepare("DELETE FROM Reservation WHERE id = :id");
        $requete->bindParam(':id', $objet->getId(), PDO::PARAM_INT);

        return $requete->execute();
    }
}