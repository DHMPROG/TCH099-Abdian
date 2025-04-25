<?php
// recherchevols.php

include_once __DIR__ . "/../modele/dao/connexionBD.class.php";
include_once __DIR__ . "/../modele/VolClass.php";
include_once __DIR__ . "/../modele/dao/VolDao.php";

// Lire les paramètres de recherche
$depart      = isset($_GET['depart'])      ? substr(htmlspecialchars($_GET['depart']), 0, 3) : null;
$arrivee     = isset($_GET['arrivee'])     ? substr(htmlspecialchars($_GET['arrivee']), 0, 3) : null;
$date_depart = isset($_GET['date_depart']) ? htmlspecialchars($_GET['date_depart'])       : null;

// Données initiales
$flightData = [];
if ($depart && $arrivee && $date_depart) {
  $flightData = VolDAO::chercherParAeroportsEtDate($depart, $arrivee, $date_depart);
}

// Récupérer les filtres/tris/sélection
$sortBy       = $_GET['sort']        ?? 'price';
$priceMax     = isset($_GET['priceRange']) ? (int)$_GET['priceRange'] : 2000;
$airlines     = $_GET['airline']    ?? [];      // array of strings
$stops        = $_GET['stops']      ?? [];      // array of "0","1","2"
$timeFilter   = $_GET['timeFilter'] ?? null;    // e.g. "6-12"
$selectedId   = isset($_GET['select']) ? (int)$_GET['select'] : null;

// utilitaire : convertir "7h 45m" en minutes
function parseDuration(string $d): int
{
  if (preg_match('/(\d+)h\s*(\d+)m?/', $d, $m)) {
    return (int)$m[1] * 60 + (int)$m[2];
  }
  return 0;
}

// filtrage
$currentFlights = array_filter($flightData, function ($f) use ($priceMax, $airlines, $stops, $timeFilter) {
  if ($f->getPrice() > $priceMax) return false;
  if (!empty($airlines) && !in_array($f->getAirline(), $airlines, true)) return false;
  if (!empty($stops)    && !in_array((string)$f->getStops(), $stops, true))    return false;
  if ($timeFilter && preg_match('/^(\d+):/', $f->getDepartureTime(), $m)) {
    list($hMin, $hMax) = explode('-', $timeFilter);
    $h = (int)$m[1];
    if ($h < (int)$hMin || $h >= (int)$hMax) return false;
  }
  return true;
});

// tri
usort($currentFlights, function ($a, $b) use ($sortBy) {
  switch ($sortBy) {
    case 'price':
      return $a->getPrice() <=> $b->getPrice();
    case 'duration':
      return parseDuration($a->getDuration()) <=> parseDuration($b->getDuration());
    case 'departure':
      return strcmp($a->getDepartureTime(), $b->getDepartureTime());
    case 'arrival':
      return strcmp($a->getArrivalTime(), $b->getArrivalTime());
  }
  return 0;
});

// sélection
$selected = null;
foreach ($currentFlights as $f) {
  if ($f->getId() === $selectedId) {
    $selected = $f;
    break;
  }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Vols - Abdian</title>
  <link rel="stylesheet" href="../CSS/header.css" />
  <link rel="stylesheet" href="../CSS/footer.css" />
  <link rel="stylesheet" href="../CSS/pageVols.css" />
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
</head>

<body>
  <?php include_once('inclusions/header.php'); ?>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <main class="main">
    <div class="container">
      <div class="page-header">
        <h1>Résultats des vols</h1>
        <?php if (!empty($currentFlights)): ?>
          <p>
            <?= htmlspecialchars($currentFlights[0]->getDepartureAirport()) ?> (<?= htmlspecialchars($depart) ?>)
            vers <?= htmlspecialchars($currentFlights[0]->getArrivalAirport()) ?> (<?= htmlspecialchars($arrivee) ?>)
            – <?= htmlspecialchars($currentFlights[0]->getDepartureDate()) ?>
          </p>
        <?php else: ?>
          <p>Aucun vol ne correspond à vos critères.</p>
        <?php endif; ?>
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
                <div class="value">
                  <?= !empty($currentFlights)
                    ? htmlspecialchars($currentFlights[0]->getDepartureAirport())
                    : '' ?>
                </div>
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
                <div class="value">
                  <?= !empty($currentFlights)
                    ? htmlspecialchars($currentFlights[0]->getArrivalAirport())
                    : '' ?>
                </div>
              </div>
            </div>

            <div class="search-field">
              <div class="icon-container">
                <i class="fas fa-calendar"></i>
              </div>
              <div>
                <div class="label">Départ</div>
                <div class="value">
                  <?= !empty($currentFlights)
                    ? htmlspecialchars($currentFlights[0]->getDepartureDate())
                    : '' ?>
                </div>
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
                <input type="radio" id="price" name="sort"
                  value="price" <?= $sortBy === 'price' ? 'checked' : '' ?> />
                <label for="price">Prix (le plus bas)</label>
              </div>
              <div class="radio-item">
                <input type="radio" id="duration" name="sort"
                  value="duration" <?= $sortBy === 'duration' ? 'checked' : '' ?> />
                <label for="duration">Durée (la plus courte)</label>
              </div>
              <div class="radio-item">
                <input type="radio" id="departure" name="sort"
                  value="departure" <?= $sortBy === 'departure' ? 'checked' : '' ?> />
                <label for="departure">Départ (le plus tôt)</label>
              </div>
              <div class="radio-item">
                <input type="radio" id="arrival" name="sort"
                  value="arrival" <?= $sortBy === 'arrival' ? 'checked' : '' ?> />
                <label for="arrival">Arrivée (la plus tôt)</label>
              </div>
            </div>
          </div>

          <div class="separator"></div>

          <div class="filter-section">
            <h3>Plage de prix</h3>
            <div class="slider-container">
              <input type="range" min="0" max="2000"
                value="<?= $priceMax ?>"
                class="slider" id="priceRange"
                onchange="location.search='<?= http_build_query(array_merge($_GET, ['priceRange' => ''])) ?>'+this.value" />
              <div class="slider-labels">
                <span>0 $</span>
                <span id="priceValue"><?= $priceMax ?> $</span>
                <span>2 000 $+</span>
              </div>
            </div>
          </div>

          <div class="separator"></div>

          <div class="filter-section">
            <h3>Escales</h3>
            <div class="checkbox-group">
              <?php foreach ([0, 1, 2] as $s): ?>
                <div class="checkbox-item">
                  <input type="checkbox" id="stop<?= $s ?>" name="stops[]"
                    value="<?= $s ?>"
                    <?= in_array((string)$s, $stops) ? 'checked' : '' ?>
                    onchange="location.search='<?= http_build_query(array_merge($_GET, ['stops' => []])) ?>&stops[]='+this.value" />
                  <label for="stop<?= $s ?>">
                    <?= $s === 0 ? 'Sans escale' : ($s === 1 ? '1 Escale' : '2+ Escales') ?>
                  </label>
                </div>
              <?php endforeach; ?>
            </div>
          </div>

          <div class="separator"></div>

          <div class="filter-section">
            <h3>Compagnies aériennes</h3>
            <div class="checkbox-group">
              <?php
              $allA = array_unique(array_map(fn($f) => $f->getAirline(), $flightData));
              foreach ($allA as $a):
              ?>
                <div class="checkbox-item">
                  <input type="checkbox" id="air<?= md5($a) ?>"
                    name="airline[]" value="<?= htmlspecialchars($a) ?>"
                    <?= in_array($a, $airlines) ? 'checked' : '' ?>
                    onchange="location.search='<?= http_build_query(array_merge($_GET, ['airline' => []])) ?>&airline[]='+encodeURIComponent(this.value)" />
                  <label for="air<?= md5($a) ?>"><?= htmlspecialchars($a) ?></label>
                </div>
              <?php endforeach; ?>
            </div>
          </div>

          <div class="separator"></div>

          <div class="filter-section">
            <h3>Heure de départ</h3>
            <div class="time-filters">
              <?php foreach (['6-12' => 'Matin', '12-18' => 'Après-midi', '18-24' => 'Soir', '0-6' => 'Nuit'] as $val => $lbl): ?>
                <div class="time-filter-item <?= $timeFilter === $val ? 'active' : '' ?>"
                  onclick="location.search='<?= http_build_query(array_merge($_GET, ['timeFilter' => $val])) ?>'">
                  <div class="time-label"><?= $lbl ?></div>
                  <div class="time-range"><?= str_replace('-', ':00 - ', $val) ?>:00</div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </aside>

        <div class="results-container">
          <div class="results-header">
            <div class="results-summary">
              <span class="results-count"><?= count($currentFlights) ?> vols trouvés</span> •
              <?= htmlspecialchars("$depart vers $arrivee • $date_depart") ?>
            </div>
          </div>
          <div class="flights-list-wrapper<?= $selected ? ' has-summary' : '' ?>">
            <div class="flights-list" id="flightsList">
              <?php foreach ($currentFlights as $f):
                $isSel = $selected && $f->getId() === $selected->getId();
              ?>
                <div class="flight-card<?= $isSel ? ' selected' : '' ?>"
                  data-flight-id="<?= $f->getId() ?>" data-stops="<?= $f->getStops() ?>">
                  <div class="flight-card-header">
                    <div class="airline-info">
                      <img src="https://via.placeholder.com/50"
                        alt="<?= htmlspecialchars($f->getAirline()) ?>"
                        class="airline-logo">
                      <div>
                        <div class="airline-name"><?= htmlspecialchars($f->getAirline()) ?></div>
                        <div class="flight-number"><?= htmlspecialchars($f->getFlightNumber()) ?></div>
                      </div>
                    </div>
                    <div class="flight-details">
                      <div class="route-info">
                        <div class="airport-time">
                          <div class="time"><?= htmlspecialchars($f->getDepartureTime()) ?></div>
                          <div class="code"><?= htmlspecialchars($f->getDepartureCode()) ?></div>
                          <div class="airport"><?= htmlspecialchars($f->getDepartureAirport()) ?></div>
                        </div>
                        <div class="flight-path">
                          <div class="duration"><?= htmlspecialchars($f->getDuration()) ?></div>
                          <div class="path-line">
                            <div class="line"></div>
                            <i class="fas fa-plane plane-icon"></i>
                            <div class="line"></div>
                          </div>
                          <div class="stops-info">
                            <?php if ($f->getStops() === 0): ?>
                              <span class="nonstop">Sans escale</span>
                            <?php else: ?>
                              <span class="with-stops">
                                <?= $f->getStops() ?> <?= $f->getStops() === 1 ? 'escale' : 'escales' ?>
                                <i class="fas fa-info-circle info-icon"></i>
                                <span class="tooltip"><?= htmlspecialchars($f->getStopDetails()) ?></span>
                              </span>
                            <?php endif; ?>
                          </div>
                        </div>
                        <div class="airport-time">
                          <div class="time"><?= htmlspecialchars($f->getArrivalTime()) ?></div>
                          <div class="code"><?= htmlspecialchars($f->getArrivalCode()) ?></div>
                          <div class="airport"><?= htmlspecialchars($f->getArrivalAirport()) ?></div>
                        </div>
                      </div>
                    </div>
                    <div class="price-info">
                      <div class="price"><?= number_format($f->getPrice(), 2) ?> $</div>
                      <button class="btn btn-primary select-btn<?= $isSel ? ' selected' : '' ?>">
                        <?= $isSel ? 'Sélectionné' : 'Sélectionner' ?>
                      </button>
                      <div class="per-person">Aller-retour par personne</div>
                    </div>
                  </div>
                  <div class="flight-card-footer">
                    <button class="details-toggle">
                      <span>Détails du vol</span>
                      <i class="fas fa-chevron-down toggle-icon"></i>
                    </button>
                    <div class="flight-details-content">
                      <p>Modèle d'avion : <?= htmlspecialchars($f->getAircraftModel()) ?></p>
                      <p>Date départ : <?= htmlspecialchars($f->getDepartureDate()) ?> / Arrivée : <?= htmlspecialchars($f->getArrivalDate()) ?></p>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
            <?php if ($selected):
              $taxes = round($selected->getPrice() * 0.2);
              $total = $selected->getPrice() + $taxes;
            ?>
              <div id="flightSummary" class="flight-summary" style="display: block;">
                <h3>Résumé du vol</h3>
                <div class="summary-content">
                  <div class="summary-flight-info">
                    <div class="summary-airline">
                      <img src="https://via.placeholder.com/50"
                        alt="<?= htmlspecialchars($selected->getAirline()) ?>"
                        class="summary-logo">
                      <div class="summary-airline-details">
                        <div class="summary-airline-name"><?= htmlspecialchars($selected->getAirline()) ?></div>
                        <div class="summary-flight-number"><?= htmlspecialchars($selected->getFlightNumber()) ?></div>
                      </div>
                    </div>
                    <div class="summary-route">
                      <div class="summary-time">
                        <span><?= htmlspecialchars($selected->getDepartureTime()) ?></span> - <span><?= htmlspecialchars($selected->getArrivalTime()) ?></span>
                      </div>
                      <div class="summary-airports">
                        <span><?= htmlspecialchars($selected->getDepartureCode()) ?></span> - <span><?= htmlspecialchars($selected->getArrivalCode()) ?></span>
                      </div>
                      <div class="summary-duration">
                        <?= htmlspecialchars($selected->getDuration()) ?> • <?= $selected->getStops() === 0 ? 'Sans escale' : $selected->getStops() . ' escale' . ($selected->getStops() > 1 ? 's' : '') ?>
                      </div>
                    </div>
                  </div>
                  <div class="summary-divider"></div>
                  <div class="price-details">
                    <div class="price-line">
                      <span>Prix du vol</span>
                      <span>$<?= number_format($selected->getPrice(), 2) ?></span>
                    </div>
                    <div class="price-line">
                      <span>Taxes &amp; Frais</span>
                      <span>$<?= $taxes ?></span>
                    </div>
                    <div class="price-line total">
                      <span>Total</span>
                      <span>$<?= $total ?></span>
                    </div>
                  </div>
                  <button class="btn btn-primary btn-book">Continuer à réserver</button>
                </div>
              </div>
            <?php endif; ?>
          </div>

        </div>
      </div>
    </div>
  </main>

  <?php include_once('inclusions/footer.php'); ?>
</body>

</html>