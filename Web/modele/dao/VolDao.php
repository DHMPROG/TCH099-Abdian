<?php

// DAO pour la classe Vol de la BD (a developper)
// Import de l'interface DAO et la classe Vol
include_once "DAO.interface.php";
include_once __DIR__ . "/../VolClass.php";
// __DIR__ retourne le chemin absolu du dossier contenant ce fichier, évitant les erreurs de chemins relatifs.
 
// L'utilisation de __DIR__ garantit que l'inclusion fonctionne indépendamment du répertoire courant du script exécuté.

// ************ CLASSE *******************
class VolDAO implements DAO {
	// Cette méthode doit retourner l'objet dont la clé primaire a été passée en paramètre
    // Notes: 1) On retourne null si non trouvé
    //        2) Si la clé primaire est composée, alors le paramètre est un tableau associatif
    // ici la seule $cles est un int représentant le code du vol

    public static function chercher(string $cles): Vol|null {
        // Obtenir connexion
        try {
            $connexion = ConnexionBD::getInstance();
        } catch(Exception $e) {
            throw new Exception("Impossible d'obtenir la connexion à la BD");
        }

        $unVol = null;

        $requete = $connexion->prepare("SELECT * FROM Vol where id = ?");
        $requete->execute(array($cles));

        if ($requete->rowCount() != 0) {
            $enr = $requete->fetch();
            // à l'intérieur de enr, nom des colonnes SQL
            $unVol = new Vol($enr["id"], $enr["airline"], 
            $enr["flightNumber"], $enr["aircraftModele"], 
            $enr["departureDate"], $enr["departureTime"], 
            $enr["departureAirport"], $enr["departureCode"], 
            $enr["arrivalDate"], $enr["arrivalTime"], 
            $enr["arrivalAirport"], $enr["arrivalCode"], 
            $enr["duration"], $enr["stops"], 
            $enr["stopDetails"], $enr["price"]
            );
        }

        $requete->closeCursor();
        ConnexionBD::close();
        return $unVol;
    }

    public static function chercherTous(): array {
        return self::chercherAvecFiltre("");
    }

    public static function chercherParAeroports(string $departureAirport, string $arrivalAirport): array {
        try {
            $connexion = ConnexionBD::getInstance();
        } catch (Exception $e) {
            throw new Exception("Impossible d'obtenir la connexion à la BD");
        }

        $tableau = [];

        $requete = $connexion->prepare("SELECT * FROM Vol WHERE departureAirport = ? AND arrivalAirport = ?");
        $requete->execute([$departureAirport, $arrivalAirport]);

        foreach ($requete as $enr) {
            $unVol = new Vol($enr["id"], $enr["airline"], 
            $enr["flightNumber"], $enr["aircraftModele"], 
            $enr["departureDate"], $enr["departureTime"], 
            $enr["departureAirport"], $enr["departureCode"], 
            $enr["arrivalDate"], $enr["arrivalTime"], 
            $enr["arrivalAirport"], $enr["arrivalCode"], 
            $enr["duration"], $enr["stops"], 
            $enr["stopDetails"], $enr["price"]
            );

            array_push($tableau, $unVol);
        }

        $requete->closeCursor();
        ConnexionBD::close();
        return $tableau;
    }

    public static function chercherAvecFiltre(string $filtre): array {
        try {
            $connexion = ConnexionBD::getInstance();
        } catch (Exception $e) {
            throw new Exception("Impossible d'obtenir la connexion à la BD");
        }

        $tableau = [];

        $requete = $connexion->prepare("SELECT * FROM Vol" . $filtre);
        $requete->execute();

        foreach($requete as $enr) {
            $unVol = new Vol($enr["id"], $enr["airline"], 
            $enr["flightNumber"], $enr["aircraftModele"], 
            $enr["departureDate"], $enr["departureTime"], 
            $enr["departureAirport"], $enr["departureCode"], 
            $enr["arrivalDate"], $enr["arrivalTime"], 
            $enr["arrivalAirport"], $enr["arrivalCode"], 
            $enr["duration"], $enr["stops"], 
            $enr["stopDetails"], $enr["price"]
            );

            array_push($tableau, $unVol);
        }

        $requete->closeCursor();
        ConnexionBD::close();
        return $tableau;
    }
    public static function inserer(object $unVol): bool {
        try {
            $connexion = ConnexionBD::getInstance();
        } catch (Exception $e) {
            throw new Exception("Impossible d'obtenir la connexion à la BD");
        }

        $requete = $connexion->prepare("INSERT INTO Vol VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $tableauInfos = [
            $unVol->getId(), 
            $unVol->getAirline(), 
            $unVol->getFlightNumber(), 
            $unVol->getAircraftModel(), 
            $unVol->getDepartureDate(), 
            $unVol->getDepartureTime(), 
            $unVol->getDepartureAirport(), 
            $unVol->getDepartureCode(), 
            $unVol->getArrivalDate(), 
            $unVol->getArrivalTime(), 
            $unVol->getArrivalAirport(), 
            $unVol->getArrivalCode(), 
            $unVol->getDuration(), 
            $unVol->getStops(), 
            $unVol->getStopDetails(), 
            $unVol->getPrice()
        ];

        $resultat = $requete->execute($tableauInfos);
        $requete->closeCursor();
        ConnexionBD::close();
        return $resultat;
    }
    public static function modifier(object $unVol): bool {
        try {
            $connexion = ConnexionBD::getInstance();
        } catch (Exception $e) {
            throw new Exception("Impossible d'obtenir la connexion à la BD");
        }

        $requete = $connexion->prepare("UPDATE Vol SET airline = ?, flightNumber = ?, aircraftModele = ?, departureDate = ?, departureTime = ?, departureAirport = ?, departureCode = ?, arrivalDate = ?, arrivalTime = ?, arrivalAirport = ?, arrivalCode = ?, duration = ?, stops = ?, stopDetails = ?, price = ? WHERE id = ?");

        $tableauInfos = [
            $unVol->getAirline(),
            $unVol->getFlightNumber(),
            $unVol->getAircraftModel(),
            $unVol->getDepartureDate(),
            $unVol->getDepartureTime(),
            $unVol->getDepartureAirport(),
            $unVol->getDepartureCode(),
            $unVol->getArrivalDate(),
            $unVol->getArrivalTime(),
            $unVol->getArrivalAirport(),
            $unVol->getArrivalCode(),
            $unVol->getDuration(),
            $unVol->getStops(),
            $unVol->getStopDetails(),
            $unVol->getPrice(),
            $unVol->getId()
        ];

        $resultat = $requete->execute($tableauInfos);
        $requete->closeCursor();
        ConnexionBD::close();
        return $resultat;
    }

    public static function supprimer(mixed $cles): bool {
        try {
            $connexion = ConnexionBD::getInstance();
        } catch (Exception $e) {
            throw new Exception("Impossible d'obtenir la connexion à la BD");
        }

        $requete = $connexion->prepare("DELETE FROM Vol WHERE id = ?");
        $resultat = $requete->execute([$cles]);
        $requete->closeCursor();
        ConnexionBD::close();
        return $resultat;
    }
}