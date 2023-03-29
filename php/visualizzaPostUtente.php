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
    <link rel="icon" href="../img/icone/favicon.png" type="image/png">
    <title>Social-X</title>
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
                <div>
                <p style="display: inline-block; margin-right: 10px;">
    <b><a href="paginaUtente.php" <?php $_SESSION['utenteCercato'] = idProfiloToUsername(idProfiloAutorePost($idPost)); ?> ><?php echo idProfiloToUsername(idProfiloAutorePost($idPost));?></a></b>
  </p>
  <p style="display: inline-block;"><u><?php if(postSponsorizzato($idPost)){echo "Post sponsorizzato";}?></u></p>
</div>


                <img <?php echo convertToUrl($idPost); ?>" class="img-fluid" alt="Post">
                <!-- Sezione del post -->
                <div class="card my-3">

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
                                        $arrayUsername = idToUsername($array_idProfili);



                                        // Ciclo for per stampare gli array
                                        for ($i = 0; $i < count($array_commenti); $i++) {
                                            if (verificaCommento($array_idProfili[$i])) {
                                                echo "<li><strong>$arrayUsername[$i]</strong> - $array_Date[$i] <a href='eliminaCommento.php?idCommento=$array_idCommenti[$i]&idPost=$idPost'><img src='../img/icone/delete.png' width='25' height='25'></a><br>$array_commenti[$i]</li>";
                                            } else {
                                                echo  "<li><strong>$arrayUsername[$i]</strong> - $array_Date[$i]<br>$array_commenti[$i]</li>";
                                            }
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

    </div>
    </div>


    </div>
    <?php include 'footer.php'; ?>
</body>

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

function verificaCommento($fkProfiloCommento)
{
    $idProfilo =  $_SESSION['idProfilo'];
    if ($fkProfiloCommento == $idProfilo) {
        return true;
    } else {
        return false;
    }
}
?>