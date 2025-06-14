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
	<link rel="stylesheet" href="../CSS/pagePayement.css" />
	<link rel="stylesheet" href="../CSS/header.css"/>
	<link rel="stylesheet" href="../CSS/footer.css" />





</head>

<body>
    <?php
    $seat = $selectedSeats[$idx] ?? null;
    $res  = new Reservation(
        $passagerId,
        $vol_id,
        $seat,
        date('Y-m-d H:i:s')
    );
    ReservationDAO::inserer($res);
    ?>
	<?php
	include_once('inclusions/header.php');
	?>
<main>
    <div class="container">
        <div class="payment-section">
            <h2>Méthode de Paiement</h2>
            <p class="subtitle">Sélectionnez une méthode de paiement ci-dessous. Votre paiement est crypté de bout en bout.</p>
            
            <div class="payment-methods">
                <button class="payment-method active" data-method="credit-card">
                    <i class="fas fa-credit-card"></i>
                    Carte de Crédit
                </button>
                <button class="payment-method" data-method="google-pay">
                    <i class="fab fa-google-pay"></i>
                    Google Pay
                </button>
                <button class="payment-method" data-method="apple-pay">
                    <i class="fab fa-apple-pay"></i>
                    Apple Pay
                </button>
                <button class="payment-method" data-method="paypal">
                    <i class="fab fa-paypal"></i>
                    PayPal
                </button>
                <button class="payment-method" data-method="crypto">
                    <i class="fas fa-coins"></i>
                    Crypto
                </button>
            </div>
    
            <div class="credit-card-form" id="creditCardForm">
                <div class="form-checkbox">
                    <input type="checkbox" id="sameAddress" checked>
                    <label for="sameAddress">Adresse de facturation identique au Passager 1</label>
                </div>
    
                <div class="form-group">
                    <input type="text" id="cardName" placeholder="Nom sur la carte" required>
                </div>
    
                <div class="form-group">
                    <input type="text" id="cardNumber" placeholder="Numéro de carte" required>
                </div>
    
                <div class="form-row">
                    <div class="form-group">
                        <input type="text" id="expiryDate" placeholder="MM/AA" required>
                    </div>
                    <div class="form-group">
                        <input type="text" id="cvv" placeholder="CVV" required>
                        <div class="cvv-tooltip">?</div>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="summary-section">
            <div class="flight-details">
                <div class="flight-item">
                    <div class="airline-info">
                        <img src="airline-logo.png" alt="Logo de la Compagnie Aérienne">
                        <div class="flight-text">
                            <h3>Hawaiian Airlines</h3>
                            <p>FIG4312</p>
                        </div>
                    </div>
                    <div class="flight-time">
                        <p>16h 45m (+1j)</p>
                        <p>7:00 AM - 4:15 PM</p>
                        <p class="duration">2h 45m à HNL</p>
                    </div>
                </div>
            </div>
    
            <div class="price-summary">
                <div class="price-row">
                    <span>Amélioration de siège</span>
                    <span>199 $</span>
                </div>
                <div class="price-row">
                    <span>Sous-total</span>
                    <span>702 $</span>
                </div>
                <div class="price-row">
                    <span>Taxes et Frais</span>
                    <span>66 $</span>
                </div>
                <div class="price-row total">
                    <span>Total</span>
                    <span>768 $</span>
                </div>
            </div>
    
            <button class="confirm-button">Confirmer et payer</button>
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
<script src="../Scripts/pagePayement.js"></script>

</body>

</html>