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
    <?php include 'header.php'; ?>

    <!-- Main Content -->
    <div class="container-fluid mt-3">
        <div class="row">
            <!-- Private Messages Section -->
            <div class="col-md-4">
                <h4 class="mb-3">Messaggi</h4>
                <div class="list-group" id="private-messages-tab" role="tablist">
                    <a class="list-group-item list-group-item-action active" id="private-messages-tab" data-toggle="list" href="#private-messages" role="tab" aria-controls="private-messages">John Doe</a>
                    <a class="list-group-item list-group-item-action" id="private-messages-tab" data-toggle="list" href="#private-messages" role="tab" aria-controls="private-messages">Jane Smith</a>
                    <a class="list-group-item list-group-item-action" id="private-messages-tab" data-toggle="list" href="#private-messages" role="tab" aria-controls="private-messages">Bob Johnson</a>
                </div>
            </div>
            <!-- Private Messages Section -->

            <!-- Chat Section -->
            <div class="col-md-8">
                <div class="tab-content" id="chat-tab-content">
                    <div class="tab-pane fade show active" id="private-messages" role="tabpanel" aria-labelledby="private-messages-tab">
                        <h4 class="mb-3">John Doe</h4>
                        <div class="card">
                            <div class="card-body">
                            <div class="media mb-3">
                                <img class="mr-3 rounded-circle" src="https://via.placeholder.com/50x50" alt="User Avatar">
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
                                <img class="ml-3 rounded-circle" src="https://via.placeholder.com/50x50" alt="User Avatar">
                            </div>
                            <form>
                                <div class="form-group">
                                    <textarea class="form-control" id="message-textarea" rows="3" placeholder="Type your message here..."></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Send</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="group-messages" role="tabpanel" aria-labelledby="group-messages-tab">
                    <h4 class="mb-3">Group Messages</h4>
                    <div class="list-group">
                        <a class="list-group-item list-group-item-action" href="#">Group 1</a>
                        <a class="list-group-item list-group-item-action" href="#">Group 2</a>
                        <a class="list-group-item list-group-item-action" href="#">Group 3</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Chat Section -->
    </div>
</div>

<!-- Bootstrap JavaScript and jQuery -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
                                