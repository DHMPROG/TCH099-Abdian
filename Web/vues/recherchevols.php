<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Vols - Abdian</title>
    <link rel="stylesheet" href="../CSS/header.css" />
    <link rel="stylesheet" href="../CSS/footer.css" />
    <link rel="stylesheet" href="../CSS/pageVols.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    />
    
  </head>
  <body>
    <header>
      <nav class="barre-du-haut">
      <a href="index.html"><img class="abdian-logo-2-icon" src="assets/img/Abidan_logo.png" alt="Logo"></a>
  
      <div class="navigation">
        <a href="index.html" class="bouton">Accueil</a>
        <a href="destinations.html" class="bouton">Destinations</a>
        <a href="contact.html" class="bouton">Contact</a>
        <a href="Page de Connexion.html" class="bouton se-connecter">
          <img class="generic-avatar-icon" src="assets/img/Generic avatar.png" alt="Avatar">
          Se connecter
        </a>
      </div>
    </nav>
    </header>

    <main class="main">
      <div class="container">
        <div class="page-header">
          <h1>Résultats des vols</h1>
          <p>New York (JFK) vers Londres (LHR) • 12 Octobre 2023</p>
        </div>

        <div class="search-bar">
          <div class="search-content">
            <div class="search-fields">
              <div class="search-field">
                <div class="icon-container">
                  <i class="fas fa-map-marker-alt"></i>
                </div>
                <div>
                  <div class="label">De</div>
                  <div class="value">New York (JFK)</div>
                </div>
              </div>

              <div class="direction-icon">
                <i class="fas fa-exchange-alt"></i>
              </div>

              <div class="search-field">
                <div class="icon-container">
                  <i class="fas fa-map-marker-alt"></i>
                </div>
                <div>
                  <div class="label">Vers</div>
                  <div class="value">Londres (LHR)</div>
                </div>
              </div>

              <div class="search-field">
                <div class="icon-container">
                  <i class="fas fa-calendar"></i>
                </div>
                <div>
                  <div class="label">Départ</div>
                  <div class="value">12 Octobre 2023</div>
                </div>
              </div>

              <div class="search-field">
                <div class="icon-container">
                  <i class="fas fa-users"></i>
                </div>
                <div>
                  <div class="label">Passagers</div>
                  <div class="value">1 Adulte</div>
                </div>
              </div>
            </div>
            <button class="btn btn-accent">Modifier la recherche</button>
          </div>
        </div>

        <div class="content-wrapper">
          <aside class="filter-panel">
            <div class="filter-section">
              <h3>Trier par</h3>
              <div class="radio-group">
                <div class="radio-item">
                  <input
                    type="radio"
                    id="price"
                    name="sort"
                    value="price"
                    checked
                  />
                  <label for="price">Prix (le plus bas)</label>
                </div>
                <div class="radio-item">
                  <input
                    type="radio"
                    id="duration"
                    name="sort"
                    value="duration"
                  />
                  <label for="duration">Durée (la plus courte)</label>
                </div>
                <div class="radio-item">
                  <input
                    type="radio"
                    id="departure"
                    name="sort"
                    value="departure"
                  />
                  <label for="departure">Départ (le plus tôt)</label>
                </div>
                <div class="radio-item">
                  <input
                    type="radio"
                    id="arrival"
                    name="sort"
                    value="arrival"
                  />
                  <label for="arrival">Arrivée (la plus tôt)</label>
                </div>
              </div>
            </div>

            <div class="separator"></div>

            <div class="filter-section">
              <h3>Plage de prix</h3>
              <div class="slider-container">
                <input
                  type="range"
                  min="0"
                  max="2000"
                  value="750"
                  class="slider"
                  id="priceRange"
                />
                <div class="slider-labels">
                  <span>0 €</span>
                  <span id="priceValue">750 €</span>
                  <span>2 000 €+</span>
                </div>
              </div>
            </div>

            <div class="separator"></div>

            <div class="filter-section">
              <h3>Escales</h3>
              <div class="checkbox-group">
                <div class="checkbox-item">
                  <input
                    type="checkbox"
                    id="nonstop"
                    name="stops"
                    value="nonstop"
                  />
                  <label for="nonstop">Sans escale (10)</label>
                </div>
                <div class="checkbox-item">
                  <input
                    type="checkbox"
                    id="1stop"
                    name="stops"
                    value="1"
                    checked
                  />
                  <label for="1stop">1 Escale (24)</label>
                </div>
                <div class="checkbox-item">
                  <input
                    type="checkbox"
                    id="2stops"
                    name="stops"
                    value="2"
                    checked
                  />
                  <label for="2stops">2+ Escales (5)</label>
                </div>
              </div>
            </div>

            <div class="separator"></div>

            <div class="filter-section">
              <h3>Compagnies aériennes</h3>
              <div class="checkbox-group">
                <div class="checkbox-item">
                  <input
                    type="checkbox"
                    id="skyWings"
                    name="airline"
                    value="SkyWings Airlines"
                    checked
                  />
                  <label for="skyWings">SkyWings Airlines (15)</label>
                </div>
                <div class="checkbox-item">
                  <input
                    type="checkbox"
                    id="blueStar"
                    name="airline"
                    value="BlueStar Airways"
                    checked
                  />
                  <label for="blueStar">BlueStar Airways (8)</label>
                </div>
                <div class="checkbox-item">
                  <input
                    type="checkbox"
                    id="airGlobal"
                    name="airline"
                    value="AirGlobal"
                    checked
                  />
                  <label for="airGlobal">AirGlobal (7)</label>
                </div>
                <div class="checkbox-item">
                  <input
                    type="checkbox"
                    id="transAtlantic"
                    name="airline"
                    value="TransAtlantic"
                  />
                  <label for="transAtlantic">TransAtlantic (4)</label>
                </div>
              </div>
            </div>

            <div class="separator"></div>

            <div class="filter-section">
              <h3>Heure de départ</h3>
              <div class="time-filters">
                <div class="time-filter-item" data-time="6-12">
                  <div class="time-label">Matin</div>
                  <div class="time-range">6:00 - 12:00</div>
                </div>
                <div class="time-filter-item" data-time="12-18">
                  <div class="time-label">Après-midi</div>
                  <div class="time-range">12:00 - 18:00</div>
                </div>
                <div class="time-filter-item" data-time="18-24">
                  <div class="time-label">Soir</div>
                  <div class="time-range">18:00 - 24:00</div>
                </div>
                <div class="time-filter-item" data-time="0-6">
                  <div class="time-label">Nuit</div>
                  <div class="time-range">00:00 - 6:00</div>
                </div>
              </div>
            </div>
          </aside>

          <div class="results-container">
            <div class="results-header">
              <div class="results-summary">
                <span class="results-count">39 vols trouvés</span> • 12 Octobre
                2023 • 1 adulte
              </div>
              <div class="currency-selector">
                <span>Devise :</span>
                <select>
                  <option>USD</option>
                  <option>EUR</option>
                  <option>GBP</option>
                </select>
              </div>
            </div>

            <div class="flights-list-wrapper">
              <div class="flights-list" id="flightsList">
                <!-- Les cartes de vol seront insérées dynamiquement ici -->
              </div>

              <div id="flightSummary" class="flight-summary">
                <!-- Le résumé du vol sera rempli dynamiquement -->
              </div>
            </div>

            <div class="load-more">
              <button class="btn btn-load-more">Charger plus de vols</button>
            </div>
          </div>
        </div>
      </div>
    </main>
    <footer>
      <div class="group">
        <div class="abdian-les-meilleures-destina-wrapper">
          <img
            class="abdian-logo-1-icon"
            alt=""
            src="../assets/img/Abidan_logo.png"
          />

          <div class="abdian-les-meilleures">
            Abdian, les meilleures destinations au meilleur prix
          </div>
        </div>
        <div class="legal-terms-container">
          <p class="legal">
            <b>Légal</b>
          </p>
          <p class="legal">
            <b>&nbsp;</b>
          </p>
          <p class="legal">Conditions générales</p>
          <p class="legal">Politique de confidentialité</p>
          <p class="sitemap">Plan du site</p>
        </div>
        <div class="company-about-us-container">
          <p class="legal">
            <b>Entreprise</b>
          </p>
          <p class="legal">
            <b>&nbsp;</b>
          </p>
          <p class="legal">À propos de nous</p>
          <p class="legal">Blog</p>
          <p class="legal">Carrières</p>
          <p class="sitemap">Contactez-nous</p>
        </div>
        <div class="group1">
          <img class="group-icon" alt="" src="../Web/assets/img/Group.png" />
        </div>
      </div>
    </footer>
    <script type="module" src="../Scripts/PageVols.js"></script>
  </body>
</html>
