<?php
  $out="<ul>";
  include 'connessione.php';
  $letter = $_GET['letter'];
  $query="SELECT * FROM profilo WHERE username LIKE '$letter%';";
  $arrayRisultati = array();
  $idUsername = array();
  if ($result = $db_conn->query($query)) {
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        array_push($arrayRisultati, $row['username']);
        array_push($idUsername, $row['idProfilo']);
      }
      for($i=0;$i<count($arrayRisultati);$i++){
        $out .= '<li><a href="paginaUtente.php?nomeUtente=' . urlencode($arrayRisultati[$i]) . '">' . $arrayRisultati[$i] . '</a></li>';
      }
      $out.="</ul>";
      // Restituisci la lista degli username nel formato HTML
      echo $out;
    } else {
      echo "Nessun risultato trovato.";
    }
  } else {
    echo "Errore";
  }
?>
