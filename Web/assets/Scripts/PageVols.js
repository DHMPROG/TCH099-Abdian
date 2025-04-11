// Données des vols
const flightData = [
  {
    id: 1,
    airline: 'SkyWings Airlines',
    flightNumber: 'SW 1024',
    departureTime: '08:45',
    departureAirport: 'John F. Kennedy Intl',
    departureCode: 'JFK',
    arrivalTime: '21:30',
    arrivalAirport: 'Heathrow',
    arrivalCode: 'LHR',
    duration: '7h 45m',
    stops: 0,
    price: 749,
    logoUrl: 'https://via.placeholder.com/50'
  },
  {
    id: 2,
    airline: 'BlueStar Airways',
    flightNumber: 'BS 405',
    departureTime: '10:15',
    departureAirport: 'John F. Kennedy Intl',
    departureCode: 'JFK',
    arrivalTime: '23:45',
    arrivalAirport: 'Heathrow',
    arrivalCode: 'LHR',
    duration: '8h 30m',
    stops: 1,
    stopDetails: 'Escale : Paris (CDG) - 1h 45m',
    price: 632,
    logoUrl: 'https://via.placeholder.com/50'
  },
  {
    id: 3,
    airline: 'AirGlobal',
    flightNumber: 'AG 1772',
    departureTime: '14:20',
    departureAirport: 'John F. Kennedy Intl',
    departureCode: 'JFK',
    arrivalTime: '04:15',
    arrivalAirport: 'Heathrow',
    arrivalCode: 'LHR',
    duration: '8h 55m',
    stops: 1,
    stopDetails: 'Escale : Dublin (DUB) - 1h 20m',
    price: 587,
    logoUrl: 'https://via.placeholder.com/50'
  },
  {
    id: 4,
    airline: 'TransAtlantic',
    flightNumber: 'TA 845',
    departureTime: '18:55',
    departureAirport: 'John F. Kennedy Intl',
    departureCode: 'JFK',
    arrivalTime: '07:40',
    arrivalAirport: 'Heathrow',
    arrivalCode: 'LHR',
    duration: '7h 45m',
    stops: 0,
    price: 821,
    logoUrl: 'https://via.placeholder.com/50'
  },
  {
    id: 5,
    airline: 'SkyWings Airlines',
    flightNumber: 'SW 1026',
    departureTime: '22:15',
    departureAirport: 'John F. Kennedy Intl',
    departureCode: 'JFK',
    arrivalTime: '11:05',
    arrivalAirport: 'Heathrow',
    arrivalCode: 'LHR',
    duration: '7h 50m',
    stops: 0,
    price: 694,
    logoUrl: 'https://via.placeholder.com/50'
  }
];

// Éléments DOM
const flightsList = document.getElementById('flightsList');
const flightSummary = document.getElementById('flightSummary');
const priceRangeSlider = document.getElementById('priceRange');
const priceValueDisplay = document.getElementById('priceValue');
const sortBySelectors = document.querySelectorAll('input[name="sort"]');
const airlineCheckboxes = document.querySelectorAll('input[name="airline"]');
const stopCheckboxes = document.querySelectorAll('input[name="stops"]');
const timeFilters = document.querySelectorAll('.time-filter-item');

// État actuel
let currentFlights = [...flightData];
let currentSortBy = 'price';
let selectedFlightId = null;

// Initialiser la page
document.addEventListener('DOMContentLoaded', () => {
  // Afficher les vols
  renderFlights(currentFlights);
  
  // Configurer le curseur de plage de prix
  setupPriceRangeSlider();
  
  // Configurer les bascules et la sélection des détails des vols
  setupEventListeners();
  
  // Configurer le tri
  setupSorting();
  
  // Tri initial
  sortFlights('price');

  // Masquer le résumé du vol initialement
  if (flightSummary) {
    flightSummary.style.display = 'none';
  }
});

// Trier les vols
function sortFlights(sortBy) {
  // ... garder le code existant (logique de tri)
}

// Filtrer les vols
function filterFlights() {
  // ... garder le code existant (logique de filtrage)
  
  // Réafficher les vols après le filtrage
  renderFlights(currentFlights);
  
  // Réinitialiser le vol sélectionné s'il n'est pas dans la liste filtrée
  if (selectedFlightId) {
    const flightStillExists = currentFlights.some(flight => flight.id === selectedFlightId);
    if (!flightStillExists) {
      selectFlight(null);
    }
  }
}

// Gérer la sélection de vol
function selectFlight(flightId) {
  selectedFlightId = flightId;
  
  // Mettre à jour l'interface utilisateur pour afficher le vol sélectionné
  document.querySelectorAll('.flight-card').forEach(card => {
    const cardId = parseInt(card.dataset.flightId);
    
    if (cardId === selectedFlightId) {
      card.classList.add('selected');
      card.querySelector('.select-btn').textContent = 'Sélectionné';
      card.querySelector('.select-btn').classList.add('selected');
    } else {
      card.classList.remove('selected');
      card.querySelector('.select-btn').textContent = 'Sélectionner';
      card.querySelector('.select-btn').classList.remove('selected');
    }
  });
  
  // Afficher ou masquer le résumé du vol
  if (flightId) {
    const selectedFlight = flightData.find(flight => flight.id === flightId);
    if (selectedFlight) {
      renderFlightSummary(selectedFlight);
      flightSummary.style.display = 'block';
      
      // Ajouter une classe au conteneur de la liste des vols pour une mise en page réactive
      document.querySelector('.flights-list-wrapper').classList.add('has-summary');
    }
  } else {
    flightSummary.style.display = 'none';
    document.querySelector('.flights-list-wrapper').classList.remove('has-summary');
  }
}

// Afficher le résumé du vol
function renderFlightSummary(flight) {
  if (!flightSummary) return;
  
  // Calculer les taxes (environ 20 % du prix)
  const taxes = Math.round(flight.price * 0.2);
  const total = flight.price + taxes;
  
  flightSummary.innerHTML = `
    <h3>Résumé du vol</h3>
    <div class="summary-content">
      <div class="summary-flight-info">
        <div class="summary-airline">
          <img src="${flight.logoUrl}" alt="${flight.airline}" class="summary-logo">
          <div class="summary-airline-details">
            <div class="summary-airline-name">${flight.airline}</div>
            <div class="summary-flight-number">${flight.flightNumber}</div>
          </div>
        </div>
        
        <div class="summary-route">
          <div class="summary-time">
            <span>${flight.departureTime}</span> - <span>${flight.arrivalTime}</span>
          </div>
          <div class="summary-airports">
            <span>${flight.departureCode}</span> - <span>${flight.arrivalCode}</span>
          </div>
          <div class="summary-duration">
            ${flight.duration} • ${flight.stops === 0 ? 'Sans escale' : `${flight.stops} Escale${flight.stops > 1 ? 's' : ''}`}
          </div>
        </div>
      </div>
      
      <div class="summary-divider"></div>
      
      <div class="price-details">
        <div class="price-line">
          <span>Prix du vol</span>
          <span>$${flight.price}</span>
        </div>
        <div class="price-line">
          <span>Taxes & Frais</span>
          <span>$${taxes}</span>
        </div>
        <div class="price-line total">
          <span>Total</span>
          <span>$${total}</span>
        </div>
      </div>
      
      <button class="btn btn-primary btn-book">Continuer à réserver</button>
    </div>
  `;
  
  // Ajouter un écouteur d'événement au bouton de réservation
  const bookButton = flightSummary.querySelector('.btn-book');
  if (bookButton) {
    bookButton.addEventListener('click', () => {
      alert(`Réservation du vol ${flight.flightNumber} pour $${total}`);
    });
  }
}

// Afficher les cartes de vol
function renderFlights(flights) {
  flightsList.innerHTML = '';
  
  if (flights.length === 0) {
    flightsList.innerHTML = '<div class="no-results">Aucun vol ne correspond à vos critères. Veuillez ajuster vos filtres.</div>';
    return;
  }
  
  flights.forEach(flight => {
    const flightCard = document.createElement('div');
    flightCard.className = `flight-card ${flight.id === selectedFlightId ? 'selected' : ''}`;
    flightCard.dataset.flightId = flight.id;
    
    flightCard.innerHTML = `
      <div class="flight-card-header">
        <div class="airline-info">
          <img src="${flight.logoUrl}" alt="${flight.airline}" class="airline-logo">
          <div>
            <div class="airline-name">${flight.airline}</div>
            <div class="flight-number">${flight.flightNumber}</div>
          </div>
        </div>
        
        <div class="flight-details">
          <div class="route-info">
            <div class="airport-time">
              <div class="time">${flight.departureTime}</div>
              <div class="code">${flight.departureCode}</div>
              <div class="airport">${flight.departureAirport}</div>
            </div>
            
            <div class="flight-path">
              <div class="duration">${flight.duration}</div>
              <div class="path-line">
                <div class="line"></div>
                <i class="fas fa-plane plane-icon"></i>
                <div class="line"></div>
              </div>
              <div class="stops-info">
                ${flight.stops === 0 
                  ? '<span class="nonstop">Sans escale</span>' 
                  : `<span class="with-stops">${flight.stops} ${flight.stops === 1 ? 'escale' : 'escales'} <i class="fas fa-info-circle info-icon"></i><span class="tooltip">${flight.stopDetails}</span></span>`
                }
              </div>
            </div>
            
            <div class="airport-time">
              <div class="time">${flight.arrivalTime}</div>
              <div class="code">${flight.arrivalCode}</div>
              <div class="airport">${flight.arrivalAirport}</div>
            </div>
          </div>
        </div>
        
        <div class="price-info">
          <div class="price">$${flight.price}</div>
          <button class="btn btn-primary select-btn ${flight.id === selectedFlightId ? 'selected' : ''}">
            ${flight.id === selectedFlightId ? 'Sélectionné' : 'Sélectionner'}
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
          <p>Les détails du vol apparaîtront ici.</p>
        </div>
      </div>
    `;
    
    flightsList.appendChild(flightCard);
  });
}

// Configurer le curseur de plage de prix
function setupPriceRangeSlider() {
  if (priceRangeSlider && priceValueDisplay) {
    // Mettre à jour l'affichage lorsque le curseur change
    priceRangeSlider.addEventListener('input', function() {
      priceValueDisplay.textContent = `$${this.value}`;
      filterFlights();
    });
  }
}

// Configurer les écouteurs d'événements pour le tri
function setupSorting() {
  // ... garder le code existant (écouteurs d'événements pour le tri)
}

// Configurer les écouteurs d'événements
function setupEventListeners() {
  // Sélection de vol
  document.addEventListener('click', function(event) {
    const selectButton = event.target.closest('.select-btn');
    if (selectButton) {
      const card = selectButton.closest('.flight-card');
      const flightId = parseInt(card.dataset.flightId);
      
      // Basculer la sélection
      if (selectedFlightId === flightId) {
        selectFlight(null);
      } else {
        selectFlight(flightId);
      }
    }
    
    // Basculer les détails du vol
    const detailsToggle = event.target.closest('.details-toggle');
    if (detailsToggle) {
      const detailsContent = detailsToggle.nextElementSibling;
      const icon = detailsToggle.querySelector('.toggle-icon');
      
      // Basculer l'affichage
      if (detailsContent.style.display === 'block') {
        detailsContent.style.display = 'none';
        icon.classList.remove('fa-chevron-up');
        icon.classList.add('fa-chevron-down');
      } else {
        detailsContent.style.display = 'block';
        icon.classList.remove('fa-chevron-down');
        icon.classList.add('fa-chevron-up');
      }
    }
  });
  
  // Bouton "Charger plus"
  const loadMoreBtn = document.querySelector('.btn-load-more');
  if (loadMoreBtn) {
    loadMoreBtn.addEventListener('click', function() {
      alert('Chargement de plus de vols...');
      // Dans une vraie application, cela chargerait plus de vols depuis une API
    });
  }
  
  // Filtres de temps
  timeFilters.forEach(filter => {
    filter.addEventListener('click', function() {
      if (this.classList.contains('active')) {
        // Désélectionner si déjà actif
        this.classList.remove('active');
        this.style.borderColor = '';
      } else {
        // Effacer les autres sélections et sélectionner celui-ci
        timeFilters.forEach(f => {
          f.classList.remove('active');
          f.style.borderColor = '';
        });
        this.classList.add('active');
        this.style.borderColor = 'var(--airline-primary)';
      }
      filterFlights();
    });
  });
  
  // Utilisation de jQuery pour la fonctionnalité AJAX (démo)
  $('#flightsList').on('click', '.flight-card', function(e) {
    // Empêcher le déclenchement lors du clic sur des éléments spécifiques
    if (e.target.closest('.details-toggle') || e.target.closest('.flight-details-content')) {
      return;
    }
    
    // Ne pas continuer si on clique sur le bouton de sélection (géré séparément)
    if (e.target.closest('.select-btn')) {
      return;
    }
    
    const flightId = parseInt($(this).data('flight-id'));
    
    // Basculer la sélection
    if (selectedFlightId === flightId) {
      selectFlight(null);
    } else {
      selectFlight(flightId);
      
      // Appel AJAX simulé pour obtenir des détails supplémentaires sur le vol
      $.ajax({
        url: 'https://jsonplaceholder.typicode.com/posts/1',
        method: 'GET',
        success: function(response) {
          console.log('Données supplémentaires sur le vol chargées :', response);
          // Dans une vraie application, cela mettrait à jour l'interface utilisateur avec des données supplémentaires sur le vol
        },
        error: function(error) {
          console.error('Erreur lors du chargement des données du vol :', error);
        }
      });
    }
  });
}
