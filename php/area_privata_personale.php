<?php
include 'query.php';
// Abilita l'output buffering
ob_start();
session_start();

if (!isset($_SESSION['loggato']) || $_SESSION['loggato'] != true) {
	header("location: enter.php");

	exit;
}
?>

<!DOCTYPE html>
<html>

<head>
	<title>Profilo utente</title>
	<link rel="stylesheet" type="text/css" href="../css/area_privata_personale.css">
	<link rel="icon" href="../img/icone/favicon.png" type="image/png"> 

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
	<style>
		body {
			background-color: #E6E6E6;
		}
	</style>


</head>

<body>

	<?php
	global $idProfilo;
	$idProfilo = $_SESSION['idProfilo'];
	
	include 'header.php';
	function esiste()
	{
		$idProfilo = $_SESSION['idProfilo'];
		// vedere se esiste una foto profilo con id utente
		$dir = '../img/immaginiProfilo/';
		$extensions = ['jpg', 'jpeg', 'png']; // array delle estensioni delle immagini possibili
		foreach ($extensions as $extension) {
			$src = $dir . $idProfilo . '.' . $extension;
			if (file_exists($src)) {
				return $src;
			}
		}
		return false;
	}

	?>


	<div class="container">
		<div class="left-section">
			<div class="profile-info">
				<img id="profilo-img" src="<?php if (esiste() != false) {
												echo esiste();
											} else {
												echo "../img/icone/upload_immagine_profilo1.jpg";
											} ?>" alt="Foto profilo" name="photo" onclick="caricaImmagineJS()">
	

				<div class="info">
					<h2>Ciao <b><?php echo $_SESSION['username']; ?></b></h2><br>
					<p><b>Username:</b> @<?php echo $_SESSION['username']; ?></p>
					<?php echo biografia($idProfilo); ?>
					
				</div>
			</div>
			

			<div class="user-stats">
				<p><b>Amici:</b> <?php  echo amicizie($idProfilo); ?></p>
				<p><b>Post:</b> <?php echo post($idProfilo); ?></p>
			</div>

			<div class="account-settings">
				<button onclick="window.location.href='caricaPost.php'" class="btn3">CARICA POST</button>
				<button onclick="window.location.href='impostazioni_personale.php'" class="btn3">Impostazioni</button>
			</div>

			<?php if (trovaIDpost($idProfilo) == false) { ?> <br><br><br><br><br><br><br><br> <?php echo "Non sono presenti post";
																			} else {
																				echo mostraPost();
																			}	?>
			<br><br><br><br><br><br><br><br>
		</div>
	</div>

	<?php
	include 'connessione.php';
	function convertToUrl($id)
	{

		$folder = '../img/post/';
		$pattern = $folder . $id . '*';

		$files = glob($pattern);

		if (count($files) > 0) {
			foreach ($files as $file) {
				return '<img src="' . $file . '"';
			}
		}
	}

	function mostraPost(){
		$idProfilo = $_SESSION['idProfilo'];
    $output = "<div class='user-photos'><table>";
    $id_array = trovaIDpost($idProfilo);
    if (!empty($id_array)) {
        rsort($id_array); // ordina gli ID dei post in ordine decrescente
        $img = "";
        $count = 0; // contatore per tenere traccia del numero di foto nella riga corrente
		for ($i = 0; $i < count($id_array); $i++) {
			$img = convertToUrl($id_array[$i]);
			if ($count == 0) {
				// se è la prima foto nella riga corrente, apri una nuova riga e un form per il post
				$output .= "<tr><td>";
				$output .= "<form method='POST' action='visualizzaPost.php'>";
				$output .= "<input type='hidden' name='id_post' value='$id_array[$i]'>";
				$output .= "<button style='border: none;' type='submit'>$img</button>";
				$output .= "</form></td>";
			} elseif ($count == 2) {
				// se è l'ultima foto nella riga corrente, chiudi la riga e il form
				$output .= "<td>";
				$output .= "<form method='POST' action='visualizzaPost.php'>";
				$output .= "<input type='hidden' name='id_post' value='$id_array[$i]'>";
				$output .= "<button style='border: none;' type='submit'>$img</button>";
				$output .= "</form></td></tr>";
				$count = -1;
			} else {
				// altrimenti, aggiungi la foto alla riga corrente e il form
				$output .= "<td>";
				$output .= "<form method='POST' action='visualizzaPost.php'>";
				$output .= "<input type='hidden' name='id_post' value='$id_array[$i]'>";
				$output .= "<button style='border: none;' type='submit'>$img</button>";
				$output .= "</form></td>";
			}
			$count++;
		}
		
    // se ci sono ancora foto in attesa di essere chiuse in una riga, chiudo qui
        if ($count > 0 && $count < 3) {
            $output .= str_repeat("<td></td>", 3 - $count) . "</tr>";
        }
        return $output .= "</table></div>";
    } else {
        return "";
    }
}

	include 'footer.php';
	?>
	
</body>

</html>

<script>
	function caricaImmagineJS() {
		var input = document.createElement('input');
		input.type = 'file';
		input.id = 'fileInput';
		input.accept = 'image/*';

		input.onchange = function(event) {
			// Creo un oggetto FormData con il file selezionato
			var formData = new FormData();
			formData.append('photo', event.target.files[0]);

			// Faccio una chiamata AJAX a caricaFotoProfilo()
			var xhr = new XMLHttpRequest();
			xhr.open('POST', 'caricaFotoProfilo.php', true);

			xhr.onload = function() {
				// Risposta server
				console.log(this.responseText);

			};
			xhr.send(formData);
		};
		input.click();
	}
</script>