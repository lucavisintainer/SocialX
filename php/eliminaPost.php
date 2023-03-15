<?php
include 'connessione.php';
$idPost = $_POST['idPost'];
$query = "DELETE FROM post WHERE idPost = '$idPost'";
mysqli_query($db_conn, $query);

//elimino post
$files = glob("../img/post/$idPost.*");
foreach($files as $file) {
    if(is_file($file)) {
        unlink($file);
    }
}
?>
