<?php

// Classe qui gère la connexion à la base de données

// ************ INCLUSIONS ************

// configBD.interface.php contient mot de passe et nom d'utilisateur avec les constantes BD_HOTE, BD_NOM, BD_UTILISATEUR et BD_MOT_PASSE
include_once("configBD.interface.php");

class ConnexionBD {
	private static ?PDO $instance = null;

	private function __construct() {}

	public static function getInstance(): PDO {
		if (self::$instance === null) {
			$configuration = "mysql:host = " . ConfigBD::BD_HOTE . "; dbname = " . ConfigBD::BD_NOM;
			$utilisateur = ConfigBD::BD_UTILISATEUR;
			$motPasse = ConfigBD::BD_MOT_PASSE;

			self::$instance = new PDO($configuration, $utilisateur, $motPasse);

			// S'assurer que les transactions se font avec les caractères UTF-8
			self::$instance->exec("SET character_set_results = 'utf8'");
			self::$instance->exec("SET character_set_client = 'utf8'");
			self::$instance->exec("SET character_set_connectin = 'utf8'");

		}
		// Maintenant que nous sommes certains qu'elle existe, on la retourne
		return self::$instance;
	}

	// Fonction qui libère la connexion PDO (garbage collector)
	public static function close(): void {self::$instance = null;}

}
