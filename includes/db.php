<?php
$localhost = "localhost";
$user = "ericncoi";
$passDatabase = "ncoi";
$database = "eindopdracht_ncoi";

// Het daadwerkelijke connectie met de database en die() wanneer de connectie faalt
$connection = mysqli_connect($localhost, $user, $passDatabase, $database);

// Kleine if statement om te checken of de connectie het doet
if (!$connection) {
    die("Unable to connect to database: <br>" . "$localhost, $user, $passDatabase, $database");
}