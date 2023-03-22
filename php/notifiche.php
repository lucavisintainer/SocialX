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
  <!-- Collegamento ai file JavaScript di Bootstrap -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
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
  <?php
  include 'header.php';
  global $arrayFollowAmico;
  global $arrayFollowData;

  if ($_SESSION['notifiche'] == 0) {
    echo "<br><br><br><br><br><br><br><br><br><div class='container d-flex justify-content-center align-items-center'>
    <div class='text-center notifiche'><h3>Non ci sono nuove notifiche</h3></div></div><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <br><br><br><br>";
  } else {
    echo "<div class='container notifiche'>
            <h3>Notifiche</h3>
              <ul class='list-group'>";

    if (follow() == true) { //se hai richieste di amicizia in sospeso
      for ($i = 0; $i < count($arrayFollowAmico); $i++) {
        echo    "<li class='list-group-item'>Hai ricevuto una richiesta di amicizia da Mario Rossi 
                <div class='btn-group ml-2' role='group'>
                <button type='button'class='btn btn-success'>Accetta</button>
                  <button type='button' class='btn btn-danger'>Rifiuta</button>
                  </div>
                </li>";
      }
    }
    echo        "<li class='list-group-item'>Il tuo post ha ricevuto un like da Mario Rossi
                </li>
                <li class='list-group-item'>Mario Rossiha commentato il tuo post con: ...
                </li> 
              </ul>
          </div><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
  } ?>
  <?php include 'footer.php'; ?>
</body>

</html>

<?php
function follow()
{    //vedere se ci sono richieste di amicizia IN ATTESA
  include 'connessione.php';
  $idProfilo =  $_SESSION['idProfilo'];
  $query = "SELECT * FROM amicizia WHERE fkProfilo2='$idProfilo' AND stato='IN ATTESA'";
  $result = $db_conn->query($query);
  $arrayFollow = array();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) { //itera sui risultati
      global $arrayFollowAmico;
      $arrayFollowAmico[] = $row['fkProfilo1'];   //chi ti ha inviato l'amicizia
      global $arrayFollowData;
      $arrayFollowData[] = $row['data'];   //quando ti ha inviato l'amicizia
    }
    return true;
  } else {
    return false; //Non ci sono richieste di amicizia
  }
}
?>