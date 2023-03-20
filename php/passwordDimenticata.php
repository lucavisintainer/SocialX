<?php ob_start(); ?>
<!DOCTYPE html>
<html>

<head>
    <link rel="icon" href="../img/icone/favicon.png" type="image/png">
    <meta charset="UTF-8">
    <title>Social Network</title>
    <link rel="stylesheet" type="text/css" href="../css/login.css">
</head>

<body>
    <div class="container" id="container">
        <div class="form-container sign-in-container">
            <form action="" method="POST">
                <h1>Reimposta password</h1>
                <br>
                <input for="username" type="text" id="username" name="username" placeholder="Username o Email" required>
                <br>
                <label style="color: red;" id="errLogin"></label><br>
                <button type="submit" name="recupero" value="recupero">Recupera password</button>
            </form>
        </div>
        <div id="main-container" class="container">
            <div class="overlay-container">
                <div class="overlay">
                    <div class="overlay-panel overlay-right">
                        <h1>Problemi?</h1>
                        <p>Se non ricordi il tuo username o la tua email contattaci!</p>
                        <div style="border: 2px solid white; border-radius: 20px; display: inline-block;">
                            <a style="color: white; text-decoration: none; font-weight: bold; padding: 1px 10px; border-radius: 20px; display: inline-block;" href="mailto:luca.visintainer@buonarroti.tn.it?subject=Recupero account">Contattaci</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
</body>

</html>

<?php
include 'connessione.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['recupero'])) {
    $username_or_email = $db_conn->real_escape_string($_POST['username']);

    $sql_select = "SELECT * FROM profilo WHERE username = '$username_or_email' OR email = '$username_or_email'";
    if ($result = $db_conn->query($sql_select)) {
        if ($result->num_rows == 1) {
            //trovata una corrispondenza db
            $row = $result->fetch_array(MYSQLI_ASSOC);
            //invio mail

            // Destinatario
            $to = $row['email'];

            // Oggetto dell'email
            $subject = "Reimpostazione password";

            // Testo dell'email
            $message = "Ciao, ".$row['username']." per reimpostare la tua password clicca qui. (LINK)";

            // Intestazioni dell'email
            $headers = "From: luca.visintainer@buonarroti.tn.it\r\n";
            $headers .= "Reply-To: luca.visintainer@buonarroti.tn.it\r\n";
            $headers .= "X-Mailer: PHP/" . phpversion();

            // Invia l'email
            mail($to, $subject, $message, $headers);
            header("location: enter.php");
            exit;
        } else {
?>
            <script>
                const errUtente = document.getElementById('errLogin');
                errUtente.innerHTML = "Non ci sono account con questo username";
            </script>
<?php exit;
        }
    }
}

ob_end_flush();
?>