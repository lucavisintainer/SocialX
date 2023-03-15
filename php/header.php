
<link rel="stylesheet" type="text/css" href="../css/header.css">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark" >
<div>
        <span>.      .</span>
        <span>.      .</span>
      </div>
  <a class="navbar-brand " href="#">Home</a>
  
  <div class="collapse navbar-collapse " id="navbarNav">
    <ul class="navbar-nav">

      <li class="nav-item">
        <a class="nav-link" href="area_privata_personale.php">Account</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="logout.php">Esci</a>
      </li>
    </ul>
  </div>
  <form method="post" class="form-inline">

    <div class="input-group">
      <div class="input-group-prepend">
        <span class="input-group-text" id="basic-addon1">@</span>
      </div>
      <div>
        <span>.    .</span>
      </div>
<form method="post" class="form-inline my-2 my-lg-0">
  <input class="form-control mr-sm-2" type="text" placeholder="Cerca utente..." aria-label="Search" id="search-box" name="search">
  <button class="btn btn-outline-success my-2 my-sm-0 my-white-btn" type="submit" name="submit">Cerca</button>
  <div>
        <span>.    .</span>
        <span>.      .</span>
      </div>
  
</form>


      


    </div>
  </form>
</nav>

<?php
include 'connessione.php';
if (isset($_POST["submit"])) {
		$str = $_POST["search"];
		$sth = $con->prepare("SELECT * FROM profilo WHERE username = '$str'");


		$sth->setFetchMode(PDO::FETCH_OBJ);
		$sth->execute();
		$_SESSION['idProfiloCercato'] = $row['idProfilo'];

		if ($row = $sth->fetch()) {
			if ($str != $_SESSION['username']) {
				$_SESSION['utenteCercato'] = $str;
				header("location: paginaUtente.php");
				ob_end_flush();
				exit;
			} else {
				echo "username loggato";
			}
		} else {
			echo "username non esiste";
		}
	}
  ?>