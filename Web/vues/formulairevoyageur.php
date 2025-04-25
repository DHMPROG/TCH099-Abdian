<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="initial-scale=1, width=device-width">
  <title>Accueil - Abdian</title>


  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@800&display=swap">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito Sans:wght@400&display=swap" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Satoshi:wght@400;700&display=swap" />
  <link rel="stylesheet" href="../CSS/header.css" />
  <link rel="stylesheet" href="../CSS/footer.css" />
  <link rel="stylesheet" href="../CSS/pageFormulaire.css">

  <script src="../Scripts/pageFormulaire.js"></script>


</head>

<body>
  <?php
  include_once('inclusions/header.php');

  $vol_id = isset($_GET['vol_id']) ? (int)$_GET['vol_id'] : null;

  if ($vol_id) {
    include_once __DIR__ . "/../modele/dao/VolDao.php";
    $vol = VolDAO::chercher($vol_id); // À implémenter si ce n'est pas encore fait
  }

  // Vérifie si un utilisateur est connecté
  $utilisateurConnecte = null;

  if (isset($_SESSION['utilisateur']) && $_SESSION['utilisateur'] instanceof Utilisateur) {
    /** @var Utilisateur $utilisateurConnecte */
    $utilisateurConnecte = $_SESSION['utilisateur'];
  }
  ?>
  ?>

  <main class="main">
    <div class="container">
      <div class="form-container">
        <section class="passenger-info">
          <form action="index.php?action=selectionSieges&vol_id=<?= $vol->getId() ?>"  method="POST"id="form-passager">
            <h2>Information passager</h2>
            <p class="info-text">
              Veuillez entrer les informations requises pour chaque voyageur et vous assurer
              qu'elles correspondent exactement à celles figurant sur la pièce d'identité officielle
              présentée à l'aéroport.
            </p>

            <div class="passenger-section">
              <h3>Passager 1 (Adult)</h3>

              <div class="form-row">
                <div class="form-group">
                  <label for="prenom">Prénom*</label>
                  <input type="text" id="prenom" name="prenom"
                    value="<?= $utilisateurConnecte ? htmlspecialchars($utilisateurConnecte->getPrenom()) : '' ?>" required>
                </div>
                <div class="form-group">
                  <label for="deuxieme-prenom">Deuxième prénom</label>
                  <input type="text" id="deuxieme-prenom" name="deuxieme-prenom">
                </div>
                <div class="form-group">
                  <label for="nom">Nom*</label>
                  <input type="text" id="nom" name="nom"
                    value="<?= $utilisateurConnecte ? htmlspecialchars($utilisateurConnecte->getNom()) : '' ?>" required>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group">
                  <label for="date-naissance">Date de naissance*</label>
                  <input type="date" id="date-naissance" name="date-naissance" required>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group">
                  <label for="email">Adresse email*</label>
                  <input type="email" id="email" name="email"
                    value="<?= $utilisateurConnecte ? htmlspecialchars($utilisateurConnecte->getEmail()) : '' ?>" required>
                </div>
                <div class="form-group">
                  <label for="telephone">Numéro de téléphone*</label>
                  <input type="tel" id="telephone" name="telephone"
                    value="<?= $utilisateurConnecte ? htmlspecialchars($utilisateurConnecte->getTelephone()) : '' ?>" required>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group">
                  <label for="recours">Numéro de recours</label>
                  <input type="text" id="recours" name="recours">
                </div>
              </div>
            </div>

            <section class="emergency-contact">
              <h3>Contact d'urgence</h3>

              <div class="form-row">
                <div class="form-check">
                  <input type="checkbox" id="same-as-passenger" name="same-as-passenger">
                  <label for="same-as-passenger">Pareil au passager 1</label>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group">
                  <label for="urgence-prenom">Prénom*</label>
                  <input type="text" id="urgence-prenom" name="urgence-prenom" required>
                </div>
                <div class="form-group">
                  <label for="urgence-nom">Nom*</label>
                  <input type="text" id="urgence-nom" name="urgence-nom" required>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group">
                  <label for="urgence-email">Adresse email*</label>
                  <input type="email" id="urgence-email" name="urgence-email" required>
                </div>
                <div class="form-group">
                  <label for="urgence-telephone">Numéro de téléphone*</label>
                  <input type="tel" id="urgence-telephone" name="urgence-telephone" required>
                </div>
              </div>
            </section>
          </form>
          <section class="baggage-info">
          <h3>Information de bagage</h3>
          <p class="info-text">
            Chaque passager a droit à un bagage à main gratuit ainsi qu'à un article personnel.
            Le premier bagage enregistré est également gratuit pour chaque passager. Les frais
            pour un deuxième bagage enregistré sont annulés pour les membres du programme
            de fidélité. Consultez la politique complète sur les bagages.
          </p>

          <div class="baggage-selection">
            <div class="passenger-baggage">
              <h4>Passager 1</h4>
              <div class="baggage-counter">
                <p>Bagages enregistrés</p>
                <div class="counter">
                  <button class="counter-btn minus-btn" type="button">-</button>
                  <span class="counter-value">1</span>
                  <button class="counter-btn plus-btn" type="button">+</button>
                </div>
              </div>
            </div>
            <div class="baggage-illustration">
              <img src="../assets/img/bagages.png" alt="Illustration bagages" class="baggage-img">
            </div>
          </div>
        </section>
        </section>


       
        

        <aside class="flight-summary">
          <div class="flight-details">
            <div class="airline-info">
              <img src="" alt="Hawaiian Airlines" class="airline-logo">
              <div>
                <p class="airline-name"><? echo $vol->getAirline() . ' - ' . $vol->getDepartureAirport() . " À " . $vol->getArrivalAirport(); ?></p>
                <p class="flight-number"><? echo $vol->getFlightNumber(); ?></p>
              </div>
            </div>
            <div class="flight-time">
              <p class="duration"><? echo $vol->getDuration(); ?></p>
              <p class="time"><? echo "Départ : " . $vol->getDepartureTime() . " - " . " Arrivée : " . $vol->getArrivalTime(); ?></p>
            </div>
          </div>


          <div class="price-summary">
            <div class="price-row">
              <span>Subtotal</span>
              <span><? echo $vol->getPrice() . " $"; ?></span>
            </div>
            <div class="price-row">
              <span>Taxes and Fees</span>
              <span><? echo $vol->getPrice() * 1.14 - $vol->getPrice() . " $"; ?></span>
            </div>
            <div class="price-row total">
              <span>Total</span>
              <span><? echo $vol->getPrice() * 1.14 . " $"; ?></span>
            </div>
          </div>

          <a id="soumettre"><button class="btn btn-outline select-seats" type="submit">Sélectionner sièges</button></a>
        </aside>
      </div>

      <div class="form-actions">
        <a href="index.php?action=selectionSieges&vol_id=<?= $vol->getId() ?>" id="soumettre"><button class="btn btn-primary" id="submitForm" type="submit">Enregistrer et fermer</button></a>
      </div>
    </div>
  </main>
  <footer>
    <div class="group">
      <div class="abdian-les-meilleures-destina-wrapper">
        <img class="abdian-logo-1-icon" alt="" src="../assets/img/Abidan_logo.png">

        <div class="abdian-les-meilleures">Abdian, les meilleures destinations au meilleur prix</div>
      </div>
      <div class="legal-terms-container">
        <p class="legal">
          <b>Legal</b>
        </p>
        <p class="legal">
          <b>&nbsp;</b>
        </p>
        <p class="legal">Terms & Conditions</p>
        <p class="legal">Privacy Policy</p>
        <p class="sitemap">Sitemap</p>
      </div>
      <div class="company-about-us-container">
        <p class="legal">
          <b>Company</b>
        </p>
        <p class="legal">
          <b>&nbsp;</b>
        </p>
        <p class="legal">About Us</p>
        <p class="legal">Blog</p>
        <p class="legal">Careers</p>
        <p class="sitemap">Contact Us</p>
      </div>
      <div class="group1">

        <img class="group-icon" alt="" src="../Web/assets/img/Group.png">

      </div>
    </div>
  </footer>

</body>

<script>
  document.getElementById('soumettre').addEventListener('click', function (e) {
    e.preventDefault(); // empêche la redirection
    document.getElementById('form-passager').submit();
  });
</script>

</html>