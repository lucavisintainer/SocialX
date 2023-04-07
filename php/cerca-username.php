<?php
include 'connessione.php';
// Abilita l'output buffering
ob_start();
session_start();
if (!isset($_SESSION['loggato']) || $_SESSION['loggato'] != true) {
    header("location: enter.php");
    exit;
}

$out = "<ul>";
$letter = $_GET['letter'];
$letter = mysqli_real_escape_string($db_conn, $letter);
$query = "SELECT * FROM profilo WHERE username LIKE '$letter%' ORDER BY username ASC";
$arrayRisultati = array();
$idUsername = array();
if ($result = $db_conn->query($query)) {
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      array_push($arrayRisultati, $row['username']);
      array_push($idUsername, $row['idProfilo']);
    }
    for ($i = 0; $i < count($arrayRisultati); $i++) {
      $out .= '<li><img src="';
      if (esiste($idUsername[$i])) {
        $out .= esiste($idUsername[$i]);
      } else {
        $out .= "../img/icone/profilo.jpeg";
      } 
      $out .='" alt="Img" class="user-icon"><a href="paginaUtente.php?nomeUtente=' . urlencode($arrayRisultati[$i]) . '">' . $arrayRisultati[$i] . '</a></li>';
    }

    $out .= "</ul>";
    // Restituisci la lista degli username nel formato HTML
    echo $out;
  } else {
    echo "Nessun risultato trovato.";
  }
} else {
  echo "Errore";
}

function esiste($idProfilo)
{
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

<style>
.user-icon {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  margin-right: 10px;
  object-fit: cover; /* l'immagine viene ridimensionata in modo da coprire completamente il contenitore, mantenendo l'aspetto proporzionato */
  max-width: 100%; /* l'immagine non supera la larghezza massima del suo contenitore */
}



</style>
