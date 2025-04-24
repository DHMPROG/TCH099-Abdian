<?php
include_once __DIR__ . "/modele/dao/connexionBD.class.php";
include_once __DIR__ . "/modele/VolClass.php";
include_once __DIR__ . "/modele/dao/VolDAO.php";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Test VolDAO</title>
</head>
<body>
    <h1>Test de la classe VolDAO</h1>

    <!-- Chercher un vol -->
    <form method="GET">
        <label>Rechercher un vol par ID :</label>
        <input type="text" name="idVol" placeholder="Ex: V001">
        <input type="submit" name="chercher" value="Chercher">
    </form>

    <!-- Afficher tous les vols -->
    <form method="POST">
        <input type="submit" name="afficherTous" value="Afficher tous les vols">
    </form>

    <!-- Chercher par aéroports -->
    <form method="GET">
        <label>Départ :</label>
        <input type="text" name="depart">
        <label>Arrivée :</label>
        <input type="text" name="arrivee">
        <input type="submit" name="chercherAeroports" value="Chercher par aéroports">
    </form>

    <!-- Insérer un vol -->
    <form method="POST">
        <input type="submit" name="inserer" value="Insérer un vol test">
    </form>

    <hr>

    <?php
    if (isset($_GET['chercher']) && !empty($_GET['idVol'])) {
        $vol = VolDAO::chercher($_GET['idVol']);
        if ($vol) {
            echo "<h3>Résultat :</h3>";
            echo "<pre>";
            print_r($vol);
            echo "</pre>";
        } else {
            echo "Aucun vol trouvé avec l'ID " . htmlspecialchars($_GET['idVol']);
        }
    }

    if (isset($_POST['afficherTous'])) {
        $vols = VolDAO::chercherTous();
        echo "<h3>Liste de tous les vols :</h3><ul>";
        foreach ($vols as $v) {
            echo "<li>{$v->getId()} - {$v->getAirline()} ({$v->getDepartureCode()} → {$v->getArrivalCode()})</li>";
        }
        echo "</ul>";
    }

    if (isset($_GET['chercherAeroports'])) {
        $dep = $_GET['depart'];
        $arr = $_GET['arrivee'];
        $vols = VolDAO::chercherParAeroports($dep, $arr);
        echo "<h3>Vols de $dep à $arr :</h3><ul>";
        foreach ($vols as $v) {
            echo "<li>{$v->getId()} - {$v->getAirline()} - {$v->getDepartureDate()} {$v->getDepartureTime()}</li>";
        }
        echo "</ul>";
    }

    if (isset($_POST['inserer'])) {
        $volTest = new Vol(
            "100", "Test Airline", "TA001", "TestPlane",
            "2025-12-01", "09:00", "YUL", "YUL",
            "2025-12-01", "18:00", "LAX", "LAX",
            "9h", 0, "Direct", 499.99
        );
        if (VolDAO::inserer($volTest)) {
            echo "Vol test inséré avec succès.";
        } else {
            echo "Erreur lors de l'insertion du vol test.";
        }
    }
    ?>
</body>
</html>
