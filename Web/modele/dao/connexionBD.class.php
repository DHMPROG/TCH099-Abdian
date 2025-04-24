<?php
// ConnexionBD.php

include_once("configBD.interface.php");

class ConnexionBD {
	private static ?PDO $instance = null;

	private function __construct() {}

	public static function getInstance(): PDO {
		if (self::$instance === null) {
			$dsn = "mysql:host=" . ConfigBD::BD_HOTE . ";dbname=" . ConfigBD::BD_NOM . ";charset=utf8";

			try {
				self::$instance = new PDO($dsn, ConfigBD::BD_UTILISATEUR, ConfigBD::BD_MOT_PASSE);
				self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Bon réflexe pour debug

				// Encodage UTF-8
				self::$instance->exec("SET character_set_results = 'utf8'");
				self::$instance->exec("SET character_set_client = 'utf8'");
				self::$instance->exec("SET character_set_connection = 'utf8'");

			} catch (PDOException $e) {
				die("Erreur de connexion à la BD : " . $e->getMessage());
			}
		}
		return self::$instance;
	}

	public static function close(): void {
		self::$instance = null;
	}
}
