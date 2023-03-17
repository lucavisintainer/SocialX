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