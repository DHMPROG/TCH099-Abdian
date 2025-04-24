<?php

// Parametres d'accès à la BD
interface ConfigBD {
	public const BD_HOTE = "abdian-mysql";      // NOM DU SERVICE DANS DOCKER-COMPOSE
    public const BD_UTILISATEUR = "root";
    public const BD_MOT_PASSE = "root";
    public const BD_NOM = "abdian_db";
}