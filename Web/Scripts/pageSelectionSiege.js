$(document).ready(function () {
  let selectedSeat = "4A";
  let selectedCabinClass = "economy";
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
    selectedSeat = $seat.data("seat");

    updateSelectedSeatDisplay();

    AjaxRequest({
      action: "selectSeat",
      seat: selectedSeat,
      cabin: selectedCabinClass
    });
  });

  $(".cabin-option").on("click", function () {
    const $cabin = $(this);
    const cabinType = $cabin.attr("id");

    if (cabinType === selectedCabinClass) {
      return;
    }

    $(".cabin-option").removeClass("active");
    $cabin.addClass("active");
    selectedCabinClass = cabinType;

    if (cabinType === "business" && !upgradeRequested) {
      upgradeRequested = true;
    }

    updateCabinClassDisplay();

    AjaxRequest({
      action: "selectCabin",
      cabin: selectedCabinClass
    });

    if (selectedCabinClass === "economy") {
      $(".seat.business-seat").removeClass("available").addClass("unavailable");
      $(".seat.economy-seat").removeClass("unavailable").addClass("available");
    } else if (selectedCabinClass === "business") {
      $(".seat.business-seat").removeClass("unavailable").addClass("available");
      $(".seat.economy-seat").removeClass("available").addClass("unavailable");
    }

    // Deselect the seat if it becomes unavailable
    const $selectedSeat = $(".seat.selected");
    if ($selectedSeat.hasClass("unavailable")) {
      $selectedSeat.removeClass("selected").html("");
      selectedSeat = null;
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
    selectedCabinClass = "business";
    updateCabinClassDisplay();

    AjaxRequest({
      action: "upgradeClass",
      cabin: "business",
      payment: "199"
    });
  });

  $("#saveBtn").on("click", function () {
    AjaxRequest(
      {
        action: "saveSeatSelection",
        seat: selectedSeat,
        cabin: selectedCabinClass
      },
      function () {
        alert("Votre sélection de siège a été enregistrée !");
      }
    );
  });

  $("#nextBtn").on("click", function () {
    AjaxRequest(
      {
        action: "proceedToPayment",
        seat: selectedSeat,
        cabin: selectedCabinClass
      },
      function () {
        if (selectedCabinClass === "business") {
          $("#nextBtn").text("Méthode de paiement");
        } else {
          $("#nextBtn").text("Vol suivant");
        }
        alert("Passage à l'étape suivante !");
      }
    );
  });

  function updateSelectedSeatDisplay() {
    $("#selected-seat").text(selectedSeat);
  }

  function updateCabinClassDisplay() {
    if (selectedCabinClass === "business") {
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
});

  