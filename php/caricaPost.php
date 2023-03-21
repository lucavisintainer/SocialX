<?php
session_start();
if (!isset($_SESSION['loggato']) || $_SESSION['loggato'] != true) {
	header("location: enter.php");

	exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<link rel="icon" href="../img/icone/favicon.png" type="image/png">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Carica post</title>
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<!-- Font Awesome icons -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css">
	<style>
		body {
			background-color: #E6E6E6;
		}
	</style>
</head>

<body>
	<?php include 'header.php'; ?>
	<br><br>
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<h1>Carica post</h1><br>
				<form action="upload.php" method="post" enctype="multipart/form-data">
					<div class="form-group">
						<input type="file" name="photo" id="fileSelect" class="form-control-file">
					</div>
					<div class="form-group">
						<?php
						if (isset($_GET['errore'])) {
							if ($_GET['errore'] == "erroreEstensione") {
								echo "<div class='alert alert-danger' role='alert'>Errore: estensione non ammessa</div>";
							} else if ($_GET['errore'] == "erroreGrandezza") {
								echo "<div class='alert alert-danger' role='alert'>Errore: la grandezza è superiore al limite consentito</div>";
							} else if ($_GET['errore'] == "erroreDescrizione") {
								echo "<div class='alert alert-danger' role='alert'>Errore: descrizione troppo lunga (max 255 caratteri)</div>";
							} else {
								echo "<div class='alert alert-danger' role='alert'>Errore nel caricamento del post, riprova</div>";
							}
						}
						?>
						<label for="descrizione" name="descrizione" id="descrizione">Descrizione:</label>
						<textarea name="descrizione" id="descrizione" rows="3" class="form-control"></textarea>
					</div>
					<div>
						<input type="radio" id="normale" name="tipoPost" value="N" required onchange="toggleFields()">
						<label for="tipoPost">Normale</label>
						<input type="radio" id="pubblicitario" name="tipoPost" value="P" required onchange="toggleFields()">
						<label for="tipoPost">Pubblicitario</label><br>
					</div>
					<!-- campi per i post pubblicitari -->
					<div id="pubblicitarioFields" style="display:none">
						<label for="barra1">Budget totale:</label>
						<input type="range" id="barra1" name="barra1" min="1" max="200" value="25" step="1">
						<span id="barra1Value"><b>125</span> €</b><br>
						<label for="barra2">Giorni:</label>
						<input type="range" id="barra2" name="barra2" min="1" max="30" value="15" step="1">
						<span id="barra2Value"><b>15</span> giorni</b><br>
					</div>

					<button type="submit" name="submit" value="Carica" class="btn btn-primary">Carica</button>
					<p><strong>Nota: </strong>Sono permessi solo i formati .jpg, .jpeg., .gif e .png con una size massima di 16 MB.</p>
				</form><br>

			</div>
			<div class="col-md-6">
				<h2>Anteprima immagine</h2>
				<div id="preview"></div><br>
			</div>

		</div>
	</div>

	<!-- Bootstrap JavaScript -->
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script>
		$(document).ready(function() {
			$('#fileSelect').change(function() {
				var reader = new FileReader();
				reader.onload = function(e) {
					$('#preview').html('<img src="' + e.target.result + '" class="img-fluid">');
				};
				reader.readAsDataURL(this.files[0]);
			});
		});



		function toggleFields() {
    var pubblicitarioFields = document.getElementById("pubblicitarioFields");
    var map = document.getElementById("map");
    if (document.getElementById("pubblicitario").checked) {
      pubblicitarioFields.style.display = "block";
      map.style.display = "block";
    } else {
      pubblicitarioFields.style.display = "none";
      map.style.display = "none";
    }
  }

  var barra1 = document.getElementById("barra1");
  barra1.addEventListener("input", function() {
    var budget = barra1.value * 5;
    document.getElementById("barra1Value").innerHTML = budget;
  });

  var barra2 = document.getElementById("barra2");
  barra2.addEventListener("input", function() {
    var giorni = barra2.value;
    document.getElementById("barra2Value").innerHTML = giorni;
  });
	</script>



</body>

</html>