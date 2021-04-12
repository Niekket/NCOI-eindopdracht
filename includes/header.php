<!--Een sessie starten over de hele pagina-->
<?php session_start();?>
<!--Een JS variable declared met daarin opgeslagen een 1 of een 0. Wanneer de sessie is aangemaakt en
de gebruik dus is ingelogd, 1 opslaan in de variable oftewel true, anders 0/false. -->
<?php $sessionIsLoggedIn = (isset($_SESSION['userid'])) ? 1 : 0;?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="ie=edge" http-equiv="X-UA-Compatible">
    <title>Eindopdracht NCOI Atleten</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Muli" rel="stylesheet">
    <link href="../css/custom.css" rel="stylesheet">
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
    <script>
        // echo de var en stop de var in isLoggedIn, nu globaal te bereiken via script.js
        var isLoggedIn = <?php echo $sessionIsLoggedIn; ?>;
    </script>
</head>

<body>

    <header>
        <nav class="navbar navbar-expand-sm navbar-light nav">
            <div class="container-fluid">

                <img alt="" class="mr-2" height="30" src="../img/arm-muscles-silhouette.png" width="30">
                <a class="navbar-brand mr-5" href="http://localhost:8888/athletes/index/index.php">ncoi athletes</a>
                <button aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation"
                    class="navbar-toggler" data-target="#navbarText" data-toggle="collapse" type="button">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarText">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="http://localhost:8888/athletes/index/index.php">Home<span
                                    class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Athletes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">About us</a>
                        </li>
                    </ul>
                    <!-- If/else statement om te checken of er een session is aangemaakt, zo ja toon dan logout btn, anders toon login/register btn -->
                    <?php

if (isset($_SESSION["userid"])) {
    echo '<form action="../includes/actions.php" method="post">
            <button type="submit" name="btn-logout" class="btn btn-dark btn-sm">Logout</button>
          </form>';
} else {
    echo ' <button type="button" class="btn btn-dark btn-sm mr-3" data-toggle="modal" data-target="#login">Login</button>
           <button type="button" class="btn btn-dark btn-sm" data-toggle="modal" data-target="#register">Register</button>';
}
?>
                </div>
            </div>
        </nav>
    </header>