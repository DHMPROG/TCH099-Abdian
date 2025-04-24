<!DOCTYPE html>
<html>

<head>
      <meta charset="utf-8">
      <meta name="viewport" content="initial-scale=1, width=device-width">
      <title>Inscription - Abdian</title>


      <link rel="stylesheet" href="../CSS/header.css"/>
      <link rel="stylesheet" href="../CSS/footer.css" />
      <link rel="stylesheet" href="../CSS/pageInscription.CSS"/>
      <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;800&display=swap" />
      <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" />
      <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito Sans:wght@400&display=swap" />
      <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Satoshi:wght@400;700&display=swap" />



</head>

<body>
<?php
include_once('inclusions/header.php');
?>
<main>
            <div class="signup-container">
                  <h2>Créer un compte</h2>
                  <form method="post" action="?action=creerCompte">
                        <label for="firstName">Prénom :</label>
                        <input type="text" id="firstName" name="firstName" required placeholder="Entrez votre prénom">

                        <label for="lastName">Nom :</label>
                        <input type="text" id="lastName" name="lastName" required placeholder="Entrez votre nom">

                        <label for="email">Email :</label>
                        <input type="email" id="email" name="email" required placeholder="Entrez votre email">

                        <label for="email">Confirmez l'adresse email :</label>
                        <input type="email" id="email" name="email" required placeholder="Entrez votre email">

                        <label for="password">Mot de passe :</label>
                        <input type="password" id="password" name="password" required
                              placeholder="Entrez votre mot de passe">

                        <label for="password">Confirmer le mot de passe :</label>
                        <input type="password" id="password" name="password" required
                              placeholder="Entrez votre mot de passe">

                        <label for="phone">Téléphone :</label>
                        <input type="text" id="phone" name="phone" placeholder="Entrez votre numéro de téléphone">

                        <input type="submit" value="Créer un compte">
                  </form>
</main>
<?php
include_once('inclusions/footer.php');
?>
</body>
à

</html>