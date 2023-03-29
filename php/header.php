

<link rel="stylesheet" type="text/css" href="../css/header.css">
<style>
  .nav-link {
    font-size: 1.4rem;
    /* aumenta la dimensione del font dei link */
  }
</style>


<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div>
    <span>. .</span>
    <span>. .</span>
  </div>
  <div class="collapse navbar-collapse " id="navbarNav">
    <ul class="navbar-nav" mr-auto>
      <li class="nav-item">
        <a class="nav-link" href="home.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="area_privata_personale.php">Account</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="notifiche.php">
          Notifiche
          <?php
          include 'connessione.php'; 
          $num_notifiche;
          //count tabelle notifiche
          $idProfilo =  $_SESSION['idProfilo'];
          $query1 = "SELECT COUNT(*) FROM notifiche WHERE fkProfilo='$idProfilo' AND view='false'";
          $result = $db_conn->query($query1);
          if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $num_notifiche = $row['COUNT(*)'];
            $_SESSION['notifiche']=$num_notifiche;
          } else {
            return false;         //problema query      
          }
          
          //count richiesta di amicizia tabella amicizia
          $query2 = "SELECT COUNT(*) FROM amicizia WHERE fkProfilo2='$idProfilo' AND stato='IN ATTESA'";
          $result = $db_conn->query($query2);
          if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $num_notifiche += $row['COUNT(*)'];
            $_SESSION['notifiche']+=$num_notifiche;
          } else {
            return false;         //problema query      
          }


          // Stampa del pallino con il numero di notifiche
          if ($num_notifiche > 0) {
            echo '<span class="badge badge-danger">' . $num_notifiche . '</span>';
          } else {
            echo '<span class="badge badge-secondary">' . $num_notifiche . '</span>';
          }
          ?>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="logout.php">Esci</a>
      </li>
    </ul>
  </div>
  <form method="POST" class="form-inline">
    <div class="input-group rounded">
      <div class="input-group-prepend">
        <span class="input-group-text" id="basic-addon1">@</span>
      </div>
      <div>
        <span>. .</span>
      </div>
      <form method="POST" class="form-inline my-2 my-lg-0">
        <input class="form-control rounded mr-sm-2" type="text" required placeholder="Cerca utente..." aria-label="Search" id="search-box" name="search">
        <button class="btn btn-outline-success my-2 my-sm-0 my-white-btn rounded" type="submit" name="submit" style="margin-left: 10px;">Cerca</button>
        <div>
          <span>. .</span>
          <span>. .</span>
        </div>
      </form>
    </div>
  </form>

</nav>

<?php
include 'connessione.php';
if (isset($_POST["submit"])) {
  if (!empty($_POST["search"])) {
    $str = $_POST["search"];
    $sth = $con->prepare("SELECT * FROM profilo WHERE username = '$str'");

    $sth->setFetchMode(PDO::FETCH_OBJ);
    $sth->execute();

    if ($row = $sth->fetch()) {
      $_SESSION['idProfiloCercato'] = $row->idProfilo;
      if ($str != $_SESSION['username']) {
        $_SESSION['utenteCercato'] = $str;
        header("location: paginaUtente.php");
        ob_end_flush();
        exit;
      } else {
        echo "<div class='alert alert-danger' role='alert'>
        L'utente cercato sei tu!
      </div>";
      }
    } else {
      echo "<div class='alert alert-danger' role='alert'>
      L'utente cercato non esiste!
    </div>";
    }
  }
}
?>