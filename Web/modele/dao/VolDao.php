<?php

// DAO pour la classe Vol de la BD (a developper)
// Import de l'interface DAO et la classe Vol
include_once("DAO.interface.php");
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

        $requete = $connexion->prepare("SELECT * FROM ")
    }
}