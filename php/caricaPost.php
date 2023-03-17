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
			background-color: #a5beda;
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
					<label style="color: red;" id="erroreUpload"></label><br>
						<label for="descrizione" name="descrizione" id="descrizione">Descrizione:</label>                     
						<textarea name="descrizione" id="descrizione" rows="3" class="form-control"></textarea>
					</div>			
                    <div>
                    <input type="radio" id="normale" name="tipoPost" value="N" required>
                    <label for="tipoPost">Normale</label>
                <input type="radio" id="pubblicitario" name="tipoPost" value="P" required>
                <label for="tipoPost">Pubblicitario</label><br>
                    </div>			
					<button type="submit" name="submit" value="Carica" class="btn btn-primary">Carica</button>
                    <p><strong>Nota: </strong>Sono permessi solo i formati .jpg, .jpeg., .gif e .png con una size massima di 16 MB.</p>
				</form>
				
			</div>
			<div class="col-md-6">
				<h2>Anteprima immagine</h2>
				<div id="preview"></div>
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
	</script>
	<br><br><br><br><br><br><br><br><br>
	<?php include 'footer.php'; ?>
</body>
</html>
