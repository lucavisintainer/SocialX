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
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifiche - SocialX</title>
    <link rel="icon" href="../img/icone/favicon.png" type="image/png">
    <!-- Collegamento ai file CSS di Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<style>
    body {
        background-color: #E6E6E6;
    }

    .notifiche {
        margin-top: 30px;
    }

    .notifiche h3 {
        margin-bottom: 20px;
    }

    .notifiche .list-group-item {
        position: relative;
    }

    .notifiche .btn-group {
        position: absolute;
        top: 50%;
        right: 0;
        transform: translateY(-50%);
    }
    

</style>

<body>
    <?php include 'header.php'; ?>
    <div class="container notifiche">
  <h3>Notifiche</h3>
  <ul class="list-group">
    <li class="list-group-item">
      Hai ricevuto una richiesta di amicizia da Mario Rossi
      <div class="btn-group ml-2" role="group">
        <button type="button" class="btn btn-success">Accetta</button>
        <button type="button" class="btn btn-danger">Rifiuta</button>
      </div>
    </li>
    <li class="list-group-item">Il tuo post ha ricevuto un like da Mario Rossi</li>
    <li class="list-group-item">Mario Rossi ha commentato il tuo post con: ...</li>
  </ul>
</div>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  <!-- Collegamento ai file JavaScript di Bootstrap -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <?php include 'footer.php'; ?>
</body>

</html>