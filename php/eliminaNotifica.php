<?php
include 'connessione.php';
if(isset($_GET['tipo'])){
$tipo = $_GET['tipo'];
if($tipo=="commento"){
    if(isset($_GET['idAzione'])){
    $idAzione = $_GET['idAzione'];
    $query = "UPDATE notifiche SET view=true WHERE (tipo='COMMENT' AND idAzione=$idAzione);";
    mysqli_query($db_conn, $query);
    header("Location: notifiche.php"); 
    }
}else if($tipo=="like"){
    if(isset($_GET['idAzione'])){
    $idAzione = $_GET['idAzione'];
    $query = "UPDATE notifiche SET view=true WHERE (tipo='LIKE' AND idAzione=$idAzione);";
    mysqli_query($db_conn, $query);
    header("Location: notifiche.php"); 
    }
}
}
?>