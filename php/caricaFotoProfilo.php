<?php
session_start();
if (!isset($_SESSION['loggato']) || $_SESSION['loggato'] != true) {
	header("location: enter.php");

	exit;
}


if(isset($_FILES['photo'])) {
	caricaFotoProfilo();
    header("location: area_privata_personale.php");
}

function caricaFotoProfilo(){
	$estensioni_permesse = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "png" => "image/png");
	$nome_file = $_FILES["photo"]["name"];
	$tipo_file = $_FILES["photo"]["type"];
	$dimensione_file = $_FILES["photo"]["size"];

	// Verifico estensione file
	$estensione = pathinfo($nome_file, PATHINFO_EXTENSION);
    
    session_start();
    $_SESSION['estensione'] = $estensione;
    
	// Verifico grandezza massima 16 MB
	$dimensione_massima = 16000000;  //16000000 char --> 16 MB

	if(!array_key_exists($estensione,$estensioni_permesse) && $dimensione_file > $dimensione_massima){
		echo "Errore";
	}else{
		if(in_array($tipo_file,$estensioni_permesse)){
			//modifico foto con id profilo

			verificaFile($_FILES["photo"]["tmp_name"]);
			aggiungiFotoProfilo($_FILES["photo"]["tmp_name"],$estensione);
           
            
        }else{
	echo "Errore: c'è stato un problema con il caricamento del tuo file, riprova.";
    }
	}
}

function verificaFile($file_temp) {
    $idUtente = $_SESSION['idProfilo'];
    $cartella = "../img/immaginiProfilo/";
    $nome_file = $idUtente . ".*";
    $path = $cartella . $nome_file;

    $files = glob($path);
    foreach ($files as $file) {
        // Verifica se il nome del file corrisponde all'id utente seguito da un punto e da un'estensione
        $file_name = pathinfo($file, PATHINFO_FILENAME);
        if ($file_name == $idUtente) {
            unlink($file);
        }
    }
}
	
    function aggiungiFotoProfilo($file_temp,$estensione) {
        $nome_file = $_FILES["photo"]["name"];
        $percorso_temporaneo = $file_temp;
        $percorso_destinazione = '../img/immaginiProfilo/' . $nome_file;
        move_uploaded_file($percorso_temporaneo, $percorso_destinazione);  
        $idUtente =  $_SESSION['idProfilo'];     
        $new_file_name = "../img/immaginiProfilo/" . $idUtente . "." . $estensione;
        rename($percorso_destinazione, $new_file_name);
    }


?>