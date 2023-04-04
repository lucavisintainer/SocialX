<?php ob_start(); ?>

<!DOCTYPE html>
<html>

<head>
    <link rel="icon" href="../img/icone/favicon.png" type="image/png">
    <meta charset="UTF-8">
    <title>Social-X</title>
    <link rel="stylesheet" type="text/css" href="../css/login.css">


    </style>
</head>

<body>
    <div class="container" id="container">
        <!-- REGISTRAZIONE -->
        <div class="form-container sign-up-container">
            <form action="" method="POST">
                <h1>Crea account</h1>
                <input for="username" id="username" name="username" type="text" placeholder="Username" value='<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>' required>
                <label style="color: red;" id="errUsername"></label>
                <input for="email" id="email" name="email" type="email" placeholder="Email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" required />
                <label style="color: red;" id="errEmail"></label>
                <input for="password" id="password" name="password" type="password" placeholder="Password" required />
                <input for="confermaPassword" id="confermaPassword" name="confermaPassword" type="password" placeholder="Conferma password" required />
                <input type="checkbox" onclick="showPassword()">Mostra password</input>
                <label style="color: red;" id="errPassword"></label>
                <br>
                <button type="submit" name="submitRegistrazione" value="Registrati">Registrati</button>
            </form>
        </div>
        <script>
            function showPassword() {
                var passwordField1 = document.getElementById("password");
                var passwordField2 = document.getElementById("confermaPassword");

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
        <!-- LOGIN -->
        <div class="form-container sign-in-container">
            <form action="" method="POST">
                <h1>Accedi</h1>
                <span>o effettua il login</span>
                <br>
                <input for="username" type="text" id="username" name="username" placeholder="Username o Email" required>
                <input for="password" type="password" id="password" name="password" placeholder="Password" required />
                <label style="color: red;" id="errLogin"></label>
                <a href="passwordDimenticata.php">Password dimenticata?</a>
                <button type="submit" name="accedi" value="accedi">Accedi</button>
            </form>
        </div>

        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Benvenuto!</h1>
                    <p>Per restare in contatto con noi effettua il login con i tuoi dati personali</p>
                    <button class="ghost" id="signIn">Login</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Bentornato!</h1>
                    <p>Inserisci i tuoi dati personali e inizia il viaggio con noi</p>
                    <button class="ghost" id="signUp">Registrati</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const signUpButton = document.getElementById('signUp');
        const signInButton = document.getElementById('signIn');
        const container = document.getElementById('container');

        signUpButton.addEventListener('click', () => {
            container.classList.add("right-panel-active");
        });

        signInButton.addEventListener('click', () => {
            container.classList.remove("right-panel-active");
        });
    </script>

</body>

</html>

<?php
include 'connessione.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submitRegistrazione'])) {
    // Escape special characters, if any
    $username = $db_conn->real_escape_string(strtolower($_POST['username']));
    $email = $db_conn->real_escape_string(strtolower($_POST['email']));
    $password = $db_conn->real_escape_string($_POST['password']);
    $confermaPassword = $db_conn->real_escape_string($_POST['confermaPassword']);
    $date = date("Y-m-d H:i:s");


    function verificaPassword($password, $confermaPassword)
    {

        include 'connessione.php';
        if ($password != $confermaPassword) {
?>
            <script>
                const errPassword = document.getElementById('errPassword');
                errPassword.innerHTML = "Le password non coincidono";
                const container1 = document.getElementById('container');
                {
                    container1.classList.add("right-panel-active");
                };
            </script>

        <?php
            return false;
        } else if (!(preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/', $password))) {
        ?>
            <script>
                const errPassword = document.getElementById('errPassword');
                errPassword.innerHTML = "La password deve essere composta da almeno 8 caratteri e contenere almeno una lettera minuscola, una maiuscola e un numero.";
                const container5 = document.getElementById('container');
                {
                    container5.classList.add("right-panel-active");
                };
            </script>

        <?php
            return false;
        } else {
            return true;
        }
    }


    function verificaUsername($username)
    {

        include 'connessione.php';
        $queryUsername = "SELECT * FROM profilo WHERE username='$username'";
        $resultUsername = $db_conn->query($queryUsername);
        if ($resultUsername->num_rows > 0) {
        ?>
            <script>
                const errUsername = document.getElementById('errUsername');
                errUsername.innerHTML = "Username già in uso";
                const container4 = document.getElementById('container');
                {
                    container4.classList.add("right-panel-active");
                };
            </script>

        <?php return false;
        } else {
            return true;
        }
    }

    function verificaEmail($email)
    {

        include 'connessione.php';
        $queryEmail = "SELECT * FROM profilo WHERE email='$email'";
        $resultEmail = $db_conn->query($queryEmail);
        if ($resultEmail->num_rows > 0) {

        ?>
            <script>
                const errEmail = document.getElementById('errEmail');
                errEmail.innerHTML = "L'indirizzo email è già in uso";
                const container2 = document.getElementById('container');
                {
                    container2.classList.add("right-panel-active");
                };
            </script>

            <?php return false;
        } else {
            return true;
        }
    }


    if (verificaPassword($password, $confermaPassword) && verificaUsername($username) && verificaEmail($email)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO profilo (email,username,password,dataIscrizione) VALUES ('$email','$username','$hashed_password','$date')";
        if ($db_conn->query($sql) == true) {
            header("Refresh:0");
            exit();
        } else {
            echo "Errore durante registrazione utente";
        }
    }
}

function modificaUltimoAccesso($date)
{
    include 'connessione.php';
    $query = "UPDATE profilo SET ultimoAccesso ='$date' WHERE username = '" . $_SESSION['username'] . "'";
    mysqli_query($db_conn, $query);
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['accedi'])) {
    $username_or_email = $db_conn->real_escape_string($_POST['username']);
    $password = $db_conn->real_escape_string($_POST['password']);

    $sql_select = "SELECT * FROM profilo WHERE username = '$username_or_email' OR email = '$username_or_email'";
    if ($result = $db_conn->query($sql_select)) {
        if ($result->num_rows == 1) {
            //trovata una corrispondenza db
            $row = $result->fetch_array(MYSQLI_ASSOC);
            if (password_verify($password, $row['password'])) {
                session_start();
                $_SESSION['loggato'] = true;
                $_SESSION['idProfilo'] = $row['idProfilo'];
                $_SESSION['username'] = $row['username'];
                $date = date("Y-m-d H:i:s");
                modificaUltimoAccesso($date);
                header("location: area_privata_personale.php");
                exit;
            } else {
            ?>
                <script>
                    const errPassword1 = document.getElementById('errLogin');
                    errPassword1.innerHTML = "Password errata";
                </script>

            <?php
                exit;
            }
        } else {
            ?>
            <script>
                const errUtente = document.getElementById('errLogin');
                errUtente.innerHTML = "Non ci sono account con questo username";
            </script>
<?php exit;
        }
    }
}


ob_end_flush();
?>