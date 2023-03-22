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
    <link rel="icon" href="../img/icone/favicon.png" type="image/png"> 
    <!-- Inclusione file Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../css/home.css">
</head>
<style>
        body {
			background-color: #E6E6E6;
		}
        .custom-bg {
    background-color: #FFFFFF;
}

    </style>
<body>  
    <?php
    include 'header.php';
    postCasuali();  //prendo tutti i post
    stampa10Post(); //ne stampo 10 casuali
    ?> <div id="post-container"> </div> <?php

    $mostraForm = true;
    if ($mostraForm) {
    if (count($_SESSION['array']) > 0) {                 //se l'array contiene altri post(oltre ai 10 già visualizzati)       
            echo "<br><br><br><div class='container'><div class='row'><div class='col text-center'>
            <form method='post' id='mostraPostForm'>
                <input type='hidden' name='mostra' value='my_fmostraPost'>
                <button type='button' class='btn btn-primary' onclick='mostraPost()'>Carica altri post</button>
            </form>
        </div></div></div><br><br><br>";
        }
    }
    include 'footer.php';
    ?>


<script>
function mostraPost() {
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("post-container").innerHTML += this.responseText;
    }
  };
  xmlhttp.open("POST", "mostra_post.php", true);
  xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xmlhttp.send("mostra=mostraPost");

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

function postCasuali()
{
    $idProfilo = $_SESSION['idProfilo'];
    include 'connessione.php';
    $query = "SELECT idPost FROM post WHERE fkProfilo != $idProfilo";
    $result = $db_conn->query($query);
    $id_array = array();                //array vuoto dove memorizzare gli ID dei post
    if ($result->num_rows > 0) {        //se c'è almeno un post
        while ($row = $result->fetch_assoc()) { //itera sui risultati
            $id_array[] = $row['idPost']; //aggiungi l'ID del post all'array
        }
    }
    shuffle($id_array);     //mescolo l'array di ID dei post in modo casuale
    $_SESSION['array'] = $id_array;
}

function stampa10Post()
{

    $first_10_post_ids = array_slice($_SESSION['array'], 0, 10); //prendo i primi 10
    $_SESSION['array'] = array_slice($_SESSION['array'], 10); //elimino i primi 10 dall'array

    foreach ($first_10_post_ids as $post_id) {        
        echo "<div class='container-fluid mt-5 text-center'><div class='row justify-content-center'><div class='col-md-2'></div> 
        <div class='col-md-8'><div><div class='card'>    
        <img class='card-img-top'" . convertToUrl($post_id) . "alt='Post'>
        <div class='card-body custom-bg'>
        <h5 class='card-title'><a href='paginaUtente.php?id=". idProfiloAutorePost($post_id) ."'>" . idProfiloToUsername(idProfiloAutorePost($post_id)) . "</a></h5>
        <p class='card-text'>" . descrizionePost($post_id) . "</p>
        <form method='post' action='visualizzaPostUtente.php'>
            <input type='hidden' name='id_post' value='" . $post_id . "'>
            <button type='submit' class='btn btn-primary'>Visualizza Post</button>
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


?>