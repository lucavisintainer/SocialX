<?php
session_start();
if (!isset($_SESSION['loggato']) || $_SESSION['loggato'] != true) {
    header("location: enter.php");
    exit;
}

include 'connessione.php';

// Controlla se l'utente ha inviato un form di modifica
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['impostazioni'])) {
    $username = $_SESSION['username'];
    $email = strtolower($_POST['email']);
    $biografia = $_POST['biografia'];
    $indirizzo = $_POST['indirizzo'];
    $numeroTelefono = $_POST['telefono'];
    $professione = $_POST['professione'];
    $visibilita = $_POST['visibilita'];


    // Esegui la query per aggiornare il profilo dell'utente
    $query = "UPDATE profilo SET email = '$email', biografia = '$biografia', indirizzo = '$indirizzo', numeroTelefono = '$numeroTelefono', professione = '$professione', visibilitaAccount = '$visibilita' WHERE username = '$username'";
    mysqli_query($db_conn, $query);
}

// Recupera i dati del profilo dell'utente
$username = $_SESSION['username'];
$query = "SELECT * FROM profilo WHERE username = '$username'";
$result = mysqli_query($db_conn, $query);
$row = mysqli_fetch_assoc($result);
$email = $row['email'];
$biografia = $row['biografia'];
$indirizzo = $row['indirizzo'];
$numeroTelefono = $row['numeroTelefono'];
$professione = $row['professione'];
$visibilitaAccount = $row['visibilitaAccount'];
$dataIscrizione = $row['dataIscrizione'];
$ultimoAccesso = $row['ultimoAccesso'];

// Funzione per visualizzare la visibilità dell'account
function visibilitaAccount($visibilitaAccount)
{
    if ($visibilitaAccount == 'T') {
        return 'Tutti';
    } else if ($visibilitaAccount == 'A') {
        return 'Amici';
    } else {
        return 'Amici di amici';
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Impostazioni Profilo</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<style>
		body {
			background-color: #a5beda;
		}
	</style>
<body>
    <?php include 'header.php'; ?>
    <div class="container mt-5">
        <h1 class="text-center mb-5">Impostazioni Profilo</h1>
        <form method="POST">

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control" value="<?php echo $email ?>" required>
            </div>

            <div class="form-group">
                <label for="biografia">Biografia:</label>
                <textarea id="biografia" name="biografia" class="form-control"><?php echo $biografia ?></textarea>
            </div>

           
            <div class="form-group">
            <label for="indirizzo">Indirizzo:</label>
            <input type="text" id="indirizzo" name="indirizzo" class="form-control" value="<?php echo $indirizzo ?>">
        </div>

        <div class="form-group">
            <label for="telefono">Numero di telefono:</label>
            <input type="tel" id="telefono" name="telefono" class="form-control" value="<?php echo $numeroTelefono ?>">
        </div>

        <div class="form-group">
            <label for="professione">Professione:</label>
            <input type="text" id="professione" name="professione" class="form-control" value="<?php echo $professione ?>">
        </div>

        <div class="form-group">
            <label for="visibilita">Visibilità dell'account:</label>
            <select id="visibilita" name="visibilita" class="form-control">
                <option value="T" <?php if ($visibilitaAccount == 'T') echo 'selected' ?>>Tutti</option>
                <option value="A" <?php if ($visibilitaAccount == 'A') echo 'selected' ?>>Amici</option>
                <option value="AA" <?php if ($visibilitaAccount == 'AA') echo 'selected' ?>>Amici di amici</option>
            </select>
        </div>


        <div class="form-group">
            <label for="dataIscrizione">Data di iscrizione:</label>
            <input type="text" id="dataIscrizione" name="dataIscrizione" class="form-control" value="<?php echo $dataIscrizione ?>" readonly>
        </div>

        <div class="form-group">
            <label for="ultimoAccesso">Ultimo accesso:</label>
            <input type="text" id="ultimoAccesso" name="ultimoAccesso" class="form-control" value="<?php echo $ultimoAccesso ?>" readonly>
        </div>

        <div class="form-group">
        <input type="submit" value="Indietro" class="btn btn-primary" formaction="area_privata_personale.php">
            <input type="submit" value="Salva modifiche" name="impostazioni" class="btn btn-primary">
        </div>


    </form>
</div><br><br>
<?php include 'footer.php'; ?>
</body>
</html>