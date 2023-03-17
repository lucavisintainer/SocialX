<?php
include 'connessione.php';
include 'query.php';
ob_start();
session_start();
if (!isset($_SESSION['loggato']) || $_SESSION['loggato'] != true) {
    header("location: enter.php");
    exit;
}

function stampa10Post()
{

    $first_10_post_ids = array_slice($_SESSION['array'], 0, 10); //prendo i primi 10
    $_SESSION['array'] = array_slice($_SESSION['array'], 10); //elimino i primi 10 dall'array

    foreach ($first_10_post_ids as $post_id) {

        echo "<div class='container-fluid mt-5 text-center'><div class='row justify-content-center'><div class='col-md-2'></div> 
        <div class='col-md-8'><div><div class='card'>    
        <img class='card-img-top'" . convertToUrl($post_id) . "alt='Post'>
        <div class='card-body'>
        <h5 class='card-title'><a href='paginaUtente.php?id=". idProfiloAutorePost($post_id) ."'>" . idProfiloToUsername(idProfiloAutorePost($post_id)) . "</a></h5>
        <p class='card-text'>" . descrizionePost($post_id) . "</p>
            <a href='#' class='btn btn-primary'";
            echo " onclick='submitForm(\"visualizzaPostUtente.php\")'";
        
        
        echo ">Vai al post</a>
            <form id='post_form' method='post' action='visualizzaPostUtente.php>
                <input type='hidden' name='id_post' value='" . $post_id . "'>
            </form>
        </div></div></div></div></div></div>";
    }
}

function convertToUrl($id)
{
    $folder = '../img/post/';
    $pattern = $folder . $id . '*';
    $files = glob($pattern);
    if (count($files) > 0) {
        foreach ($files as $file) {
            return ' src="' . $file . '"';
        }
    }
}

function verificaProprietario($idPost)
{
    include 'connessione.php';
    $idProfilo =  $_SESSION['idProfilo'];
    $query = "SELECT fkProfilo FROM post WHERE idPost='$idPost'";
    $result = $db_conn->query($query);
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if ($row['fkProfilo'] == $idProfilo) {
            return true;    //il post è dell'utente loggato
        } else {
            return false;   //il post è dell'utente cercato
        }
    }
}

stampa10Post(); 



?>