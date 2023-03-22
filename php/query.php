

<?php 

function trovaIDpost($idUsername)
	{
		
		include 'connessione.php';
		$query = "SELECT idPost FROM post WHERE fkProfilo='$idUsername'";
		$id_array = array(); // inizializza l'array vuoto
		if ($result = $db_conn->query($query)) {
			if ($result->num_rows > 0) {

				// ciclo while per ottenere tutti gli ID dei post trovati
				while ($row = $result->fetch_assoc()) {
					array_push($id_array, $row['idPost']); // aggiungio'ID all'array
				}
				return $id_array; // restituisco l'array di ID
			} else {
				return false;
			}
		} else {
			echo "Query non riuscita";
			return false;
		}
	}


	function amicizie($idUtente) {
		include 'connessione.php';
		$query = "SELECT count(*) FROM amicizia WHERE fkProfilo1 = '$idUtente' AND stato='AMICI' OR fkProfilo2 = '$idUtente' AND stato='AMICI';";
		if ($result = $db_conn->query($query)) {
			if ($result->num_rows > 0) {
				$row = $result->fetch_assoc();
				return $row['count(*)'];
			} else {
				return 0;
			}
		} else {
			return 0;
		}
		
	}

	function post($idUtente){
		include 'connessione.php';
		$query = "SELECT count(*) FROM post WHERE fkProfilo = '$idUtente';";
		if ($result = $db_conn->query($query)) {
			if ($result->num_rows > 0) {
				$row = $result->fetch_assoc();
				return $row['count(*)'];
			} else {
				return 0;
			}
		} else {
			return 0;
		}
		
	}

	function biografia($idUtente){
		include 'connessione.php';
		$query = "SELECT biografia FROM profilo WHERE idProfilo = '$idUtente';";
		if ($result = $db_conn->query($query)) {
			if ($result->num_rows == 1) {
				$row = $result->fetch_assoc();
				if($row['biografia']==null){
					return "";
				}else{
					return "<p><b>Biografia: </b>" . $row['biografia'] . "</p>";
				}
			} else {
				return "";
			}
		} else {
			return "";
		}
		 
	}

	function idCercato($utenteCercato){
        include 'connessione.php';
        $query = "SELECT idProfilo FROM profilo WHERE username='$utenteCercato';";
        $result = $db_conn->query($query);
        if ($result->num_rows == 1) {
            $row = $result->fetch_array(MYSQLI_ASSOC);
            return $row['idProfilo'];
        }
    }

	function caricamentoDB($descrizione,$tipoPost,$prezzo){
		include 'connessione.php';
		$fkProfilo=$_SESSION['idProfilo'];
		$date = date("Y-m-d H:i:s");
		$query = "INSERT INTO post(data,descrizione,fkProfilo,tipoPost,prezzo) VALUES('$date','$descrizione','$fkProfilo','$tipoPost','$prezzo');";
		mysqli_query($db_conn, $query);
	}

	function descrizionePost($id){ 
		include 'connessione.php';
		$query = "SELECT descrizione FROM post WHERE idPost='$id'";
		if ($result = $db_conn->query($query)) {
			if ($result->num_rows == 1) {
				$row = $result->fetch_assoc();
				return $row['descrizione'];
			} else {
				return "";
			}
		} else {
			return "";
		}
	}


	function idProfiloAutorePost($id){ 
		include 'connessione.php';
		$query = "SELECT fkProfilo FROM post WHERE idPost='$id'";
		if ($result = $db_conn->query($query)) {
			if ($result->num_rows == 1) {
				$row = $result->fetch_assoc();
				return $row['fkProfilo'];
			} else {
				return "";
			}
		} else {
			return "";
		}
	}


	function idProfiloToUsername($id){ 
		include 'connessione.php';
		$query = "SELECT username FROM profilo WHERE idProfilo='$id'";
		if ($result = $db_conn->query($query)) {
			if ($result->num_rows == 1) {
				$row = $result->fetch_assoc();
				return $row['username'];
			} else {
				return "";
			}
		} else {
			return "";
		}
	}

	function nCommenti($id)
{
    include 'connessione.php';
    $query = "SELECT count(*) FROM commento WHERE fkPost='$id' AND stato='PUBBLICATO'";
    $result = $db_conn->query($query);
    if ($result->num_rows == 1) {
        $row = $result->fetch_array(MYSQLI_ASSOC);
        return $row["count(*)"];
    }
}

function nLike($id){
	include 'connessione.php';
	$query = "SELECT count(*) FROM mipiace WHERE fkPost='$id';";
	$result = $db_conn->query($query);
	if ($result->num_rows == 1) {
        $row = $result->fetch_array(MYSQLI_ASSOC);
        return $row["count(*)"];
    }
}

function postSponsorizzato($id){
	include 'connessione.php';
	$query = "SELECT tipoPost FROM post WHERE idPost='$id';";
	$result = $db_conn->query($query);
	if ($result->num_rows == 1) {
        $row = $result->fetch_array(MYSQLI_ASSOC);
        if($row["tipoPost"]=="N"){
			return false;
		}else{
			return true;
		}
    }
}


?>