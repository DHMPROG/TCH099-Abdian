<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1, width=device-width" />
    <title>Accueil - Abdian</title>

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
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    />
    <link rel="stylesheet" href="../assets/CSS/header.css" />
    <link rel="stylesheet" href="../assets/CSS/footer.css" />
    <link rel="stylesheet" href="../assets/CSS/pageSelectionSiege.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  </head>

  <body>
 <?php 
  include_once('inclusions/header.php');

  include_once __DIR__ . "/../modele/dao/VolDao.php";
  include_once __DIR__ . "/../modele/VolClass.php";
  include_once __DIR__ . "/../modele/dao/UserDAO.php";
  $vol_id = isset($_GET['vol_id']) ? $_GET['vol_id'] : null;
   
  $vol = VolDAO::chercher($vol_id); 
   // Appel à la méthode chercher


// Récupération du nombre de passagers depuis le lien
$nb_adultes  = isset($_GET['nb_adultes'])  ? (int)$_GET['nb_adultes']  : 1;
$nb_enfants  = isset($_GET['nb_enfants'])  ? (int)$_GET['nb_enfants']  : 0;
$nb_bebes    = isset($_GET['nb_bebes'])    ? (int)$_GET['nb_bebes']    : 0;
$totalPassagers = $nb_adultes + $nb_enfants + $nb_bebes;

// Récupération des DAO et classes
require_once __DIR__ . '/../modele/dao/PassagerDAO.php';
require_once __DIR__ . '/../modele/dao/ReservationDAO.php';
require_once __DIR__ . '/../modele/passagerClass.php';
require_once __DIR__ . '/../modele/reservationClass.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    // 1. On récupère les données POST
    $passengers = $_POST['passengers'];            // tableau des infos passager
    $seatsRaw   = $_POST['seats']   ?? '';         // ex: "4A,4B,4C"
    $selectedSeats = $seatsRaw === '' 
                     ? [] 
                     : explode(',', $seatsRaw);

    // 2. Pour chaque passager : insert en base + réservation de siège
    foreach ($passengers as $idx => $pData) {
        // Créer l'objet Passager
        $p = new Passager($pData['prenom'],$pData['deuxieme_prenom'],$pData['nom'],
                          $pData['date_naissance'],$pData['email'],
                          $pData['telephone'],$pData['urgence_prenom'],
                          $pData['urgence_nom'],$pData['urgence_email'],
                          $pData['urgence_telephone']);

        // Insère le passager
        PassagerDAO::inserer($p);
        $passagerId = ConnexionBD::getInstance()->lastInsertId(); 

        // Insère la réservation correspondante
        $seat = $selectedSeats[$idx] ?? null;
        $res = new Reservation((int)$passagerId,(int)$vol_id, $seat,date('Y-m-d H:i:s'));
      

        ReservationDAO::inserer($res);
    }

    // Rediriger vers page de confirmation
    header('Location: confirmation.php');
    exit;
}

  ?>

    <main class="main-content">
      <!-- Panneau d'informations sur le vol -->
      <div class="flight-info-panel">
      <?php if ($vol): ?>
    <div class="flight-route">
        <div class="departure">
            <h2><?php echo $vol->getDepartureCode(); ?></h2>
            <p><?php echo $vol->getDepartureAirport(); ?></p>
        </div>
        <div class="route-arrow">
            <i class="fas fa-arrow-right"></i>
        </div>
        <div class="arrival">
            <h2><?php echo $vol->getArrivalCode(); ?></h2>
            <p><?php echo $vol->getArrivalAirport(); ?></p>
        </div>
    </div>
<?php else: ?>
    <p>Erreur : Les informations du vol ne sont pas disponibles.</p>
<?php endif; ?>
        <div class="flight-date">
          <div class="departure-date">
            <h3><?php echo $vol->getDepartureDate() . " | " . $vol->getDepartureTime() ?></h3>
            <p>Départ</p>
          </div>
          <div class="arrival-date">
            <h3><?php echo $vol->getArrivalDate() . " | " . $vol->getArrivalTime() ?></h3>
            <p>Arrivée</p>
          </div>
        </div>
      </div>

      <div class="content-wrapper">
        <!-- Côté gauche : Plan des sièges -->
        <div class="seat-map-container">
        <input type="hidden" name="seats" id="selectedSeatsInput" value="">
          <div class="airplane">
            <div class="airplane-shape">
              <div class="seat-map">
                <div class="row-numbers">
                  <!-- Business Class Rows -->
                  <div class="row-number">1</div>
                  <div class="row-number">2</div>
                  <div class="row-number">3</div>
                  <div class="row-number">4</div>
                  <div class="row-number">5</div>
                  <div class="row-number">6</div>
                  <div class="row-number">7</div>
                  <div class="row-number">8</div>
                  <div class="exit-row-label">
                    <i class="fas fa-door-open"></i>
                    <span>Sortie de secours</span>
                  </div>
                  <div class="row-number">9</div>
                  <div class="row-number">10</div>
                  <div class="row-number">11</div>
                  <div class="row-number">12</div>
                  <div class="row-number">13</div>
                  <div class="row-number">14</div>
                  <div class="row-number">15</div>
                  <div class="exit-row-label">
                    <i class="fas fa-door-open"></i>
                    <span>Sortie de secours</span>
                  </div>
                  <div class="row-number">16</div>
                  <div class="row-number">17</div>
                  <div class="row-number">18</div>
                  <div class="row-number">19</div>
                  <div class="row-number">20</div>
                  <div class="row-number">21</div>
                  <div class="row-number">22</div>
                  <div class="row-number">23</div>
                  <div class="row-number">24</div>
                  <div class="exit-row-label">
                    <i class="fas fa-door-open"></i>
                    <span>Sortie de secours</span>
                  </div>
                </div>
                <div class="seats-grid">  
                  <!-- Business Class Rows: 1 to 8 -->
                  <div class="seat-row" data-row="1">
                    <div
                      class="seat available business-seat premium"
                      data-seat="1A"
                    ></div>
                    <div class="aisle"></div>
                    <div
                      class="seat available business-seat premium"
                      data-seat="1B"
                    ></div>
                    <div
                      class="seat available business-seat premium"
                      data-seat="1C"
                    ></div>
                    <div class="aisle"></div>
                    <div
                      class="seat available business-seat premium"
                      data-seat="1D"
                    ></div>
                  </div>
                  <div class="seat-row" data-row="2">
                    <div
                      class="seat available business-seat premium"
                      data-seat="2A"
                    ></div>
                    <div class="aisle"></div>
                    <div
                      class="seat available business-seat premium"
                      data-seat="2B"
                    ></div>
                    <div
                      class="seat available business-seat premium"
                      data-seat="2C"
                    ></div>
                    <div class="aisle"></div>
                    <div
                      class="seat available business-seat premium"
                      data-seat="2D"
                    ></div>
                  </div>
                  <div class="seat-row" data-row="3">
                    <div
                      class="seat available business-seat premium"
                      data-seat="3A"
                    ></div>
                    <div class="aisle"></div>
                    <div
                      class="seat available business-seat premium"
                      data-seat="3B"
                    ></div>
                    <div
                      class="seat available business-seat premium"
                      data-seat="3C"
                    ></div>
                    <div class="aisle"></div>
                    <div
                      class="seat available business-seat premium"
                      data-seat="3D"
                    ></div>
                  </div>
                  <div class="seat-row" data-row="4">
                    <div
                      class="seat available business-seat premium"
                      data-seat="4A"
                    ></div>
                    <div class="aisle"></div>
                    <div
                      class="seat available business-seat premium"
                      data-seat="4B"
                    ></div>
                    <div
                      class="seat available business-seat premium"
                      data-seat="4C"
                    ></div>
                    <div class="aisle"></div>
                    <div
                      class="seat available business-seat premium"
                      data-seat="4D"
                    ></div>
                  </div>
                  <div class="seat-row" data-row="5">
                    <div
                      class="seat available business-seat premium"
                      data-seat="5A"
                    ></div>
                    <div class="aisle"></div>
                    <div
                      class="seat available business-seat premium"
                      data-seat="5B"
                    ></div>
                    <div
                      class="seat available business-seat premium"
                      data-seat="5C"
                    ></div>
                    <div class="aisle"></div>
                    <div
                      class="seat available business-seat premium"
                      data-seat="5D"
                    ></div>
                  </div>
                  <div class="seat-row" data-row="6">
                    <div
                      class="seat available business-seat premium"
                      data-seat="6A"
                    ></div>
                    <div class="aisle"></div>
                    <div
                      class="seat available business-seat premium"
                      data-seat="6B"
                    ></div>
                    <div
                      class="seat available business-seat premium"
                      data-seat="6C"
                    ></div>
                    <div class="aisle"></div>
                    <div
                      class="seat available business-seat premium"
                      data-seat="6D"
                    ></div>
                  </div>
                  <div class="seat-row" data-row="7">
                    <div
                      class="seat available business-seat premium"
                      data-seat="7A"
                    ></div>
                    <div class="aisle"></div>
                    <div
                      class="seat available business-seat premium"
                      data-seat="7B"
                    ></div>
                    <div
                      class="seat available business-seat premium"
                      data-seat="7C"
                    ></div>
                    <div class="aisle"></div>
                    <div
                      class="seat available business-seat premium"
                      data-seat="7D"
                    ></div>
                  </div>
                  <div class="seat-row" data-row="8">
                    <div
                      class="seat available business-seat premium"
                      data-seat="8A"
                    ></div>
                    <div class="aisle"></div>
                    <div
                      class="seat available business-seat premium"
                      data-seat="8B"
                    ></div>
                    <div
                      class="seat available business-seat premium"
                      data-seat="8C"
                    ></div>
                    <div class="aisle"></div>
                    <div
                      class="seat available business-seat premium"
                      data-seat="8D"
                    ></div>
                  </div>
                  <div class="exit-row-separator"></div>

                  <!-- Economy Class Rows: 9 to 24 -->
                  <div class="seat-row" data-row="9">
                    <div
                      class="seat available economy-seat"
                      data-seat="9A"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="9B"
                    ></div>
                    <div class="aisle"></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="9C"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="9D"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="9E"
                    ></div>
                    <div class="aisle"></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="9F"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="9G"
                    ></div>
                  </div>
                  <div class="seat-row" data-row="10">
                    <div
                      class="seat available economy-seat"
                      data-seat="10A"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="10B"
                    ></div>
                    <div class="aisle"></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="10C"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="10D"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="10E"
                    ></div>
                    <div class="aisle"></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="10F"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="10G"
                    ></div>
                  </div>
                  <div class="seat-row" data-row="11">
                    <div
                      class="seat available economy-seat"
                      data-seat="11A"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="11B"
                    ></div>
                    <div class="aisle"></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="11C"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="11D"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="11E"
                    ></div>
                    <div class="aisle"></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="11F"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="11G"
                    ></div>
                  </div>
                  <div class="seat-row" data-row="12">
                    <div
                      class="seat available economy-seat"
                      data-seat="12A"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="12B"
                    ></div>
                    <div class="aisle"></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="12C"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="12D"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="12E"
                    ></div>
                    <div class="aisle"></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="12F"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="12G"
                    ></div>
                  </div>
                  <div class="seat-row" data-row="13">
                    <div
                      class="seat available economy-seat"
                      data-seat="13A"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="13B"
                    ></div>
                    <div class="aisle"></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="13C"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="13D"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="13E"
                    ></div>
                    <div class="aisle"></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="13F"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="13G"
                    ></div>
                  </div>
                  <div class="seat-row" data-row="14">
                    <div
                      class="seat available economy-seat"
                      data-seat="14A"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="14B"
                    ></div>
                    <div class="aisle"></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="14C"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="14D"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="14E"
                    ></div>
                    <div class="aisle"></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="14F"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="14G"
                    ></div>
                  </div>
                  <div class="seat-row" data-row="15">
                    <div
                      class="seat available economy-seat"
                      data-seat="15A"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="15B"
                    ></div>
                    <div class="aisle"></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="15C"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="15D"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="15E"
                    ></div>
                    <div class="aisle"></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="15F"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="15G"
                    ></div>
                  </div>

                  <div class="exit-row-separator"></div>

                  <div class="seat-row" data-row="16">
                    <div
                      class="seat available economy-seat"
                      data-seat="16A"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="16B"
                    ></div>
                    <div class="aisle"></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="16C"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="16D"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="16E"
                    ></div>
                    <div class="aisle"></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="16F"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="16G"
                    ></div>
                  </div>
                  <div class="seat-row" data-row="17">
                    <div
                      class="seat available economy-seat"
                      data-seat="17A"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="17B"
                    ></div>
                    <div class="aisle"></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="17C"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="17D"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="17E"
                    ></div>
                    <div class="aisle"></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="17F"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="17G"
                    ></div>
                  </div>
                  <div class="seat-row" data-row="18">
                    <div
                      class="seat available economy-seat"
                      data-seat="18A"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="18B"
                    ></div>
                    <div class="aisle"></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="18C"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="18D"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="18E"
                    ></div>
                    <div class="aisle"></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="18F"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="18G"
                    ></div>
                  </div>
                  <div class="seat-row" data-row="19">
                    <div
                      class="seat available economy-seat"
                      data-seat="19A"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="19B"
                    ></div>
                    <div class="aisle"></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="19C"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="19D"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="19E"
                    ></div>
                    <div class="aisle"></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="19F"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="19G"
                    ></div>
                  </div>
                  <div class="seat-row" data-row="20">
                    <div
                      class="seat available economy-seat"
                      data-seat="20A"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="20B"
                    ></div>
                    <div class="aisle"></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="20C"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="20D"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="20E"
                    ></div>
                    <div class="aisle"></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="20F"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="20G"
                    ></div>
                  </div>
                  <div class="seat-row" data-row="21">
                    <div
                      class="seat available economy-seat"
                      data-seat="21A"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="21B"
                    ></div>
                    <div class="aisle"></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="21C"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="21D"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="21E"
                    ></div>
                    <div class="aisle"></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="21F"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="21G"
                    ></div>
                  </div>
                  <div class="seat-row" data-row="22">
                    <div
                      class="seat available economy-seat"
                      data-seat="22A"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="22B"
                    ></div>
                    <div class="aisle"></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="22C"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="22D"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="22E"
                    ></div>
                    <div class="aisle"></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="22F"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="22G"
                    ></div>
                  </div>
                  <div class="seat-row" data-row="23">
                    <div
                      class="seat available economy-seat"
                      data-seat="23A"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="23B"
                    ></div>
                    <div class="aisle"></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="23C"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="23D"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="23E"
                    ></div>
                    <div class="aisle"></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="23F"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="23G"
                    ></div>
                  </div>
                  <div class="seat-row" data-row="24">
                    <div
                      class="seat available economy-seat"
                      data-seat="24A"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="24B"
                    ></div>
                    <div class="aisle"></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="24C"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="24D"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="24E"
                    ></div>
                    <div class="aisle"></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="24F"
                    ></div>
                    <div
                      class="seat available economy-seat"
                      data-seat="24G"
                    ></div>
                  </div>

                  <div class="exit-row-separator"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="seat-legend">
            <div class="legend-item">
              <div class="legend-icon available economy-seat"></div>
              <span>Disponible</span>
            </div>
            <div class="legend-item">
              <div class="legend-icon unavailable"></div>
              <span>Indisponible</span>
            </div>
            <div class="legend-item">
              <div class="legend-icon premium"></div>
              <span>Premium</span>
            </div>
            <div class="legend-item">
              <div class="legend-icon selected">
                <i class="fas fa-check"></i>
              </div>
              <span>Sélectionné</span>
            </div>
            <div class="legend-item">
              <div class="legend-icon occupied business-seat"></div>
              <span>Occupé</span>
            </div>
          </div>
        </div>

        <!-- Côté droit : Sélection de classe et infos passager -->
        <div class="selection-panel">
          <!-- Sélection de classe -->
          <div class="cabin-selection">
            <div class="cabin-option economy active" id="economy">
              <div class="cabin-icon">
                <img
                  src="../assets/img/Sieges Avion Economy.png"
                  alt="Sièges en classe économique"
                />
              </div>
              <div class="cabin-details">
                <h3>
                  Économie <span class="selected-badge">Sélectionné</span>
                </h3>
                <p>
                  Reposez-vous et rechargez-vous pendant votre vol avec un
                  espace pour les jambes étendu, un service personnalisé et un
                  service de repas multi-cours
                </p>
                <ul class="cabin-features">
                  <li>
                    <i class="fas fa-circle text-primary"></i> Système de
                    divertissement intégré
                  </li>
                  <li>
                    <i class="fas fa-circle text-primary"></i> Collations et
                    boissons gratuites
                  </li>
                  <li>
                    <i class="fas fa-circle text-primary"></i> Un bagage à main
                    et un article personnel gratuits
                  </li>
                </ul>
              </div>
            </div>

            <div class="cabin-option business" id="business">
              <div class="cabin-icon">
                <img
                  src="../assets/img/Sieges avion Business.png"
                  alt="Sièges en classe affaires"
                />
              </div>
              <div class="cabin-details">
                <h3>
                  Classe affaires
                  <span class="selected-badge">Sélectionné</span>
                </h3>
                <p>
                  Reposez-vous et rechargez-vous pendant votre vol avec un
                  espace pour les jambes étendu, un service personnalisé et un
                  service de repas multi-cours
                </p>
                <ul class="cabin-features">
                  <li>
                    <i class="fas fa-check text-success"></i> Espace pour les
                    jambes étendu
                  </li>
                  <li>
                    <i class="fas fa-check text-success"></i> Les deux premiers
                    bagages enregistrés gratuits
                  </li>
                  <li>
                    <i class="fas fa-check text-success"></i> Embarquement
                    prioritaire
                  </li>
                  <li>
                    <i class="fas fa-check text-success"></i> Service
                    personnalisé
                  </li>
                  <li>
                    <i class="fas fa-check text-success"></i> Service de
                    nourriture et boissons amélioré
                  </li>
                  <li>
                    <i class="fas fa-check text-success"></i> Sièges inclinables
                    40% de plus que l'économie
                  </li>
                </ul>
              </div>
            </div>
          </div>

          <!-- Infos passager -->
          <div class="passenger-info">
            <div class="passenger-details">
              <div>
                <h4>Passager 1</h4>
                <p><?php echo $prenom ." ". $nom ?></p>
              </div>
              <div>
                <h4>Numéro de siège</h4>
                <p id="selected-seat">4A</p>
              </div>
            </div>
            <div class="action-buttons">
              <button class="btn btn-outline" id="saveBtn">
                Enregistrer et fermer
              </button>
              <button class="btn btn-primary" id="nextBtn">Vol suivant</button>
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
          <p class="sitemap">Nous contacter</p>
        </div>
        <div class="group1">
          <img class="group-icon" alt="" src="../Web/assets/img/Group.png" />
        </div>
      </div>
    </footer>

    <script src="./assets/Scripts/pageSelectionSiege.js"></script>
    <script>
  (function(){
    const maxSeats = <?= $totalPassagers ?>;
    let selected = [];

    document.querySelectorAll('.seat.available').forEach(seatEl => {
      seatEl.addEventListener('click', () => {
        const code = seatEl.dataset.seat;
        const idx = selected.indexOf(code);

        if (idx > -1) {
          // déselection
          selected.splice(idx, 1);
          seatEl.classList.remove('selected');
        } else {
          if (selected.length >= maxSeats) {
            alert(`Vous ne pouvez sélectionner que ${maxSeats} sièges.`);
            return;
          }
          selected.push(code);
          seatEl.classList.add('selected');
        }

        // mettre à jour le champ caché et l'affichage
        document.getElementById('selectedSeatsInput').value = selected.join(',');
        document.getElementById('selected-seat').textContent = selected.join(', ');
      });
    });
  })();
</script>
  </body>
</html>
