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
	<link
		rel="stylesheet"
		href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
	<link rel="stylesheet" href="../CSS/index.css" />
	<link rel="stylesheet" href="../CSS/header.css" />
	<link rel="stylesheet" href="../CSS/footer.css" />



</head>

<body>
	<?php
	include_once('inclusions/header.php');
	?>

	<main>
		<form class="recherche" action="index.php" method="GET">
			<input type="hidden" name="action" value="rechercherVols">
			<div class="aller">
				<div class="aller-child">
					<div class="tab">
						<b class="de">De</b>
						<input type="text" name="depart" class="text_area" placeholder="Ville de Départ" required autocomplete="off">
						<div class="suggestions" id="suggestions-depart"></div>
					</div>
				</div>

			</div>
			<div class="arrive">
				<div class="arrive-child"></div>
				<div class="tab1">
					<b class="b">À</b>
					<input type="text" name="arrivee" class="text_area" placeholder="Ville d'Arrivée" required autocomplete="off">
					<div class="suggestions" id="suggestions-arrivee"></div>
				</div>
			</div>
			<div class="depart">
				<div class="depart-child">
					<b class="depart">Départ</b>
					<input type="date" name="date_depart" class="date-picker" required>
				</div>
			</div>
			<div class="retour">
				<div class="retour-child"></div>
				<b class="retour1">Retour</b>
				<input type="date" name="date_retour" class="date-picker" required>
			</div>
			<div class="nb-passagers">
				<img class="person-solid-icon" alt="" src="../assets/img/person solid.png">
				<div class="nombre-de-passagers">Nombre de Passagers</div>
				<div class="popover-increment">
					<<div class="row">
						<div class="label2">Adultes:</div>
						<div class="incrementer">
							<button type="button" class="bouton minus-btn" onclick="updateValue(false,'#adulte', 'input-adulte')">-</button>
							<div class="value" id="adulte">1</div>
							<button type="button" class="bouton plus-btn" onclick="updateValue(true,'#adulte', 'input-adulte')">+</button>
						</div>
						<input type="hidden" name="nb_adultes" id="input-adulte" value="1">
				</div>

				<div class="row">
					<div class="label2">Enfants:</div>
					<div class="incrementer">
						<button type="button" class="bouton minus-btn" onclick="updateValue(false,'#enfant', 'input-enfant')">-</button>
						<div class="value" id="enfant">1</div>
						<button type="button" class="bouton plus-btn" onclick="updateValue(true,'#enfant', 'input-enfant')">+</button>
					</div>
					<input type="hidden" name="nb_enfants" id="input-enfant" value="1">
				</div>

				<div class="row">
					<div class="label2">Bébés:</div>
					<div class="incrementer">
						<button type="button" class="bouton minus-btn" onclick="updateValue(false,'#bebe', 'input-bebe')">-</button>
						<div class="value" id="bebe">1</div>
						<button type="button" class="bouton plus-btn" onclick="updateValue(true,'#bebe', 'input-bebe')">+</button>
					</div>
					<input type="hidden" name="nb_bebes" id="input-bebe" value="1">
				</div>
			</div>
			</div>
			<button type="submit" class="recherche1">
				<b>Recherche</b>
			</button>
		</form>
		<div class="page-daccueil">
			<div class="image-destinations">
				<div class="bora-bora">
					<img class="bora-bora-child" alt="" src="../assets/img/Rectangle 11.png">

					<div class="bora-bora1">BORA BORA</div>
				</div>
				<div class="paris">
					<img class="bora-bora-child" alt="" src="../assets/img/Rectangle 14.jpg">

					<div class="paris1">PARIS</div>
				</div>
				<div class="berne">
					<img class="bora-bora-child" alt="" src="../assets/img/Rectangle 13.png">

					<div class="berne1">BERNE</div>
				</div>
				<div class="alger">
					<img class="bora-bora-child" alt="" src="../assets/img/Rectangle 12.png">

					<div class="alger1">
						<p class="sitemap">ALGER</p>
					</div>
				</div>
				<div class="tokyo">
					<img class="bora-bora-child" alt="" src="../assets/img/Rectangle 15.png">

					<div class="tokyo1">TOKYO</div>
				</div>
			</div>
			<div class="scroll-buttons">
				<div class="scroll-left fa-solid fa-arrow-left" onclick="allerAGauche()"></div>
				<div class="scroll-right fa-solid fa-arrow-right" onclick="scrollRight()"></div>
			</div>

	</main>
	<?php
	include_once('inclusions/footer.php');
	?>
	<script>
		function updateValue(isIncrement, idName, indexButton) {
			const valueElement = document.querySelector(idName);
			let currentValue = parseInt(valueElement.textContent, 10) || 0;
			// Use the idName directly
			if (!valueElement) return console.log('Id non trouvé'); // Ensure the element exists
			if (valueElement) {
				currentValue += isIncrement ? 1 : -1;
				valueElement.textContent = currentValue;
				document.getElementsByClassName('minus-btn')[indexButton].disabled = false;
			}
			if (currentValue <= 0) {
				document.getElementsByClassName('minus-btn')[indexButton].disabled = true;
				currentValue += isIncrement ? 1 : 0; // Prevent negative values
				valueElement.textContent = currentValue;
			}
		}

		function allerAGauche() {
			const container = document.querySelector('.image-destinations');
			container.scrollBy({
				left: -300, // distance à défiler en px
				behavior: 'smooth'
			});
		}

		function scrollRight() {
			const container = document.querySelector('.image-destinations');
			container.scrollBy({
				left: 300, // distance à défiler en px
				behavior: 'smooth'
			});
		}


		const aeroports = [{
				"nom": "Montréal Trudeau",
				"code": "YUL"
			},
			{
				"nom": "Paris Charles-de-Gaulle",
				"code": "CDG"
			},
			{
				"nom": "Toronto Pearson",
				"code": "YYZ"
			},
			{
				"nom": "Newark Liberty",
				"code": "EWR"
			},
			{
				"nom": "Londres Heathrow",
				"code": "LHR"
			},
			{
				"nom": "Francfort",
				"code": "FRA"
			},
			{
				"nom": "Amsterdam Schiphol",
				"code": "AMS"
			},
			{
				"nom": "New York JFK",
				"code": "JFK"
			},
			{
				"nom": "Los Angeles International",
				"code": "LAX"
			},
			{
				"nom": "Chicago O'Hare",
				"code": "ORD"
			},
			{
				"nom": "Atlanta Hartsfield-Jackson",
				"code": "ATL"
			},
			{
				"nom": "Miami International",
				"code": "MIA"
			},
			{
				"nom": "San Francisco International",
				"code": "SFO"
			},
			{
				"nom": "Dallas/Fort Worth International",
				"code": "DFW"
			},
			{
				"nom": "Seattle-Tacoma International",
				"code": "SEA"
			},
			{
				"nom": "Boston Logan International",
				"code": "BOS"
			},
			{
				"nom": "Philadelphia International",
				"code": "PHL"
			},
			{
				"nom": "Denver International",
				"code": "DEN"
			},
			{
				"nom": "Houston George Bush Intercontinental",
				"code": "IAH"
			},
			{
				"nom": "Alger - Houari Boumédiène",
				"code": "ALG"
			},
			{
				"nom": "Tokyo Narita",
				"code": "NRT"
			},
			{
				"nom": "Tokyo Haneda",
				"code": "HND"
			},
			{
				"nom": "Osaka Kansai",
				"code": "KIX"
			},
			{
				"nom": "Séoul Incheon",
				"code": "ICN"
			},
			{
				"nom": "Pékin Capital",
				"code": "PEK"
			},
			{
				"nom": "Shanghai Pudong",
				"code": "PVG"
			},
			{
				"nom": "Hong Kong International",
				"code": "HKG"
			},
			{
				"nom": "Bangkok Suvarnabhumi",
				"code": "BKK"
			},
			{
				"nom": "Dubaï International",
				"code": "DXB"
			},
			{
				"nom": "Abou Dabi International",
				"code": "AUH"
			},
			{
				"nom": "Doha Hamad International",
				"code": "DOH"
			},
			{
				"nom": "Kuala Lumpur International",
				"code": "KUL"
			},
			{
				"nom": "Singapour Changi",
				"code": "SIN"
			},
			{
				"nom": "Jakarta Soekarno-Hatta",
				"code": "CGK"
			},
			{
				"nom": "Bora Bora Motu Mute",
				"code": "BOB"
			},
			{
				"nom": "Berne Belp",
				"code": "BRN"
			},
			{
				"nom": "Zurich",
				"code": "ZRH"
			},
			{
				"nom": "Genève",
				"code": "GVA"
			},
			{
				"nom": "Lausanne",
				"code": "QLS"
			},
			{
				"nom": "Lucerne",
				"code": "LUZ"
			},
			{
				"nom": "Lugano",
				"code": "LUG"
			},
			{
				"nom": "Bâle-Mulhouse",
				"code": "BSL"
			},
			{
				"nom": "Nice Côte d'Azur",
				"code": "NCE"
			},
			{
				"nom": "Marseille Provence",
				"code": "MRS"
			}

		];

		function setupAutocomplete(inputName, suggestionDivId) {
			const input = document.querySelector(`input[name="${inputName}"]`);
			const suggestionBox = document.getElementById(suggestionDivId);

			input.addEventListener("input", () => {
				const value = input.value.toLowerCase();
				suggestionBox.innerHTML = "";

				if (value.trim().length === 0) return;

				const matches = aeroports.filter(a =>
					a.nom.toLowerCase().includes(value) || a.code.toLowerCase().includes(value)
				);

				matches.forEach(a => {
					const item = document.createElement("div");
					item.textContent = `${a.nom} (${a.code})`;
					item.onclick = () => {
						input.value = a.code;
						suggestionBox.innerHTML = "";
					};
					suggestionBox.appendChild(item);
				});
			});

			document.addEventListener("click", (e) => {
				if (!input.contains(e.target) && !suggestionBox.contains(e.target)) {
					suggestionBox.innerHTML = "";
				}
			});
		}

		setupAutocomplete("depart", "suggestions-depart");
		setupAutocomplete("arrivee", "suggestions-arrivee");

		function updateValue(isIncrement, displayId, inputId) {
			const valueDiv = document.querySelector(displayId);
			const inputHidden = document.getElementById(inputId);
			let currentValue = parseInt(valueDiv.innerText);

			if (isIncrement) {
				currentValue++;
			} else if (currentValue > 0) {
				currentValue--;
			}

			valueDiv.innerText = currentValue;
			inputHidden.value = currentValue;
		}
	</script>


</body>

</html>