<?php
include 'connessione.php';
include 'query.php';
ob_start();
session_start();
if (!isset($_SESSION['loggato']) || $_SESSION['loggato'] != true) {
    header("location: enter.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="../img/icone/favicon.png" type="image/png">
    <title>Social-X</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #E6E6E6;
        }

        .custom-bg {
            background-color: #FFFFFF;
        }

        .container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 90vh;
        }

        h1 {
            font-size: 5rem;
            color: #000000;
            font-weight: bold;
            margin-bottom: 2rem;
            text-align: center;
        }

        p {
            font-size: 2rem;
            color: #333;
            margin-bottom: 3rem;
            text-align: center;
        }

        button {
            font-size: 1.5rem;
            font-weight: bold;
            color: #ffffff;
            background-color: #00a6e9;
            border-radius: 50px;
            padding: 1.5rem 3rem;
            transition: background-color 0.2s ease-in-out;
            margin-bottom: 2rem;
            border: none;
        }

        button:hover {
            background-color: #0093c5;
        }
    </style>
</head>

<body>
    <?php include "header.php"; ?>
    <div class="container">
        <h1>Segnalazione inviata!</h1>
        <p>Grazie per la tua segnalazione. Provvederemo ad analizzarla il prima possibile.</p>
        <a href="home.php" class="btn btn-lg btn-primary">Torna alla home</a>
    </div>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNVQ8bc" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>


<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $motivo = $_POST['motivo'];
    $messaggio = $_POST['messaggio'];
    $utente = $_POST['nome_utente'];
    $segnalatore = $_POST['segnalatore'];

    switch ($motivo) {
        case "spam":
            $motivo='Spam';
            break;
        case "nudo":
            $motivo='Nudo o atti sessuali';
            break;
        case "truffa":
            $motivo='Truffa o frode';
            break;
        case "odio":
            $motivo='Discorsi o simboli che incitano all\'\odio';
            break;
        case "falso":
            $motivo='Informazioni false';
            break;
        case "bullismo":
            $motivo='Bullismo o intimidazioni';
            break;
        case "violenza":
            $motivo='Violenza o organizzazioni pericolose';
            break;
        case "contenuto inappropriato":
            $motivo='Contenuto inappropriato';
            break;
        case "altro":
            $motivo='Altro';
            break;
    }
    

    $subject = 'Segnalazione utente';
    $message = '<html><body>';
    $message .= '<head><title>Segnalazione utente</title></head>';
    $message .= '<h1>'.$segnalatore.' ha segnalato '.$utente.' per '.$motivo.'</h1><br><br>';
    $message .= '<p>Segnalatore: '.$segnalatore.'</p><br>';
    $message .= '<p>Utente segnalato: '.$utente.'</p><br>';
    $message .= '<p>Motivo: '.$motivo.'</p><br>'; 
    $message .= '<p>Informazioni aggiuntive: '.$messaggio.'</p><br>'; 
    $message .= '</n></n></n></n>-------------------------------------</body></html>';
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html; charset=UTF-8" . "\r\n";
    $headers .= 'From: "Luca Visintainer" <visintainer5inc2022@altervista.org>' . "\r\n";
    $res = mail('luca.visintainer@buonarroti.tn.it', $subject, $message, $headers);
}


?>