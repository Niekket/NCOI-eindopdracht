<?php

include "../includes/db.php"; // include database connection

// Haalt data op uit de database en vergelijkt de user input met de column 'name_athlete'
if (isset($_POST["searchAthlete"])) {
    $checkAthlete = htmlspecialchars(mysqli_real_escape_string($connection, $_POST["searchAthlete"]));
    $query = "SELECT * FROM `athletes` WHERE `name_athlete` LIKE '%" . $checkAthlete . "%'";
    $result = mysqli_query($connection, $query);

    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        // push de resultaten in de data array
        $data[] = $row;
    }
    // echo de array data in JSON formaat
    echo json_encode($data);
}