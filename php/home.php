<?php
include 'connessione.php';
include 'query.php';
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
    <title>Home - SocialX</title>
    <!-- Inclusione file Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <style>
        .card {
            width: 70%;
        }

        .card-img-top {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .carousel-control-prev {
            left: -40px;
            transform: translateY(-50%) translateX(-10px);
            top: 40%;
        }

        .carousel-control-next {
            left: 740px;
            transform: translateY(-50%) translateX(-10px);
            top: 40%;
        }
    </style>
</head>

<body>
    <?php 
    postCasuali();  //prendo tutti i post
    stampa10Post(); //ne stampo 10 casuali
    ?>

<script>
function likePost(post_id) {
    // Codice JavaScript per aggiornare l'immagine del pulsante "like"
      var likeImage = document.getElementById("likeImage");
    if (like(post_id)) {
        likeImage.src = "../img/icone/like.png";
    } else {
        likeImage.src = "../img/icone/nolike.png";
    }

    // Codice JavaScript per inviare una richiesta AJAX al server per aggiornare il like nel database
    // ...
}
</script>
</body>

</html>

<?php

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

//salvare in un array(variabile globale) tutti i post presenti nel database    OK
//mescolarli in modo casuale    OK
//prendere i primi 10 dell'array e mostrarli OK
//in fondo alla pagina bottone "carica altro" --> se viene cliccato allora aggiungo altri 20 post dalla variabile
//globale dopo i primi 20, ...
function postCasuali()
{
    include 'connessione.php';
    $query = "SELECT idPost FROM post";
    $result = $db_conn->query($query);
    $id_array = array();                //array vuoto dove memorizzare gli ID dei post
    if ($result->num_rows > 0) {        //se c'è almeno un post
        while ($row = $result->fetch_assoc()) { //itera sui risultati
            $id_array[] = $row['idPost']; //aggiungi l'ID del post all'array
        }
    }
    shuffle($id_array);     //mescolo l'array di ID dei post in modo casuale
    global $post_ids;
    $post_ids = $id_array;  //id salvati in una variabile globale
}

function stampa10Post()
{
    global $post_ids;
    global $first_10_post_ids;
    $first_10_post_ids = array_slice($post_ids, 0, 10); //prendo i primi 10
    $post_ids = array_slice($post_ids, 10); //elimino i primi 10 dall'array global

    foreach ($first_10_post_ids as $post_id) {
        
    
    echo "<div class='container-fluid mt-5 text-center'><div class='row justify-content-center'><div class='col-md-2'></div> 
    <div class='col-md-8'><div><div class='card'>    

    <img class='card-img-top'" . convertToUrl($post_id) . "alt='Post'>
    <div class='card-body'>
        <h5 class='card-title'>" . idProfiloToUsername(idProfiloAutorePost($post_id)) . "</h5>
        <p class='card-text'>" . descrizionePost($post_id) . "</p>
        
        <button onclick='likePost(post_id)' type='submit' name='likeButton' style='border: none; background-color: white;'>
            <img src='../img/icone/like.png' id='likeImage' alt='like' style='width: 50px; height: auto;'>
        </button>
        
    
        <a href='#' class='btn btn-primary'>Commenta</a>
        <a href='#' class='btn btn-primary'>Vai al post</a>

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


?>