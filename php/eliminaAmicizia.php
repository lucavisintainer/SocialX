<?php
session_start();

include 'connessione.php';
$idAmico = $_GET['idAmico'];
$idUtente = $_SESSION['idProfilo'];

$query = "DELETE FROM amicizia WHERE (fkProfilo1 = '$idUtente' AND fkProfilo2 = '$idAmico') OR (fkProfilo1 = '$idAmico' AND fkProfilo2 = '$idUtente');";
mysqli_query($db_conn, $query);

header("Location: amicizie.php");   

?>