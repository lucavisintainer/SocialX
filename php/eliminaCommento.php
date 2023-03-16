<?php
session_start();
include 'connessione.php';
$idCommento = $_GET['idCommento'];
$idPost = $_GET['idPost'];
$query = "UPDATE commento SET stato='ELIMINATO' WHERE idCommento=$idCommento";
mysqli_query($db_conn, $query);
if(verificaProprietario($idPost)){
    header("Location: visualizzaPost.php?id_post=" . $idPost);   
}else{
    header("Location: visualizzaPostUtente.php?id_post=" . $idPost);   
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