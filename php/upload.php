<?php
include 'query.php';
session_start();
if (!isset($_SESSION['loggato']) || $_SESSION['loggato'] != true) {
	header("location: enter.php");
	exit;
}


if($_SERVER["REQUEST_METHOD"]=="POST"){
    if(isset($_FILES["photo"]) && $_FILES["photo"]["error"]==0){
       $estensioni_permesse = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
       $nome_file = $_FILES["photo"]["name"];
       $tipo_file = $_FILES["photo"]["type"];
       $dimensione_file = $_FILES["photo"]["size"];
       $descrizione = $_POST['descrizione'];
       $tipoPost = $_POST['tipoPost'];

       // Verifico estensione file
       $estensione = pathinfo($nome_file, PATHINFO_EXTENSION);
       if(!array_key_exists($estensione,$estensioni_permesse)){
        $_SESSION['erroreUpload'] = "Errore nel caricamento del post, riprova.";
       }

       // Verifico grandezza massima 16 MB
       $dimensione_massima = 16000000;  //16000000 char --> 16 MB
       if($dimensione_file > $dimensione_massima) die("Errore: la grandezza è superiore al limite consentito");

       // Verifico il tipo MIME
        if(in_array($tipo_file,$estensioni_permesse)){
            move_uploaded_file($_FILES["photo"]["tmp_name"], "../img/post/" . $nome_file);
            caricamentoDB($descrizione,$tipoPost);
            rinominaFile($nome_file,$estensione);
            header("location: area_privata_personale.php");

        }else{
            echo "Errore nel caricamento del post, riprova.";
    }
}else{
   echo "Errore nel caricamento del post, riprova.";
}
}


function rinominaFile($nome_file,$estensione){
    include 'connessione.php';
    $query = "SELECT idPost FROM post ORDER BY idPost DESC LIMIT 1;";
    $result = mysqli_query($db_conn, $query);
    $row = mysqli_fetch_assoc($result);
    $id = $row['idPost'];

    $old_file_name = "../img/post/$nome_file";
    $new_file_name = "../img/post/" . $id . "." . $estensione;
    
    rename($old_file_name, $new_file_name);
}

?>




