<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Contact - Abdian</title>
    <link rel="stylesheet" href="../CSS/header.css" />
    <link rel="stylesheet" href="../CSS/footer.css" />
    <link rel="stylesheet" href="../CSS/pageContact.css">
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Montserrat:wght@800&display=swap"
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
      <div class="contact-container">
        <h2>Contactez-nous</h2>
        <form class="formulaire-contact" action="#" method="post">
          <label>Nom :</label>
          <input type="text" name="nom" required placeholder="Votre nom" />
          <label>Email :</label>
          <input type="email" name="email" required placeholder="Votre email" />
          <label>Message :</label>
          <textarea
            name="message"
            rows="5"
            required
            placeholder="Votre message"
          ></textarea>
          <button type="submit">Envoyer</button>
        </form>
      </div>
    </main>
    <?php
	include_once('inclusions/footer.php');
	?>
  </body>
</html>
