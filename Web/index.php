<?php
include_once __DIR__ ."/controlleurs/controleurManufacture.class.php";

try {
    // Obtenir l'action à accomplir
    $action = isset($_GET['action']) ? $_GET['action'] : "";

    // Créer une instance du contrôleur adapté
    $controleur = ManufactureControleur::creerControleur($action);

    // Exécuter l'action et obtenir le nom de la vue
    $nomVue = $controleur->executerAction();

    // Inclure la bonne vue
    include_once("vues/" . $nomVue);
} catch (Exception $e) {
    // Gestion des erreurs
    echo "Erreur : " . $e->getMessage();
}
?>