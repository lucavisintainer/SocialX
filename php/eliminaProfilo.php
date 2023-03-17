<?php
include 'connessione.php';
$idProfilo = $_POST['idProfilo'];
$query = "DELETE FROM profilo WHERE idProfilo = '$idProfilo'";
mysqli_query($db_conn, $query);

//elimino foto profilo
$files = glob("../img/immaginiProfilo/$idProfilo.*");
foreach($files as $file) {
    if(is_file($file)) {
        unlink($file);
    }
}
//elimino post del profilo

?>
