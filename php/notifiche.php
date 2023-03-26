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
  <title>SocialX</title>
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
  global $arrayIdCommenti;
  global $arrayDataCommenti;
  global $arrayIdLike;
  global $arrayDataLike;

  if ($_SESSION['notifiche'] == 0) {
    echo "<br><br><br><br><br><br><br><br><br><br><br><br><div class='container d-flex justify-content-center align-items-center'>
    <div class='text-center notifiche'><h3>Non ci sono nuove notifiche</h3></div></div><br><br><br><br><br><br><br><br><br><br>
    <br><br><br><br>";
  } else {
    echo "<div class='container notifiche'>
            <h3>Notifiche</h3>
              <ul class='list-group'>";

    if (follow() == true) { //se hai richieste di amicizia in sospeso
      for ($i = 0; $i < count($arrayFollowAmico); $i++) {
        $datetime = new DateTime($arrayFollowData[$i]);
        $formattedDate = $datetime->format('d/m/Y H:i');
        echo    "<li class='list-group-item'><strong>".$formattedDate."</strong>: Hai ricevuto una richiesta di amicizia da <a href='paginaUtente.php?id=".$arrayFollowAmico[$i]."'> <b>" . idProfiloToUsername($arrayFollowAmico[$i]) . "</b></a>
                <div class='btn-group ml-2' role='group'>
                <form method='post' action=''>
                <button type='submit' value=" . $arrayFollowAmico[$i] . " name='accettaAmicizia' class='btn btn-success'>Accetta</button>
               <button type='submit' value=" . $arrayFollowAmico[$i] . " name='rifiutaAmicizia' class='btn btn-danger'>Rifiuta</button>
               </form>
               </div>
                </li>";
      }
    }

    if (commenti() == true) {   //se hai commenti nuovi
      for ($i = 0; $i < count($arrayIdCommenti); $i++) {
        $datetime = new DateTime($arrayDataCommenti[$i]);
        $formattedDate = $datetime->format('d/m/Y H:i');

        echo "<li class='list-group-item'>
        <strong>".$formattedDate.":"."</strong><a href='paginaUtente.php?id=".autoreCommento($arrayIdCommenti[$i])."'><b>" . " ".idProfiloToUsername(autoreCommento($arrayIdCommenti[$i])) .
          "</b></a> ha commentato il tuo <a href='visualizzaPost.php?id_post=" . idCommentoToIdPost($arrayIdCommenti[$i]) . "'><b>post</b></a>: 
                " . testoCommento($arrayIdCommenti[$i]) .
          "<div class='btn-group ml-0' style='left: 1070px;' role='group'>
                <a href='eliminaNotifica.php?idAzione=".$arrayIdCommenti[$i]."&tipo=commento'>
                 <img src='../img/icone/delete.png' width='25' height='25'>
               </a>
            </div>           
                </li>";
      }
    }
    if (like() == true) {   //se hai like nuovi
      for ($i = 0; $i < count($arrayIdLike); $i++) {
        $datetime = new DateTime($arrayDataLike[$i]);
        $formattedDate = $datetime->format('d/m/Y H:i');
    echo "<li class='list-group-item'><strong>".$formattedDate."</strong>: Il tuo <a href='visualizzaPost.php?id_post=" . idLikeToIdPost($arrayIdLike[$i]).
     "'><b>post</b></a> ha ricevuto un like da <a href='paginaUtente.php?id=".autoreLike($arrayIdLike[$i])."'><b>" . idProfiloToUsername(autoreLike($arrayIdLike[$i])) .
    "</b></a>
    <div class='btn-group ml-0' style='left: 1070px;' role='group'>
    <a href='eliminaNotifica.php?idAzione=".$arrayIdLike[$i]."&tipo=like'>
     <img src='../img/icone/delete.png' width='25' height='25'>
   </a>
  </div>
    </li>";


      }
  }       
    echo         "</ul>
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

function commenti()
{
  include 'connessione.php';
  $idProfilo =  $_SESSION['idProfilo'];
  $query = "SELECT * FROM notifiche WHERE fkProfilo='$idProfilo' AND tipo='COMMENT' AND view='0'";
  $result = $db_conn->query($query);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) { //itera sui risultati
      global $arrayIdCommenti;
      $arrayIdCommenti[] = $row['idAzione'];
      global $arrayDataCommenti;
      $arrayDataCommenti[] = $row['data'];   //quando è stato messo il commento
      return true;
    }
  } else {
    return false; //Non ci sono nuovi commenti
  }
}

function like(){
  include 'connessione.php';
  $idProfilo =  $_SESSION['idProfilo'];
  $query = "SELECT * FROM notifiche WHERE fkProfilo='$idProfilo' AND tipo='LIKE' AND view='0'";
  $result = $db_conn->query($query);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) { //itera sui risultati
      global $arrayIdLike;
      $arrayIdLike[] = $row['idAzione'];
      global $arrayDataLike;
      $arrayDataLike[] = $row['data'];   //quando è stato messo il like
      return true;
    }
  } else {
    return false; //Non ci sono nuovi commenti
  }
}


function autoreCommento($idCommento)
{    //tramite l'id del commento si va a vedere chi ha messo quel commento
  include 'connessione.php';
  $query = "SELECT fkProfilo FROM commento WHERE idCommento='$idCommento'";
  $result = $db_conn->query($query);
  if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    return $row['fkProfilo'];
  } else {
    return false; //Non esiste un commento con questo ID
  }
}

function autoreLike($idLike)
{    //tramite l'id del like si va a vedere chi ha messo quel like
  include 'connessione.php';
  $query = "SELECT fkProfilo FROM mipiace WHERE idLike='$idLike'";
  $result = $db_conn->query($query);
  if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    return $row['fkProfilo'];
  } else {
    return false; //Non esiste un commento con questo ID
  }
}

function testoCommento($idCommento)
{
  include 'connessione.php';
  $query = "SELECT testo FROM commento WHERE idCommento='$idCommento'";
  $result = $db_conn->query($query);
  if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    return $row['testo'];
  } else {
    return false; //Non esiste un commento con questo ID
  }
}


function idCommentoToIdPost($idCommento)
{
  include 'connessione.php';
  $query = "SELECT fkPost FROM commento WHERE idCommento='$idCommento'";
  $result = $db_conn->query($query);
  if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    return $row['fkPost'];
  } else {
    return false; //Non esiste un commento con questo ID
  }
}


function idLikeToIdPost($idLike){
  include 'connessione.php';
  $query = "SELECT fkPost FROM mipiace WHERE idLike='$idLike'";
  $result = $db_conn->query($query);
  if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    return $row['fkPost'];
  } else {
    return false; //Non esiste un like con questo ID
  }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['accettaAmicizia'])) {
  include 'connessione.php';
  $idUtente = $_SESSION['idProfilo'];
  $idUtenteCercato = $_POST['accettaAmicizia'];
  $date = date("Y-m-d H:i:s");
  $query = "UPDATE amicizia SET stato = 'AMICI' WHERE (fkProfilo1 = '$idUtenteCercato' AND fkProfilo2 = '$idUtente');";
  mysqli_query($db_conn, $query);
  header("Refresh:0");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['rifiutaAmicizia'])) {
  include 'connessione.php';
  $idUtente = $_SESSION['idProfilo'];
  $idUtenteCercato = $_POST['rifiutaAmicizia'];
  $query = "DELETE FROM amicizia WHERE (fkProfilo1 = '$idUtente' AND fkProfilo2 = '$idUtenteCercato') OR (fkProfilo1 = '$idUtenteCercato' AND fkProfilo2 = '$idUtente');";
  mysqli_query($db_conn, $query);
  header("Refresh:0");
}


?>