<?php

$user = $_SESSION['utilisateurConnecte'] ?? null;
?>

<header>
    <nav class="barre-du-haut">
        <a href="index.php?action=accueil">
            <img class="abdian-logo-2-icon" src="../assets/img/Abidan_logo.png" alt="Logo">
        </a>

        <div class="navigation">
            <a href="index.php?action=accueil" class="bouton">Accueil</a>
            <a href="index.php?action=destinations" class="bouton">Destinations</a>
            <a href="index.php?action=contact" class="bouton">Contact</a>

            <?php if ($user instanceof Utilisateur): ?>
                <!-- UTILISATEUR CONNECTÉ -->
                <span class="bouton">
                  Bonjour&nbsp;<?= htmlspecialchars($user->getPrenom()) ?>
                  <?= htmlspecialchars($user->getNom()) ?>
                </span>
                <a href="index.php?action=deconnexion" class="bouton se-connecter">
                    Se déconnecter
                </a>
            <?php else: ?>
                <!-- PERSONNE NON CONNECTÉE -->
                <a href="index.php?action=seConnecter" class="bouton se-connecter">
                    <img class="generic-avatar-icon" src="../assets/img/Generic avatar.png" alt="Avatar">
                    Se connecter
                </a>
            <?php endif; ?>
        </div>
    </nav>
</header>
