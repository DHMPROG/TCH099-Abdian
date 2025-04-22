$(document).ready(function () {
  let selectedSeats = [];
  let currentCabin = 'economy';
  let upgradeRequested = false;

  updateSelectedSeatDisplay();
  updateCabinClassDisplay();

  $(".seat").on("click", function () {
    const $seat = $(this);

    if ($seat.hasClass("occupied") || $seat.hasClass("unavailable")) {
      return;
    }

    if ($seat.hasClass("premium") && !upgradeRequested) {
      showUpgradeModal();
      return;
    }

    $(".seat.selected").removeClass("selected").html("");

    $seat.addClass("selected").html('<i class="fas fa-check"></i>');
    selectedSeats.push($seat.data("seat"));

    updateSelectedSeatDisplay();

    AjaxRequest({
      action: "selectSeat",
      seat: $seat.data("seat"),
      cabin: currentCabin
    });
  });

  $(".cabin-option").on("click", function () {
    const $cabin = $(this);
    const cabinType = $cabin.attr("id");

    if (cabinType === currentCabin) {
      return;
    }

    $(".cabin-option").removeClass("active");
    $cabin.addClass("active");
    currentCabin = cabinType;

    if (cabinType === "business" && !upgradeRequested) {
      upgradeRequested = true;
    }

    updateCabinClassDisplay();

    AjaxRequest({
      action: "selectCabin",
      cabin: currentCabin
    });

    if (currentCabin === "economy") {
      $(".seat.business-seat").removeClass("available").addClass("unavailable");
      $(".seat.economy-seat").removeClass("unavailable").addClass("available");
    } else if (currentCabin === "business") {
      $(".seat.business-seat").removeClass("unavailable").addClass("available");
      $(".seat.economy-seat").removeClass("available").addClass("unavailable");
    }

    // Deselect the seat if it becomes unavailable
    const $selectedSeats = $(".seat.selected");
    if ($selectedSeats.hasClass("unavailable")) {
      $selectedSeats.removeClass("selected").html("");
      selectedSeats = [];
      updateSelectedSeatDisplay();
    }
  });

  $("#cancelUpgradeBtn").on("click", function () {
    hideUpgradeModal();
  });

  $("#confirmUpgradeBtn").on("click", function () {
    upgradeRequested = true;
    hideUpgradeModal();

    $(".cabin-option").removeClass("active");
    $("#business").addClass("active");
    currentCabin = "business";
    updateCabinClassDisplay();

    AjaxRequest({
      action: "upgradeClass",
      cabin: "business",
      payment: "199"
    });
  });

  $("#saveBtn").on("click", function () {
    if (selectedSeats.length === 0) {
      alert('Veuillez sélectionner un siège');
      return;
    }

    try {
      const urlParams = new URLSearchParams(window.location.search);
      const flightId = urlParams.get('flightId');

      const response = $.ajax({
        url: "/api/reservations",
        type: "POST",
        data: JSON.stringify({
          flightId,
          seatNumber: selectedSeats[0],
          cabinClass: currentCabin
        }),
        contentType: "application/json",
        headers: {
          "Authorization": `Bearer ${localStorage.getItem('token')}`
        },
        success: function (data) {
          alert("Votre sélection de siège a été enregistrée !");
          window.location.href = '/confirmation.html';
        },
        error: function (error) {
          console.error('Erreur:', error);
          alert('Une erreur est survenue');
        }
      });
    } catch (error) {
      console.error('Erreur:', error);
      alert('Une erreur est survenue');
    }
  });

  $("#nextBtn").on("click", function () {
    AjaxRequest(
      {
        action: "proceedToPayment",
        seat: selectedSeats[0],
        cabin: currentCabin
      },
      function () {
        if (currentCabin === "business") {
          $("#nextBtn").text("Méthode de paiement");
        } else {
          $("#nextBtn").text("Vol suivant");
        }
        alert("Passage à l'étape suivante !");
      }
    );
  });

  function updateSelectedSeatDisplay() {
    const selectedSeatDisplay = $("#selected-seat");
    if (selectedSeats.length > 0) {
      selectedSeatDisplay.text(selectedSeats[0]);
    } else {
      selectedSeatDisplay.text("-");
    }
  }

  function updateCabinClassDisplay() {
    if (currentCabin === "business") {
      $(".premium").addClass("available").removeClass("unavailable");
      $("#nextBtn").text("Méthode de paiement");
    } else {
      if (!upgradeRequested) {
        $(".premium:not(.selected)").removeClass("available").addClass("unavailable");
      }
      $("#nextBtn").text("Vol suivant");
    }
  }

  function showUpgradeModal() {
    $("#upgradeModal").css("display", "block");
    $("#overlay").css("display", "block");
  }

  function hideUpgradeModal() {
    $("#upgradeModal").css("display", "none");
    $("#overlay").css("display", "none");
  }

  function AjaxRequest(data, callback) {
    $.ajax({
      url: "/api/seats",
      type: "POST",
      data: JSON.stringify(data),
      contentType: "application/json",
      success: function (response) {
        console.log("Réponse du serveur :", response);
        if (callback) callback(response);
      },
      error: function (error) {
        console.error("Erreur :", error);
      }
    });
  }

  $(".seat.available").hover(
    function () {
      const seatId = $(this).data("seat");
      $(this).append('<div class="seat-tooltip">' + seatId + '</div>');
    },
    function () {
      $(this).find(".seat-tooltip").remove();
    }
  );

  initializeMoreRows();

  function initializeMoreRows() {
    console.log("Les rangées supplémentaires seraient initialisées ici");
  }

  // Configuration des modèles d'avion
  const aircraftConfigs = {
    'Airbus A320': {
      business: {
        rows: 5,
        layout: '3-aisle-3',
        startRow: 1
      },
      economy: {
        rows: 25,
        layout: '3-aisle-3',
        startRow: 6,
        exitRows: [12, 13]
      }
    },
    'Boeing 737-800': {
      business: {
        rows: 4,
        layout: '3-aisle-3',
        startRow: 1
      },
      economy: {
        rows: 26,
        layout: '3-aisle-3',
        startRow: 5,
        exitRows: [15, 16]
      }
    },
    'Airbus A350': {
      business: {
        rows: 10,
        layout: '3-aisle-3-aisle-3',
        startRow: 1
      },
      economy: {
        rows: 55,
        layout: '3-aisle-3-aisle-3',
        startRow: 11,
        exitRows: [29, 30, 59]
      }
    },
    'Boeing 777-300ER': {
      business: {
        rows: 8,
        layout: '3-aisle-4-aisle-3',
        startRow: 1
      },
      economy: {
        rows: 42,
        layout: '3-aisle-4-aisle-3',
        startRow: 9,
        exitRows: [26, 40]
      }
    }
  };

  // Fonction pour générer une rangée de sièges
  function generateSeatRow(rowNumber, layout, cabinClass) {
    const row = document.createElement('div');
    row.className = 'seat-row';
    row.setAttribute('data-row', rowNumber);

    const layoutArray = layout.split('-');
    let seatLetter = 'A';

    layoutArray.forEach((section, index) => {
      if (section === 'aisle') {
        const aisle = document.createElement('div');
        aisle.className = 'aisle';
        row.appendChild(aisle);
      } else {
        const seatsCount = parseInt(section);
        for (let i = 0; i < seatsCount; i++) {
          const seat = document.createElement('div');
          seat.className = `seat available ${cabinClass}-seat`;
          if (cabinClass === 'business') {
            seat.classList.add('premium');
          }
          seat.dataset.seat = `${rowNumber}${seatLetter}`;
          seat.addEventListener('click', () => toggleSeatSelection(seat));
          row.appendChild(seat);
          seatLetter = String.fromCharCode(seatLetter.charCodeAt(0) + 1);
        }
      }
    });

    return row;
  }

  // Fonction pour générer une section de cabine
  function generateCabinSection(config, cabinClass) {
    const section = document.createElement('div');
    const rowsContainer = document.createElement('div');
    rowsContainer.className = 'seats-grid';

    for (let i = 0; i < config.rows; i++) {
      const rowNumber = config.startRow + i;
      const row = generateSeatRow(rowNumber, config.layout, cabinClass);
      rowsContainer.appendChild(row);

      // Ajouter les séparateurs de rangée de sortie
      if (config.exitRows && config.exitRows.includes(rowNumber)) {
        const exitSeparator = document.createElement('div');
        exitSeparator.className = 'exit-row-separator';
        rowsContainer.appendChild(exitSeparator);
      }
    }

    section.appendChild(rowsContainer);
    return section;
  }

  // Fonction pour générer la carte des sièges complète
  function generateSeatMap(aircraftModel) {
    const config = aircraftConfigs[aircraftModel];
    if (!config) {
      console.error('Modèle d\'avion non supporté');
      return;
    }

    const seatsGrid = document.querySelector('.seats-grid');
    seatsGrid.innerHTML = '';

    // Générer la section business
    const businessSection = generateCabinSection(config.business, 'business');
    seatsGrid.appendChild(businessSection);

    // Ajouter le séparateur entre les classes
    const classSeparator = document.createElement('div');
    classSeparator.className = 'exit-row-separator';
    seatsGrid.appendChild(classSeparator);

    // Générer la section economy
    const economySection = generateCabinSection(config.economy, 'economy');
    seatsGrid.appendChild(economySection);
  }

  // Fonction pour basculer la sélection d'un siège
  function toggleSeatSelection(seat) {
    if (seat.classList.contains('unavailable')) return;

    const seatNumber = seat.dataset.seat;
    const index = selectedSeats.indexOf(seatNumber);

    if (index === -1) {
      selectedSeats.push(seatNumber);
      seat.classList.add('selected');
      seat.innerHTML = '<i class="fas fa-check"></i>';
    } else {
      selectedSeats.splice(index, 1);
      seat.classList.remove('selected');
      seat.innerHTML = '';
    }

    updateSelectedSeatDisplay();
  }

  // Charger les données au chargement de la page
  document.addEventListener('DOMContentLoaded', loadFlightData);

  async function loadFlightData() {
    try {
      const urlParams = new URLSearchParams(window.location.search);
      const flightId = urlParams.get('flightId');

      const response = await fetch(`/api/vols/${flightId}`);
      const flight = await response.json();

      // Mettre à jour les informations du vol
      document.querySelector('.departure h2').textContent = flight.departure_code;
      document.querySelector('.departure p').textContent = flight.departure_airport;
      document.querySelector('.arrival h2').textContent = flight.arrival_code;
      document.querySelector('.arrival p').textContent = flight.arrival_airport;

      const departureDate = new Date(flight.departure_date + 'T' + flight.departure_time);
      const arrivalDate = new Date(flight.arrival_date + 'T' + flight.arrival_time);

      document.querySelector('.departure-date h3').textContent = 
        `${departureDate.toLocaleDateString('fr-FR', { day: 'numeric', month: 'long' })} | ${departureDate.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' })}`;
      document.querySelector('.arrival-date h3').textContent = 
        `${arrivalDate.toLocaleDateString('fr-FR', { day: 'numeric', month: 'long' })} | ${arrivalDate.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' })}`;

      // Charger les sièges réservés
      const reservationsResponse = await fetch(`/api/vols/${flightId}/sieges`);
      const reservedSeats = await reservationsResponse.json();

      // Générer la carte des sièges
      generateSeatMap(flight.aircraft_model);

      // Marquer les sièges réservés
      reservedSeats.forEach(seatNumber => {
        const seat = document.querySelector(`[data-seat="${seatNumber}"]`);
        if (seat) {
          seat.classList.remove('available');
          seat.classList.add('unavailable');
        }
      });
    } catch (error) {
      console.error('Erreur lors du chargement des données:', error);
    }
  }
});

  