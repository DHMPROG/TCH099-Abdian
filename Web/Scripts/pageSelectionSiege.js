$(document).ready(function() {
    // Initial setup
    let selectedSeat = "4A"; // Starting with pre-selected seat 4A
    let selectedCabinClass = "economy"; // Starting with economy class
    let upgradeRequested = false;
    
    // Update the UI to reflect initial state
    updateSelectedSeatDisplay();
    updateCabinClassDisplay();
    
    // Select a seat
    $(".seat").on("click", function() {
      const $seat = $(this);
      
      // Don't allow selection of occupied or unavailable seats
      if ($seat.hasClass("occupied") || $seat.hasClass("unavailable")) {
        return;
      }
      
      // If it's a premium seat and user hasn't upgraded
      if ($seat.hasClass("premium") && !upgradeRequested) {
        showUpgradeModal();
        return;
      }
      
      // Deselect previously selected seat
      $(".seat.selected").removeClass("selected").html("");
      
      // Select the new seat
      $seat.addClass("selected").html('<i class="fas fa-check"></i>');
      selectedSeat = $seat.data("seat");
      
      // Update the display
      updateSelectedSeatDisplay();
      
      // Simulate AJAX call to update seat selection on server
      simulateAjaxRequest({
        action: "selectSeat",
        seat: selectedSeat,
        cabin: selectedCabinClass
      });
    });
    
    // Toggle cabin class
    $(".cabin-option").on("click", function() {
      const $cabin = $(this);
      const cabinType = $cabin.attr("id");
      
      // If the same cabin is clicked again, do nothing
      if (cabinType === selectedCabinClass) {
        return;
      }
      
      // Update selected cabin
      $(".cabin-option").removeClass("active");
      $cabin.addClass("active");
      selectedCabinClass = cabinType;
      
      // If switching to business, auto-upgrade
      if (cabinType === "business" && !upgradeRequested) {
        upgradeRequested = true;
      }
      
      updateCabinClassDisplay();
      
      // Simulate AJAX call to update cabin selection on server
      simulateAjaxRequest({
        action: "selectCabin",
        cabin: selectedCabinClass
      });
    });
    
    // Handle upgrade modal
    $("#cancelUpgradeBtn").on("click", function() {
      hideUpgradeModal();
    });
    
    $("#confirmUpgradeBtn").on("click", function() {
      // Apply upgrade
      upgradeRequested = true;
      hideUpgradeModal();
      
      // Switch to business class
      $(".cabin-option").removeClass("active");
      $("#business").addClass("active");
      selectedCabinClass = "business";
      updateCabinClassDisplay();
      
      // Simulate AJAX call to process upgrade
      simulateAjaxRequest({
        action: "upgradeClass",
        cabin: "business",
        payment: "199"
      });
    });
    
    // Action buttons
    $("#saveBtn").on("click", function() {
      // Simulate saving and redirect
      simulateAjaxRequest({
        action: "saveSeatSelection",
        seat: selectedSeat,
        cabin: selectedCabinClass
      }, function() {
        alert("Your seat selection has been saved!");
      });
    });
    
    $("#nextBtn").on("click", function() {
      // Simulate proceed to next step
      simulateAjaxRequest({
        action: "proceedToPayment",
        seat: selectedSeat,
        cabin: selectedCabinClass
      }, function() {
        // Change button text based on selected cabin
        if (selectedCabinClass === "business") {
          $("#nextBtn").text("Payment method");
        } else {
          $("#nextBtn").text("Next flight");
        }
        alert("Proceeding to the next step!");
      });
    });
    
    // Helper functions
    function updateSelectedSeatDisplay() {
      $("#selected-seat").text(selectedSeat);
    }
    
    function updateCabinClassDisplay() {
      // Update the UI based on cabin class
      if (selectedCabinClass === "business") {
        // Show premium seats as available if upgraded
        $(".premium").addClass("available").removeClass("unavailable");
        $("#nextBtn").text("Payment method");
      } else {
        // Show premium seats as unavailable if not upgraded
        if (!upgradeRequested) {
          $(".premium:not(.selected)").removeClass("available").addClass("unavailable");
        }
        $("#nextBtn").text("Next flight");
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
    
    // Simulate AJAX request
    function AjaxRequest(data, callback) {
      $.ajax({
        url: "/api/seats",
        type: "POST",
        data: JSON.stringify(data),
        contentType: "application/json",
        success: function(response) {
          console.log("Server response:", response);
          if (callback) callback(response);
        },
        error: function(error) {
          console.error("Error:", error);
        }
      });

    }
    
    // Add hover effects for better UX
    $(".seat.available").hover(
      function() {
        const seatId = $(this).data("seat");
        $(this).append('<div class="seat-tooltip">' + seatId + '</div>');
      },
      function() {
        $(this).find(".seat-tooltip").remove();
      }
    );
    
    // Initialize additional rows dynamically (for demo purpose)
    initializeMoreRows();
    
    function initializeMoreRows() {
      // This would populate the remaining rows of the airplane
      // For a real application, this data would come from an API
      console.log("Additional rows would be initialized here");
    }
  });
  