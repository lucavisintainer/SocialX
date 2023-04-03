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

    function verificaBiografia($biografia)
    {
        //verificare che biografia sia meno di 255
        return strlen($biografia) <= 255;
    }

    function verificaIndirizzo($indirizzo)
    {
        //verificare che indirizzo sia meno di 100
        return strlen($indirizzo) <= 100;
    }
    function verificaTelefono($numeroTelefono)
    {
        //verificare che sia un numero di telefono
        return preg_match("/^(\+?\d{1,3}\s?)?(\d{3,4}[\s.-]?)?\d{7,8}$/", $numeroTelefono);
    }

    function verificaProfessione($professione)
    {
        //verificare che professione sia meno di 255
        return strlen($professione) <= 255;
    }

    $validBiografia = verificaBiografia($biografia);
    $validIndirizzo = verificaIndirizzo($indirizzo);
    $validTelefono = verificaTelefono($numeroTelefono);
    $validProfessione = verificaProfessione($professione);


    if (!$validBiografia) {
        global $error;
        $error = "<div class='alert alert-danger' role='alert'>Campo biografia troppo lungo (max 255 caratteri)</div>";
    } else if (!$validIndirizzo) {
        global $error;
        $error = "<div class='alert alert-danger' role='alert'>Campo indirizzo troppo lungo (max 255 caratteri)</div>";
    } else if (!$validTelefono && $numeroTelefono != "") {
        global $error;
        $error = "<div class='alert alert-danger' role='alert'>Numero di telefono non valido</div>";
    } else if (!$validProfessione) {
        global $error;
        $error = "<div class='alert alert-danger' role='alert'>Campo professione troppo lungo (max 255 caratteri)</div>";
    } else {
        // Esegui la query per aggiornare il profilo dell'utente
        $query = "UPDATE profilo SET email = '$email', biografia = '$biografia', indirizzo = '$indirizzo', numeroTelefono = '$numeroTelefono', professione = '$professione', visibilitaAccount = '$visibilita' WHERE username = '$username'";
        mysqli_query($db_conn, $query);
    }
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
    } else {
        return 'Amici';
    }
}


?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <title>Social-X</title>
    <link rel="icon" href="../img/icone/favicon.png" type="image/png">
    <!-- Inclusione delle librerie Bootstrap e jQuery -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


</head>
<style>
    body {
        background-color: #E6E6E6;
    }
</style>

<body>
    <?php include 'header.php'; ?>
    <div class="container mt-5">
        <h1 class="text-center mb-5">Impostazioni Profilo</h1>
        <?php
        global $error;
        if ($error != "") {
            echo $error;
        }
        ?>
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

            <div class="form-group d-flex justify-content-between">
                <div class="text-left">
                    <input type="submit" value="Indietro" class="btn btn-primary" formaction="area_privata_personale.php">
                </div>
                <div class="text-center">
                    <input type="submit" value="Salva modifiche" name="impostazioni" class="btn btn-primary">
                </div>
                <div class="text-right">
                    <button type='button' class='btn btn-primary btn-danger' data-toggle='modal' data-target='#exampleModalCenter'>Elimina profilo</button>
                </div>
            </div>


        </form>
        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Sei sicuro di voler eliminare il profilo?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="eliminaProfilo.php">
                        <div class="modal-body">
                            <label for="password">Inserisci la tua password:</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                            <span id="error-message" class="text-danger"></span>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Indietro</button>
                            <button type="submit" class="btn btn-primary" name="elimina-profilo">Elimina</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>


    </div><br><br>
    <?php include 'footer.php'; ?>
<script>
    $(document).ready(function() {
        <?php if (isset($_GET['error'])) { ?>
            $('#exampleModalCenter').modal('show');
            $('#error-message').text('<?php echo $_GET['error']; ?>');
        <?php } ?>
    });
</script>




</body>

</html>