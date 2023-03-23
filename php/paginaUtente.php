<?php
include 'connessione.php';
// Abilita l'output buffering
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
    <title>Profilo utente</title>
    <link rel="icon" href="../img/icone/favicon.png" type="image/png"> 
    <link rel="stylesheet" type="text/css" href="../css/area_privata_personale.css">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<style>
		body {
			background-color: #E6E6E6;
		}
	</style>
</head>

<?php 
	include 'query.php';
    include 'header.php';
    
    if(isset($_GET['id'])) {
        id: $_GET['id'];
        global $idProfilo;
	    $idProfilo = $_GET['id'];
        $_SESSION['utenteCercato']=idProfiloToUsername($_GET['id']);
    }else{
        global $idProfilo;
        $idProfilo = idCercato($_SESSION['utenteCercato']);
    }
    

    function esiste()
	{
		$idProfilo = idCercato($_SESSION['utenteCercato']);
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

<body>
    <div class="container">
        <div class="left-section">
            <div class="profile-info">
                <img src="<?php if(esiste() != false){echo esiste();}else{echo "../img/icone/profilo.jpeg";}?>" alt="Foto profilo">
                <div class="info">
                    <h2><?php echo $_SESSION['utenteCercato'];  ?></h2>
                    <p><b>Username:</b> @<?php echo $_SESSION['utenteCercato']; ?></p>
                    <?php echo biografia($idProfilo); ?>
                </div>
            </div>
			<div class="user-stats">
				<p><b>Amici:</b> <?php echo amicizie($idProfilo); ?></p>
				<p><b>Post:</b> <?php echo post($idProfilo); ?></p>
			</div>
            <div class="follow-button">
                <form method="post" action="">
                    <button class="btn3" value="followerButton" name="followerButton" type="submit"><?php echo followButton(); ?></button>

                    <?php
                    if (followButton() == 'ACCETTA AMICIZIA') {
                        echo '<button class="btn3" value="rifiuta" name="rifiuta" type="submit">RIFIUTA AMICIZIA</button>';
                    }

                    ?>


                </form>
            </div>
			<?php if (trovaIDpost($idProfilo) == false) { ?> <br><br><br><br><br><br><br><br> <?php echo "Non sono presenti post";
																			} else {
																				echo mostraPost();
																			}	?>
			<br><br><br><br><br><br><br><br>
        </div>
    </div>
    <?php

function mostraPost(){
    $idProfilo = idCercato($_SESSION['utenteCercato']);
$output = "<div class='user-photos'><table>";
$id_array = trovaIDpost($idProfilo);
if (!empty($id_array)) {
    rsort($id_array); // ordina gli ID dei post in ordine decrescente
    $img = "";
    $count = 0; // contatore per tenere traccia del numero di foto nella riga corrente
    for ($i = 0; $i < count($id_array); $i++) {
        $img = convertToUrl($id_array[$i]);
        if ($count == 0) {
            // se è la prima foto nella riga corrente, apri una nuova riga e un form per il post
            $output .= "<tr><td>";
            $output .= "<form method='POST' action='visualizzaPostUtente.php'>";
            $output .= "<input type='hidden' name='id_post' value='$id_array[$i]'>";
            $output .= "<button style='border: none;' type='submit'>$img</button>";
            $output .= "</form></td>";
        } elseif ($count == 2) {
            // se è l'ultima foto nella riga corrente, chiudi la riga e il form
            $output .= "<td>";
            $output .= "<form method='POST' action='visualizzaPostUtente.php'>";
            $output .= "<input type='hidden' name='id_post' value='$id_array[$i]'>";
            $output .= "<button style='border: none;' type='submit'>$img</button>";
            $output .= "</form></td></tr>";
            $count = -1;
        } else {
            // altrimenti, aggiungi la foto alla riga corrente e il form
            $output .= "<td>";
            $output .= "<form method='POST' action='visualizzaPostUtente.php'>";
            $output .= "<input type='hidden' name='id_post' value='$id_array[$i]'>";
            $output .= "<button style='border: none;' type='submit'>$img</button>";
            $output .= "</form></td>";
        }
        $count++;
    }
    
    // se ci sono ancora foto in attesa di essere chiuse in una riga, chiudo qui
    if ($count > 0 && $count < 3) {
        $output .= str_repeat("<td></td>", 3 - $count) . "</tr>";
    }
    return $output .= "</table></div>";
} else {
    return "";
}
}

function convertToUrl($id)
{

    $folder = '../img/post/';
    $pattern = $folder . $id . '*';

    $files = glob($pattern);

    if (count($files) > 0) {
        foreach ($files as $file) {
            return '<img src="' . $file . '"';
        }
    }
}


    function followButton()
    {
        include 'connessione.php';

        $idUtente = $_SESSION['idProfilo'];
        $idUtenteCercato = idCercato($_SESSION['utenteCercato']);

        $query = "SELECT stato FROM amicizia where (fkProfilo1 = '$idUtente' AND fkProfilo2 = '$idUtenteCercato') OR (fkProfilo1 = '$idUtenteCercato' AND fkProfilo2 = '$idUtente');";


        $result = $db_conn->query($query);
        if ($result->num_rows == 1) {
            $row = $result->fetch_array(MYSQLI_ASSOC);
            if ($row["stato"] == 'AMICI') {
                return 'AMICI';
            } else if (selectFk2()) {
                return 'ACCETTA AMICIZIA';
            } else {
                return 'IN ATTESA';
            }
        } else {
            return 'INVIA AMICIZIA';
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['followerButton'])) {
        modificaStato();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['rifiuta'])) {
        rifiutaAmicizia();
    }

    function modificaStato(){
        include 'connessione.php';
        $idUtente = $_SESSION['idProfilo'];
        $idUtenteCercato = idCercato($_SESSION['utenteCercato']);
        if (followButton() == 'AMICI') {
            $query = "DELETE FROM amicizia WHERE (fkProfilo1 = '$idUtente' AND fkProfilo2 = '$idUtenteCercato') OR (fkProfilo1 = '$idUtenteCercato' AND fkProfilo2 = '$idUtente');";
            mysqli_query($db_conn, $query);
            header("Refresh:0");
        } else if (followButton() == 'INVIA AMICIZIA') {
            $date = date("Y-m-d H:i:s");
            $query = "INSERT INTO amicizia(fkProfilo1,fkProfilo2,stato,data) VALUES('$idUtente','$idUtenteCercato','IN ATTESA','$date');";
            mysqli_query($db_conn, $query);
            header("Refresh:0");
        } else if (followButton() == 'IN ATTESA') {
            $query = "DELETE FROM amicizia WHERE (fkProfilo1 = '$idUtente' AND fkProfilo2 = '$idUtenteCercato') OR (fkProfilo1 = '$idUtenteCercato' AND fkProfilo2 = '$idUtente');";
            mysqli_query($db_conn, $query);
            header("Refresh:0");
        } else if (followButton() == 'ACCETTA AMICIZIA') {
            if (selectFk2()) {
                $date = date("Y-m-d H:i:s");
                $query = "UPDATE amicizia SET stato = 'AMICI' WHERE (fkProfilo1 = '$idUtente' AND fkProfilo2 = '$idUtenteCercato') OR (fkProfilo1 = '$idUtenteCercato' AND fkProfilo2 = '$idUtente');";
                mysqli_query($db_conn, $query);
                header("Refresh:0");
            }
        }
    }

    function selectFk2()
    {
        include 'connessione.php';
        $idUtente = $_SESSION['idProfilo'];
        $idUtenteCercato = idCercato($_SESSION['utenteCercato']);
        $query = "SELECT * FROM amicizia WHERE fkProfilo1='$idUtenteCercato' AND fkProfilo2='$idUtente';";
        $result = $db_conn->query($query);
        if ($result->num_rows == 1) {
            $row = $result->fetch_array(MYSQLI_ASSOC);
            if ($row['stato'] == 'IN ATTESA') {
                return true;
            }
        }
    }


    function rifiutaAmicizia()
    {
        include 'connessione.php';
        $idUtente = $_SESSION['idProfilo'];
        $idUtenteCercato = idCercato($_SESSION['utenteCercato']);
        $query = "DELETE FROM amicizia WHERE (fkProfilo1 = '$idUtente' AND fkProfilo2 = '$idUtenteCercato') OR (fkProfilo1 = '$idUtenteCercato' AND fkProfilo2 = '$idUtente');";
        mysqli_query($db_conn, $query);
        header("Refresh:0");
    }


    function immagineProfilo()
    { {
            include 'connessione.php';

            $query = "SELECT immagineProfilo FROM profilo WHERE username = '" . $_SESSION['username'] . "'";

            $result = mysqli_query($db_conn, $query);

            $row = mysqli_fetch_assoc($result);


            header("Content-type: image/jpg");

            return $row['image'];
        }
    }
    include 'footer.php';
    ?>

</body>

</html>