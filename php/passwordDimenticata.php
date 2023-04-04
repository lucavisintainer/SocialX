<?php include 'connessione.php'; ?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Social-X</title>
    <link rel="icon" href="../img/icone/favicon.png" type="image/png">
    <!-- Inclusione dei file CSS di Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<style>
    body {
        background-color: #E6E6E6;
    }
</style>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Password Dimenticata</h4>
                    </div>
                    <div class="card-body">
                        <!-- Form per l'invio dell'email -->
                        <form action="#" method="post">
                            <div class="form-group">
                                <label for="email">Inserisci la tua email:</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Invia</button>
                        </form>
                        <?php
                        if (isset($_POST['email'])) {
                            $email = $_POST['email'];
                            //verifico che la mail esista
                            $sql_select = "SELECT * FROM profilo WHERE email = '$email'";
                            if ($result = $db_conn->query($sql_select)) {
                                if ($result->num_rows == 1) {
                                    //trovata una corrispondenza db
                                    $row = $result->fetch_array(MYSQLI_ASSOC);
                                    $idUsername = $row['idProfilo'];
                                    $username = $row['username'];
                                    // Genero un token casuale e un timestamp
                                    $token = bin2hex(random_bytes(16));
                                    $timestamp = date("Y-m-d H:i:s");
                                    $query = "INSERT INTO passwordResetToken(fkProfilo,token,dataCreazione) VALUES('5','IIII','$timestamp');";
                                    mysqli_query($db_conn, $query);

                                    // Invio email con il link di ripristino password
                                    $url = "http://visintainer5inc2022.altervista.org/ripristinaPassword.php?token=$token";
                                    $subject = 'Reset password';
                                    $message = '<html><body>';
                                    $message .= '<head><title>Reset Password</title></head>';
                                    $message .= '<h1>Ciao ' . $username . '!</n></n></h1>';
                                    $message .= '<p>Per reimpostare la password clicca qui: <a href="' . $url . '">reset password</a></p>';
                                    $message .= '</n>Attenzione: il link ha una validità di 24 ore';
                                    $message .= '</n></n></n></n></body></html>';
                                    $headers = "MIME-Version: 1.0" . "\r\n";
                                    $headers .= "Content-type:text/html; charset=UTF-8" . "\r\n";
                                    $headers .= 'From: "Luca Visintainer" <visintainer5inc2022@altervista.org>' . "\r\n";
                                    $res = mail($_POST['email'], $subject, $message, $headers);



                                    // Messaggio di conferma
                                    echo '<div class="alert alert-success mt-3">Email inviata! Controlla la tua casella di posta.</div>';
                                } else {
                                    echo '<div class="alert alert-danger mt-3">Errore! Controlla i dati inseriti e riprova.</div>';
                                }
                            } else {
                                echo '<div class="alert alert-danger mt-3">Errore! Controlla i dati inseriti e riprova.</div>';
                            };
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Inclusione dei file JavaScript di Bootstrap -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<?php
include 'footer.php';
?>

</html>