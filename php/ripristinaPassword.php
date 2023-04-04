<?php include 'connessione.php';


?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <title>Social-X</title>
    <link rel="icon" href="../img/icone/favicon.png" type="image/png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<style>
    body {
        background-color: #E6E6E6;
    }
</style>

<?php
if (isset($_GET['token'])) {
    // Controlla il token nel database
    $token = $_GET['token'];
    $query = "SELECT * FROM passwordResetToken WHERE token='$token'";
    if ($result = $db_conn->query($query)) {
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $idUtente = $row['fkProfilo'];
            $timestamp = $row['dataCreazione'];
            $timestamp_24h_ago = date("Y-m-d H:i:s", strtotime("-24 hours"));
            // Controlla il timestamp
            if (strtotime($timestamp) >= strtotime($timestamp_24h_ago)) {
?>

                <body>
                    <div class="container mt-5">
                        <div class="card mx-auto" style="max-width: 400px;">
                            <div class="card-header">
                                <h4 class="card-title">Reimposta Password</h4>
                            </div>
                            <div class="card-body">
                                <form method="POST">
                                    <div class="form-group">
                                        <label for="password">Nuova Password</label>
                                        <input type="password" class="form-control" id="password" name="password" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="confirm-password">Conferma Password</label>
                                        <input type="password" class="form-control" id="confirm-password" name="confirm-password" required>
                                    </div>
                                    <input type="checkbox" onclick="showPassword()"> Mostra password</input><br>
                                    <label style="color: red;" id="errPassword"></label>
                                    <button type="submit" value="pass" name="pass" class="btn btn-primary btn-block">Cambia Password</button>
                                   
                                </form>
                            </div>
                        </div>
                    </div>
                    <script>
            function showPassword() {
                var passwordField1 = document.getElementById("password");
                var passwordField2 = document.getElementById("confirm-password");

                if (passwordField1.type === "password") {
                    passwordField1.type = "text";
                } else {
                    passwordField1.type = "password";
                }

                if (passwordField2.type === "password") {
                    passwordField2.type = "text";
                } else {
                    passwordField2.type = "password";
                }
            }
        </script>
                </body>
                <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['pass'])) {
                    $password = $_POST['password'];
                    $confermaPassword = $_POST['confirm-password'];
                    if ($password != $confermaPassword) {
                ?>
                        <script>
                            const errPassword1 = document.getElementById('errPassword');
                            errPassword1.innerHTML = "Le password non coincidono";
                        </script>
                    <?php



                    } else if (!(preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/', $password))) {
                    ?>
                        <script>
                            const errPassword2 = document.getElementById('errPassword');
                            errPassword2.innerHTML = "La password deve essere composta da almeno 8 caratteri e contenere almeno una lettera minuscola, una maiuscola e un numero";
                        </script>
                <?php
                    } else {
                        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                        $sql = "UPDATE profilo SET password = '$hashed_password' WHERE idProfilo=$idUtente";
                        $query = "DELETE FROM passwordresettoken WHERE token=$token;";
                        mysqli_query($db_conn, $query);
                        if ($db_conn->query($sql) == true) {
                            header("location: enter.php");
                            exit();
                        } else {
                            ?>
                            <script>
                                const errPassword2 = document.getElementById('errPassword');
                                errPassword2.innerHTML = "Errore modifica password";
                            </script>
                    <?php
                        }
                    }
                }
            } else {
                //token scaduto
                ?>
                <style>
                    body {
                        background-color: #f8f9fa;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        height: 100vh;
                    }

                    .card {
                        border: none;
                        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
                        transition: 0.3s;
                    }

                    .card:hover {
                        box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
                    }

                    .card-body {
                        text-align: center;
                    }

                    h4 {
                        margin-bottom: 20px;
                    }
                </style>
                </head>

                <body>
                    <div class="card p-4">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Link Scaduto</h4>
                            <button type="submit" class="btn btn-primary btn-block" onclick="window.location.href='passwordDimenticata.php'">Richiedi un nuovo Link</button>
                        </div>
                    </div>
                </body>
            <?php
                $query = "DELETE FROM passwordresettoken WHERE token='$token';";
                mysqli_query($db_conn, $query);
            }
        } else {
            // Il token non è valido
            ?>
            <style>
                body {
                    background-color: #f8f9fa;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                }

                .card {
                    border: none;
                    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
                    transition: 0.3s;
                }

                .card:hover {
                    box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
                }

                .card-body {
                    text-align: center;
                }

                h4 {
                    margin-bottom: 20px;
                }
            </style>
            </head>

            <body>
                <div class="card p-4">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Link Scaduto</h4>
                        <button type="submit" class="btn btn-primary btn-block" onclick="window.location.href='passwordDimenticata.php'">Richiedi un nuovo Link</button>
                    </div>
                </div>
            </body>
<?php
        }
    }
}
?>

</html>