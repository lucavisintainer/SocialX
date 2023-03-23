<?php
session_start();
include 'connessione.php';
include 'query.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['likeButton'])) {
    $idPost = $_POST['id_post'];
    modificaLike($idPost);
    if(verificaProprietario($idPost)){
        header("Location: visualizzaPost.php?id_post=" . $idPost);    
    }else{
        header("Location: visualizzaPostUtente.php?id_post=" . $idPost);   
    }
    
}

function modificaLike($idPost)
{
    include 'connessione.php';
    $idProfilo = $_SESSION['idProfilo'];
    if (like($idPost)) {
        $query = "DELETE FROM mipiace WHERE (fkProfilo = '$idProfilo' AND fkPost = '$idPost')";
        mysqli_query($db_conn, $query);
    } else {
        $date = date("Y-m-d H:i:s");
        $query = "INSERT INTO mipiace(data,fkProfilo,fkPost) VALUES('$date','$idProfilo','$idPost');";
        mysqli_query($db_conn, $query);
        $query2 = "INSERT INTO notifiche(fkProfilo,tipo,idAzione,view,data) VALUES(".idProfiloAutorePost($idPost).",'LIKE','".(lastIdlike())."','false','$date');";
        mysqli_query($db_conn, $query2);
    }
}

function like($idPost)
{
    include 'connessione.php';
    $idProfilo =  $_SESSION['idProfilo'];
    $query = "SELECT * FROM mipiace WHERE fkPost='$idPost' AND fkProfilo='$idProfilo'";
    $result = $db_conn->query($query);
    if ($result->num_rows == 1) {
        return true;                //già messo mi piace
    } else {
        return false;               //no mi piace
    }
}

function verificaProprietario($idPost){
    include 'connessione.php';
    $idProfilo =  $_SESSION['idProfilo'];
    $query = "SELECT fkProfilo FROM post WHERE idPost='$idPost'";
    $result = $db_conn->query($query);
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if($row['fkProfilo']==$idProfilo){
            return true;    //il post è dell'utente loggato
        }else{
            return false;   //il post è dell'utente cercato
        }
    }

}

?>


