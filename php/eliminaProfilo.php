<?php
include 'connessione.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if (isset($_POST['elimina-profilo'])) {
        $password = $_POST['password'];
        if (verificaPassword($password)) {
            
            eliminaProfilo();
            header("location: index.php");

        } else {
            $error = 'La password inserita non è corretta.';
            header("location: impostazioni_personale.php?error=" . urlencode($error));                       
        }
    }
}



function verificaPassword($password){
    include 'connessione.php';
    $idProfilo = $_SESSION['idProfilo'];
    $sql_select = "SELECT * FROM profilo WHERE idProfilo = '$idProfilo'";
    if ($result = $db_conn->query($sql_select)) {
        if ($result->num_rows == 1) {
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $db_password = $row['password'];

            // Verifica la password
            if (password_verify($password, $db_password)) {
                return true;
            } else {
                return false;
            }
        }
    }
}

function eliminaProfilo(){
    include 'connessione.php';
    $idProfilo = $_SESSION['idProfilo'];
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

}
