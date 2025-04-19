<?php

// Interface à implémenter pour tous les DAO

// Inclusions:
// Import de l'interface DAO et la classe Vol
include_once("connexionBD.class.php");

// ******** INTERFACE ***********
interface DAO {
	/**
	 * Cette méthode doit retourner l'objet dont la clé primaire a été reçue en paramètre
	 * Comme la clé primaire peut être de différent type, 
	 * le type "mixed" est utilisable
	 * @param string $cles : la clé primaire de l'objet à chercher
	 * @return object ou null. Dépend de si le Vol a été trouvé ou pas
	 */
	static public function chercher(string $cles) : ?object;
	static public function chercherTous(): array;
	static public function chercherAvecFiltre(string $filtre): array;
	static public function inserer(object $objet): bool;
	static public function modifier(object $objet): bool;
	static public function supprimer(object $objet): bool;
}