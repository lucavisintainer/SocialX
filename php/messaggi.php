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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="../img/icone/favicon.png" type="image/png">
    <title>Social-X</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
    <style>
        body {
            background-color: #E6E6E6;
        }

        .custom-bg {
            background-color: #FFFFFF;
        }
    </style>
</head>


<body>
    <?php
    include 'header.php';
    $idProfilo =  $_SESSION['idProfilo'];
    global $fkProfilo1;
    global $fkProfilo2;
    global $testo;
    global $data;
    global $view;
    ?>

    <!-- Main Content -->
    <div class="container-fluid mt-3">
        <?php if (messaggi() == true) { ?>
            <div class="row">
                <!-- Sezione nomi -->
                <div class="col-md-4">
                    <h4 class="mb-3">Messaggi</h4>
                    <div class="list-group" id="private-messages-tab" role="tablist">
                        <?php
                        $soggetto;
                        for ($i = 0; $i < count($fkProfilo1); $i++) {
                            if ($fkProfilo1[$i] != $idProfilo) {
                                $soggetto = $fkProfilo1[$i];
                            } else {
                                $soggetto = $fkProfilo2[$i];
                            }
                            if ($i == 0) {
                        ?>
                                <a class="list-group-item list-group-item-action active" id="utente1-tab" data-toggle="tab" href="#utente1" role="tab" aria-controls="utente1"><?php echo idProfiloToUsername($soggetto); ?></a>
                            <?php
                            } else {
                            ?>
                                <a class="list-group-item list-group-item-action" id="<?php echo $soggetto; ?>-tab" data-toggle="tab" href="#<?php echo $soggetto; ?>" role="tab" aria-controls="<?php echo $soggetto; ?>"><?php echo idProfiloToUsername($soggetto); ?></a>
                        <?php
                            }
                        }
                        ?>
                    </div>


                </div>
                <!-- Chat Section -->
                <div class="col-md-8">
                    <div class="tab-content" id="chat-tab-content">
                        <!-- Chat messaggi -->
                        <?php
                        for ($i = 0; $i < count($fkProfilo1); $i++) {
                            if ($fkProfilo1[$i] != $idProfilo) {
                                $soggetto = $fkProfilo1[$i];
                            } else {
                                $soggetto = $fkProfilo2[$i];
                            }
                        ?>
                            <div class="tab-pane fade" id="<?php echo $soggetto; ?>" role="tabpanel" aria-labelledby="<?php echo $soggetto; ?>-tab">
                                <h4 class="mb-3"><?php echo idProfiloToUsername($soggetto); ?></h4>
                                <div class="card">
                                    <div class="card-body">
                                        <!-- Contenuto della chat con Jane Smith -->
                                    </div>
                                </div>
                            </div><?php
                                }
                                    ?>


                        <div class="tab-pane fade show active" id="utente1" role="tabpanel" aria-labelledby="utente1-tab">
                            <h4 class="mb-3"><?php $idUtenteChat;
                                                if ($fkProfilo1[0] != $idProfilo) {
                                                    echo idProfiloToUsername($fkProfilo1[0]);
                                                    $idUtenteChat = $fkProfilo1[0];
                                                } else {
                                                    echo idProfiloToUsername($fkProfilo2[0]);
                                                    $idUtenteChat = $fkProfilo2[0];
                                                } ?>
                            </h4>
                            <div class="card">
                                <div class="card-body">

                                    <div class="media mb-3">
                                        <img class="mr-3 rounded-circle" src="<?php if (esiste($idUtenteChat) != false) {
                                                                                    echo esiste($idUtenteChat);
                                                                                } else {
                                                                                    echo "../img/icone/profilo.jpeg";
                                                                                } ?>" alt="User Avatar" style="width: 50px; height: 50px; object-fit: cover;">

                                        <div class="media-body">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec ac blandit sapien. Nulla facilisi. Sed sodales ex sit amet velit eleifend, et aliquam dolor cursus. Aenean sit amet libero eget arcu dignissim rutrum. Suspendisse potenti. </p>
                                            <small class="text-muted">12:30 PM | Mar 25, 2023</small>
                                        </div>
                                    </div>
                                    <div class="media mb-3">
                                        <div class="media-body text-right">
                                            <p>Curabitur rutrum metus vel sapien ultricies, sed pulvinar est malesuada. Mauris venenatis eros in convallis ullamcorper. Praesent aliquet lorem eu eleifend auctor. Aliquam vitae lacus in libero hendrerit malesuada. </p>
                                            <small class="text-muted">1:15 PM | Mar 25, 2023</small>
                                        </div>
                                        <img class="mr-3 rounded-circle" src="<?php if (esiste($idProfilo) != false) {
                                                                                    echo esiste($idProfilo);
                                                                                } else {
                                                                                    echo "../img/icone/profilo.jpeg";
                                                                                } ?>" alt="User Avatar" style="width: 50px; height: 50px; object-fit: cover;">

                                    </div>
                                    <form>
                                        <div class="form-group">
                                            <textarea class="form-control" id="message-textarea" rows="3" placeholder="Type your message here..."></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Invia</button>
                                    </form>

                                </div>
                            </div>
                        </div>







                    </div>
                </div>
            </div>
        <?php } else {
            echo "Non hai ancora nessun messaggio";
        } ?>
    </div>

    <!-- Bootstrap JavaScript and jQuery -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>

<?php
function messaggi()
{
    include 'connessione.php';
    $idProfilo =  $_SESSION['idProfilo'];
    $query = "SELECT * FROM messaggi WHERE fkProfilo1='$idProfilo' OR fkProfilo2='$idProfilo' ORDER BY data DESC";
    $result = $db_conn->query($query);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            global $fkProfilo1;
            $fkProfilo1[] = $row['fkProfilo1'];   //chi invia il messaggio
            global $fkProfilo2;
            $fkProfilo2[] = $row['fkProfilo2'];   //chi riceve il messaggio
            global $testo;
            $testo[] = $row['testo'];   //testo del messaggio
            global $data;
            $data[] = $row['data'];   //testo del messaggio
            global $view;
            $view[] = $row['view'];   //testo del messaggio
        }
        return true;
    } else {
        return false; //Non ci sono messaggi
    }
}



function esiste($idProfilo)
{
    // vedere se esiste una foto profilo con id utente
    $dir = '../img/immaginiProfilo/';
    $extensions = ['jpg', 'jpeg', 'png']; // array delle estensioni delle immagini possibili

    foreach ($extensions as $extension) {
        $src = $dir . $idProfilo . '.' . $extension;
        if (file_exists($src)) {
            return $src;
        }
    }
    return false;
}
?>