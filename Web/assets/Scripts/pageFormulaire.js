document.addEventListener('DOMContentLoaded', function() {
    // Formulaire d'informations passager
    const passengerForm = {
      prenom: document.getElementById('prenom'),
      deuxiemePrenom: document.getElementById('deuxieme-prenom'),
      nom: document.getElementById('nom'),
      dateNaissance: document.getElementById('date-naissance'),
      email: document.getElementById('email'),
      telephone: document.getElementById('telephone'),
      recours: document.getElementById('recours')
    };
  
    // Formulaire de contact d'urgence
    const emergencyForm = {
      prenom: document.getElementById('urgence-prenom'),
      nom: document.getElementById('urgence-nom'),
      email: document.getElementById('urgence-email'),
      telephone: document.getElementById('urgence-telephone'),
      sameAsPassenger: document.getElementById('same-as-passenger')
    };
  
    // Compteur de bagages
    const baggageCounter = {
      minusBtn: document.querySelector('.minus-btn'),
      plusBtn: document.querySelector('.plus-btn'),
      counterValue: document.querySelector('.counter-value')
    };
  
    // Boutons d'action
    const submitFormBtn = document.getElementById('submitForm');
    const selectSeatsBtn = document.getElementById('selectSeats');
    const selectSeatsSideBtn = document.querySelector('.select-seats');
  
    // Gestion du compteur de bagages
    let baggageCount = 1;
  
    baggageCounter.minusBtn.addEventListener('click', function() {
      if (baggageCount > 0) {
        baggageCount--;
        updateBaggageCount();
      }
    });
  
    baggageCounter.plusBtn.addEventListener('click', function() {
      if (baggageCount < 3) {
        baggageCount++;
        updateBaggageCount();
      }
    });
  
    function updateBaggageCount() {
      baggageCounter.counterValue.textContent = baggageCount;
      // Désactiver le bouton minus si le compteur est à 0
      if (baggageCount === 0) {
        baggageCounter.minusBtn.disabled = true;
        baggageCounter.minusBtn.classList.add('disabled');
      } else {
        baggageCounter.minusBtn.disabled = false;
        baggageCounter.minusBtn.classList.remove('disabled');
      }
      
      // Désactiver le bouton plus si le compteur est à 3
      if (baggageCount === 3) {
        baggageCounter.plusBtn.disabled = true;
        baggageCounter.plusBtn.classList.add('disabled');
      } else {
        baggageCounter.plusBtn.disabled = false;
        baggageCounter.plusBtn.classList.remove('disabled');
      }
    }
  
    // Gestion de la case à cocher "Pareil au passager 1"
    emergencyForm.sameAsPassenger.addEventListener('change', function() {
      if (this.checked) {
        // Copier les informations du passager vers le contact d'urgence
        emergencyForm.prenom.value = passengerForm.prenom.value;
        emergencyForm.nom.value = passengerForm.nom.value;
        emergencyForm.email.value = passengerForm.email.value;
        emergencyForm.telephone.value = passengerForm.telephone.value;
        
        // Désactiver les champs du contact d'urgence
        emergencyForm.prenom.disabled = true;
        emergencyForm.nom.disabled = true;
        emergencyForm.email.disabled = true;
        emergencyForm.telephone.disabled = true;
      } else {
        // Réactiver les champs du contact d'urgence
        emergencyForm.prenom.disabled = false;
        emergencyForm.nom.disabled = false;
        emergencyForm.email.disabled = false;
        emergencyForm.telephone.disabled = false;
      }
    });
  
    // Validation du formulaire avant soumission
    function validateForm() {
      let isValid = true;
      const requiredFields = [
        passengerForm.prenom,
        passengerForm.nom,
        passengerForm.dateNaissance,
        passengerForm.email,
        passengerForm.telephone
      ];
      
      // Si le contact d'urgence n'est pas le même que le passager, valider ces champs aussi
      if (!emergencyForm.sameAsPassenger.checked) {
        requiredFields.push(
          emergencyForm.prenom,
          emergencyForm.nom,
          emergencyForm.email,
          emergencyForm.telephone
        );
      }
      
      // Vérifier que tous les champs requis sont remplis
      requiredFields.forEach(field => {
        if (!field.value.trim()) {
          field.classList.add('invalid');
          isValid = false;
        } else {
          field.classList.remove('invalid');
        }
      });
      
      // Validation de l'email
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (passengerForm.email.value && !emailRegex.test(passengerForm.email.value)) {
        passengerForm.email.classList.add('invalid');
        isValid = false;
      }
      
      if (!emergencyForm.sameAsPassenger.checked && emergencyForm.email.value && 
          !emailRegex.test(emergencyForm.email.value)) {
        emergencyForm.email.classList.add('invalid');
        isValid = false;
      }
      
      return isValid;
    }
  
    // Gestion de la soumission du formulaire
    submitFormBtn.addEventListener('click', function(e) {
      e.preventDefault();
      
      if (validateForm()) {
        // Préparer les données à envoyer
        const formData = {
          passenger: {
            firstName: passengerForm.prenom.value,
            middleName: passengerForm.deuxiemePrenom.value,
            lastName: passengerForm.nom.value,
            birthDate: passengerForm.dateNaissance.value,
            email: passengerForm.email.value,
            phone: passengerForm.telephone.value,
            recourseNumber: passengerForm.recours.value
          },
          emergencyContact: {
            firstName: emergencyForm.prenom.value,
            lastName: emergencyForm.nom.value,
            email: emergencyForm.email.value,
            phone: emergencyForm.telephone.value,
            sameAsPassenger: emergencyForm.sameAsPassenger.checked
          },
          baggage: {
            count: baggageCount
          }
        };
        
        console.log('Formulaire soumis:', formData);
        alert('Formulaire enregistré avec succès!');
        
        // Ici, vous pourriez envoyer les données à un serveur
        // fetch('/api/booking', {
        //   method: 'POST',
        //   headers: {
        //     'Content-Type': 'application/json',
        //   },
        //   body: JSON.stringify(formData),
        // })
        // .then(response => response.json())
        // .then(data => {
        //   console.log('Success:', data);
        //   window.location.href = 'confirmation.html';
        // })
        // .catch(error => {
        //   console.error('Error:', error);
        // });
      } else {
        alert('Veuillez remplir tous les champs obligatoires correctement.');
      }
    });
  
    // Gestion des boutons de sélection de sièges
    selectSeatsBtn.addEventListener('click', function(e) {
      e.preventDefault();
      if (validateForm()) {
        console.log('Redirection vers la page de sélection des sièges');
        alert('Redirection vers la page de sélection des sièges');
        // window.location.href = 'select-seats.html';
      } else {
        alert('Veuillez remplir tous les champs obligatoires avant de sélectionner les sièges.');
      }
    });
  
    selectSeatsSideBtn.addEventListener('click', function(e) {
      e.preventDefault();
      if (validateForm()) {
        console.log('Redirection vers la page de sélection des sièges');
        alert('Redirection vers la page de sélection des sièges');
        // window.location.href = 'select-seats.html';
      } else {
        alert('Veuillez remplir tous les champs obligatoires avant de sélectionner les sièges.');
      }
    });
  
    // Ajouter l'année courante dans le footer
    const currentYear = new Date().getFullYear();
    const yearElement = document.getElementById('currentYear');
    if (yearElement) {
      yearElement.textContent = currentYear;
    }
  
    // Styles pour les champs invalides
    document.querySelectorAll('input').forEach(input => {
      input.addEventListener('input', function() {
        if (this.classList.contains('invalid')) {
          this.classList.remove('invalid');
        }
      });
    });
  
    // Ajout de style CSS pour les champs invalides
    const style = document.createElement('style');
    style.textContent = `
      .invalid {
        border-color: var(--error-color) !important;
        background-color: rgba(220, 53, 69, 0.05) !important;
      }
      
      .disabled {
        opacity: 0.5;
        cursor: not-allowed !important;
      }
    `;
    document.head.appendChild(style);
  });
  