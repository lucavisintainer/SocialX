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
    <title>Amicizie</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

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
    <?php include 'header.php'; ?>
    <div class="container mt-5" style="padding: 30px; margin-top: 50px; background-color: #fff; border-radius: 5px; box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);">
        <h1>Amicizie</h1>
        <table class="table">

            <tbody>
                <?php
                $idUtente = $_SESSION['idProfilo'];

                global $arrayAmici;
                global $stato;
                global $data;
                $arrayAmici = array();
                $stato = array();
                $data = array();
                $query = "SELECT * FROM amicizia WHERE fkProfilo1 = '$idUtente' OR fkProfilo2 = '$idUtente';";
                if ($result = $db_conn->query($query)) {
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        while ($row = $result->fetch_assoc()) {
                            if ($row['fkProfilo1'] != $idUtente) {
                                $arrayAmici[] = $row['fkProfilo1'];
                            } else {
                                $arrayAmici[] = $row['fkProfilo2'];
                            }
                            $stato[] = $row['stato'];
                            $data[] = $row['data'];
                        }
                    } else {
                        return 0;
                    }
                } else {
                    return 0;
                }
                if (amicizie($idUtente) == 0) {
                    echo "<br>Non hai amicizie";
                } else {
                    echo "          <thead>
                            <tr>
                                <th>Amico</th>
                                <th>Stato</th>
                                <th>Data</th>
                            </tr>
                            </thead>";
                    for ($i = 0; $i < count($arrayAmici); $i++) {
                        echo "<tr>
                        <td>" . idProfiloToUsername($arrayAmici[$i]) . "</td>
                        <td>" . $stato[$i] . "</td>
                        <td>" . $data[$i] . "</td>
                        <td>
                            <div class='btn-group ml-0' role='group'>
                                <a href='eliminaAmicizia.php?idAmico=".$arrayAmici[$i]."'>
                                    <img src='../img/icone/delete.png' width='25' height='25'>
                                </a>
                            </div>
                        </td>
                     </tr>";
                     
                    }
                    
                }
                ?>
            </tbody>
        </table>

    </div>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <!-- inclusione script JS Bootstrap -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <?php include 'footer.php'; ?>
</body>

</html>