<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1, width=device-width" />
    <title>Connexion - Abdian</title>

    <link rel="stylesheet" href="../CSS/header.css" />
    <link rel="stylesheet" href="../CSS/footer.css" />
    <link rel="stylesheet" href="../CSS/pageConnexion.css" />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;800&display=swap"
    />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap"
    />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Nunito Sans:wght@400&display=swap"
    />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Satoshi:wght@400;700&display=swap"
    />
  </head>

  <body>
    <?php
	include_once('inclusions/header.php');
	?>
    <main>
      <div class="connexion-container">
        <h2>Connexion</h2>
        <form method="POST" action="index.php?action=seConnecter">
          <label for="email">Adresse email :</label>
              <input
                  type="text"
                  id="email"
                  name="email"
                  required
                  placeholder="Entrez votre email"
              />

              <label for="password">Mot de passe :</label>
              <input
                  type="password"
                  id="password"
                  name="mot_passe"
                  required
                  placeholder="Entrez votre mot de passe"
              />

              <input type="submit" value="Se connecter" />
          </form>

        <div class="create-account">
          <p>
            Pas encore de compte ?
            <a href="index.php?action=seInscrire" class="CreerCompteBouton"
              >Créer un compte</a
            >
          </p>
        </div>
      </div>
    </main>
    <?php
    include_once('inclusions/footer.php');
    ?>
  </body>
</html>
