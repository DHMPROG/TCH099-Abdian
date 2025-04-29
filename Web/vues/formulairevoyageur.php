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

  $nbA = isset($_GET['nb_adultes']) ? (int)$_GET['nb_adultes'] : 0;
  $nbE = isset($_GET['nb_enfants']) ? (int)$_GET['nb_enfants'] : 0;
  $nbB = isset($_GET['nb_bebes'])   ? (int)$_GET['nb_bebes']   : 0;
  $idx = 1;

  $vol_id = isset($_GET['vol_id']) ? (int)$_GET['vol_id'] : null;
  $retour_id = isset($_GET['retour_id']) ? (int)$_GET['retour_id'] : null;
  if ($retour_id) {
    $vol_retour = VolDAO::chercher($retour_id);
  }

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
        <div class="passenger-info">
        <h2>Information passager</h2>
        <p class="info-text">Veuillez entrer les informations requises pour chaque voyageur.</p>
        <form id="form-passager" action="index.php?action=selectionSieges&vol_id=<?=$vol->getId() ?>&retour_id=<?=$vol_retour->getId() ?>" method="POST">
        

          <?php for ($i = 0; $i < $nbA; $i++, $idx++): ?>
            <div class="passenger-section">
              <h3>Passager <?= $idx ?> (Adulte)</h3>
              <div class="form-row">
                <div class="form-group">
                  <label for="prenom-<?= $idx ?>">Prénom*</label>
                  <input type="text" id="prenom-<?= $idx ?>" name="passengers[<?= $idx ?>][prenom]" required>
                </div>
                <div class="form-group">
                  <label for="deuxieme-prenom-<?= $idx ?>">Deuxième prénom</label>
                  <input type="text" id="deuxieme-prenom-<?= $idx ?>" name="passengers[<?= $idx ?>][deuxieme_prenom]">
                </div>
                <div class="form-group">
                  <label for="nom-<?= $idx ?>">Nom*</label>
                  <input type="text" id="nom-<?= $idx ?>" name="passengers[<?= $idx ?>][nom]" required>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group">
                  <label for="date-naissance-<?= $idx ?>">Date de naissance*</label>
                  <input type="date" id="date-naissance-<?= $idx ?>" name="passengers[<?= $idx ?>][date_naissance]" required>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group">
                  <label for="email-<?= $idx ?>">Adresse email*</label>
                  <input type="email" id="email-<?= $idx ?>" name="passengers[<?= $idx ?>][email]" required>
                </div>
                <div class="form-group">
                  <label for="telephone-<?= $idx ?>">Numéro de téléphone*</label>
                  <input type="tel" id="telephone-<?= $idx ?>" name="passengers[<?= $idx ?>][telephone]" required>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group">
                  <label for="recours-<?= $idx ?>">Numéro de recours</label>
                  <input type="text" id="recours-<?= $idx ?>" name="passengers[<?= $idx ?>][recours]">
                </div>
              </div>
            </div>
          <?php endfor; ?>

          <?php for ($i = 0; $i < $nbE; $i++, $idx++): ?>
            <div class="passenger-section">
              <h3>Passager <?= $idx ?> (Enfant)</h3>
              <div class="form-row">
                <div class="form-group">
                  <label for="prenom-<?= $idx ?>">Prénom*</label>
                  <input type="text" id="prenom-<?= $idx ?>" name="passengers[<?= $idx ?>][prenom]" required>
                </div>
                <div class="form-group">
                  <label for="nom-<?= $idx ?>">Nom*</label>
                  <input type="text" id="nom-<?= $idx ?>" name="passengers[<?= $idx ?>][nom]" required>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group">
                  <label for="date-naissance-<?= $idx ?>">Date de naissance*</label>
                  <input type="date" id="date-naissance-<?= $idx ?>" name="passengers[<?= $idx ?>][date_naissance]" required>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group">
                  <label for="recours-<?= $idx ?>">Numéro de recours</label>
                  <input type="text" id="recours-<?= $idx ?>" name="passengers[<?= $idx ?>][recours]">
                </div>
              </div>
            </div>
          <?php endfor; ?>

          <?php for ($i = 0; $i < $nbB; $i++, $idx++): ?>
            <div class="passenger-section">
              <h3>Passager <?= $idx ?> (Bébé)</h3>
              <div class="form-row">
              <div class="form-group">
                  <label for="prenom-<?= $idx ?>">Prénom*</label>
                  <input type="text" id="prenom-<?= $idx ?>" name="passengers[<?= $idx ?>][prenom]" required>
                </div>
                <div class="form-group">
                  <label for="nom-<?= $idx ?>">Nom*</label>
                  <input type="text" id="nom-<?= $idx ?>" name="passengers[<?= $idx ?>][nom]" required>
                </div>
                <div class="form-group">
                  <label for="date-naissance-<?= $idx ?>">Date de naissance*</label>
                  <input type="date" id="date-naissance-<?= $idx ?>" name="passengers[<?= $idx ?>][date_naissance]" required>
                </div>
              </div>
            </div>
          <?php endfor; ?>

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
      </div>



        <aside class="flight-summary">
        <div class="flight-details">
          <div class="airline-info">
            <img src="" alt="<?= $vol->getAirline() ?>" class="airline-logo">
            <div>
              <p class="airline-name"><?= $vol->getAirline() ?> – <?= $vol->getDepartureAirport() ?> à <?= $vol->getArrivalAirport() ?></p>
              <p class="flight-number"><?= $vol->getFlightNumber() ?></p>
            </div>
          </div>
          <div class="flight-time">
            <p class="duration"><?= $vol->getDuration() ?></p>
            <p class="time">Départ : <?= $vol->getDepartureTime() ?> – Arrivée : <?= $vol->getArrivalTime() ?></p>
          </div>
        </div>

        <?php if (isset($vol_retour)): ?>
          <div class="flight-details return">
            <div class="airline-info">
              <img src="" alt="<?= $vol_retour->getAirline() ?>" class="airline-logo">
              <div>
                <p class="airline-name"><?= $vol_retour->getAirline() ?> – <?= $vol_retour->getDepartureAirport() ?> à <?= $vol_retour->getArrivalAirport() ?></p>
                <p class="flight-number"><?= $vol_retour->getFlightNumber() ?></p>
              </div>
            </div>
            <div class="flight-time">
              <p class="duration"><?= $vol_retour->getDuration() ?></p>
              <p class="time">Départ : <?= $vol_retour->getDepartureTime() ?> – Arrivée : <?= $vol_retour->getArrivalTime() ?></p>
            </div>
          </div>
        <?php endif; ?>

        <div class="price-summary">
          <div class="price-row">
            <span>Subtotal</span>
            <span><?= (($vol->getPrice() + ($vol_retour->getPrice() ?? 0)) * ($nbA + $nbE + $nbB)) ?> $</span>
          </div>
          <div class="price-row">
            <span>Taxes and Fees</span>
            <span><?= round((($vol->getPrice() + ($vol_retour->getPrice() ?? 0)) * 1.14 - ($vol->getPrice() + ($vol_retour->getPrice() ?? 0))) * ($nbA + $nbE + $nbB)) ?> $</span>
          </div>
          <div class="price-row total">
            <span>Total</span>
            <span><?= round(($vol->getPrice() + ($vol_retour->getPrice() ?? 0)) * 1.14 * ($nbA + $nbE + $nbB)) ?> $</span>
          </div>
        </div>

        <a id="soumettre"><button class="btn btn-outline select-seats" type="button">Sélectionner sièges</button></a>
      </aside>
      

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
  document.getElementById('soumettre').addEventListener('click', function(e) {
    e.preventDefault(); // empêche la redirection
    document.getElementById('form-passager').submit();
  });
</script>

</html>