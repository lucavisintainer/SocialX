<?php
    $db_host = 'localhost';
    $db_user = 'root';
    $db_pass = '';
    $db_name = 'social_network';

    try{           
        $db_conn = @mysqli_connect($db_host, $db_user, $db_pass, $db_name);
        $con=new PDO("mysql:host=localhost;dbname=social_network",'root','');

        
        if ($db_conn==null){
            throw new exception (mysqli_connect_error(). ' Error n.'. mysqli_connect_errno());
        }else{
            //echo "Connessione avvenuta con successo: ";
        }
           
    } catch (Exception $e){
        $error_message = $e->getMessage();        
    }

    
?>