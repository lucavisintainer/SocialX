<?php
session_start();
include 'connessione.php';
include 'query.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nuovo-commento'])) {
    $idProfilo = $_SESSION['idProfilo'];
    $date = date("Y-m-d H:i:s");
    $commento = $_POST['nuovo-commento'];
    $idPost = $_POST['id_post'];
    if (!empty($commento)) {
        $query = "INSERT INTO commento(data,testo,fkProfilo,fkPost,stato) VALUES('$date','$commento','$idProfilo','$idPost','PUBBLICATO');";
        mysqli_query($db_conn, $query);
        if(!verificaProprietario($idPost)){   
        $query2 = "INSERT INTO notifiche(fkProfilo,tipo,idAzione,view,data) VALUES(".idProfiloAutorePost($idPost).",'COMMENT','".(lastIdCommenti())."','false','$date');";
        mysqli_query($db_conn, $query2);
        }
        if(verificaProprietario($idPost)){
            header("Location: visualizzaPost.php?id_post=" . $idPost);    
        }else{
            header("Location: visualizzaPostUtente.php?id_post=" . $idPost);   
        }
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