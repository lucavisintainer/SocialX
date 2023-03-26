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
<html lang="it">

<head>
    <meta charset="UTF-8">
    <title>Social-X</title>
    <link rel="icon" href="../img/icone/favicon.png" type="image/png"> 
    <!-- Inclusione delle librerie Bootstrap e jQuery -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        /* Stile personalizzato per la sezione dei commenti */
        .commenti {
            height: 400px;
            overflow-y: scroll;
        }
       
		body {
			background-color: #E6E6E6;
		}
	
    </style>
</head>

<body>
    <?php
    include 'header.php';
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_post'])) {
        $idPost = $_POST['id_post'];
    } else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id_post'])) {
        $idPost = $_GET['id_post'];
    } else {
        header("Location: area_privata_personale.php");
    }

    
    function convertToUrl($id)
    {
        $folder = '../img/post/';
        $pattern = $folder . $id . '*';
        $files = glob($pattern);
        if (count($files) > 0) {
            foreach ($files as $file) {
                return '<img src="' . $file . '"';
            }
        }
    }

    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <br><br>
                <p><u><?php if(postSponsorizzato($idPost)){echo "Post sponsorizzato";}?></u></p>
                <img <?php echo convertToUrl($idPost); ?>" class="img-fluid" alt="Post">
                <!-- Sezione del post -->
                <div class="card my-3">
                    <div class="card-header">
                    <?php echo "<button type='button' class='btn btn-primary btn-danger' data-toggle='modal' data-target='#exampleModalCenter'>Elimina post</button>'"; ?>

                    </div>

                    <div class="card-body" style="display: flex; align-items: center;">
                        <p class="card-text"><?php echo descrizionePost($idPost); ?></p>
                        <form method="POST" action=like.php>
                            <button type="submit" name="likeButton" style="border: none; background-color: white;">
                                <img <?php if (like($idPost)) {
                                            echo "src='../img/icone/like.png'";
                                        } else {
                                            echo "src='../img/icone/nolike.png'";
                                        } ?> alt="like" style="width: 50px; height: auto;">
                            </button>
                            <input type="hidden" name="id_post" value="<?php echo $idPost; ?>">
                        </form>
                        <div class="col-sm-1 text-right">
                            <span class="badge badge-pill badge-primary align-middle"><?php echo nLike($idPost); ?> Like</span>
                        </div>
                    </div>





                </div>
                <!-- Fine sezione del post -->
            </div>


            <div class="col-md-4">
                <br><br>
                <!-- Sezione dei commenti -->
                <div class="card my-3">
                    <div class="card-header">
                        Commenti
                        <span class="badge badge-pill badge-secondary ml-3"><?php echo nCommenti($idPost); ?></span>
                    </div>

                    <?php
                    if (!nCommenti($idPost) == 0) {
                    ?>
                        <div class="card-body commenti">
                            <!-- Elenco dei commenti -->
                            <ul class="list-unstyled">
                                <?php
                                $array_idCommenti = array();
                                $array_commenti = array();
                                $array_idProfili = array();
                                $array_Date = array();
                                $query = "SELECT * FROM commento WHERE fkPost='$idPost' AND stato='PUBBLICATO'";
                                if ($result = $db_conn->query($query)) {
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            
                                            array_push($array_idCommenti, $row['idCommento']);
                                            array_push($array_commenti, $row['testo']);
                                            array_push($array_idProfili, $row['fkProfilo']);
                                            array_push($array_Date, date("d/m/Y H:i", strtotime($row['data'])));
                                        }
                                        $array_idProfili = idToUsername($array_idProfili);


                                        // Ciclo for per stampare gli array
                                        for ($i = 0; $i < count($array_commenti); $i++) {
                                            echo "<li><strong>$array_idProfili[$i]</strong> - $array_Date[$i] <a href='eliminaCommento.php?idCommento=$array_idCommenti[$i]&idPost=$idPost'><img src='../img/icone/delete.png' width='25' height='25'></a><br>$array_commenti[$i]</li>";

                                        }
                                    } else {
                                        return false;
                                    }
                                } else {
                                    return false;
                                }
                            } else {
                                ?> <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><?php
                                                                                                }
                                                                                                    ?>
                        </div>
                        <div class="card-footer">
                            <!-- Form per aggiungere un nuovo commento -->
                            <form method="post" action="commento.php">
                                <div class="form-group">
                                    <label for="nuovo-commento">Lascia un commento:</label>
                                    <textarea class="form-control" id="nuovo-commento" required name="nuovo-commento" rows="3"></textarea>
                                </div>
                                <input type="hidden" name="id_post" value="<?php echo $idPost; ?>">
                                <button type="submit" class="btn btn-primary">Commenta</button>
                            </form>
                        </div>
                </div>
                <!-- Fine sezione dei commenti -->
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Sei sicuro di voler elimanare il post?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Indietro</button>
                    <button type="button" class="btn btn-primary" id="deletePostButton">Elimina</button>


                </div>
            </div>
        </div>
    </div>
    </div>
    </div>


    </div>

</body>


<script>
    document.getElementById("deletePostButton").addEventListener("click", function() {
        eliminaPost(<?php echo $idPost; ?>);
    });


    function eliminaPost(idPost) {


        // Crea una richiesta AJAX per eliminare il post
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "eliminaPost.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                // Redirect alla pagina personale dopo l'eliminazione del post
                location.href = 'area_privata_personale.php';
            }
        }
        xhr.send("idPost=" + idPost);
    }
</script>

</html>

<?php
function idToUsername($array_idProfili)
{
    include 'connessione.php';


    for ($i = 0; $i < count($array_idProfili); $i++) {
        $id = $array_idProfili[$i];
        $query = "SELECT username FROM profilo WHERE idProfilo=$id;";
        $result = $db_conn->query($query);
        if ($result->num_rows == 1) {
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $array_idProfili[$i] = $row["username"];
        }
    }


    return $array_idProfili;
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

?>