<?php
include "../includes/db.php"; // include database connection

$name_athlete = $_POST["athleteName"];
$info_athlete = $_POST["athleteInfo"];
$id = $_POST["athleteId"];

// prepared statement aanmaken
$query = "UPDATE `athletes` SET name_athlete=?, info_athlete=? WHERE id=?";
$stmt = mysqli_stmt_init($connection);
if (!mysqli_stmt_prepare($stmt, $query)) {
    header("location: ../index/index.php?error=sqlerror");
    exit();
}

// update athletes set name = ?, info = ? where id = ?
// s = string, i = integer
mysqli_stmt_bind_param($stmt, "ssi", $name_athlete, $info_athlete, $id);
mysqli_stmt_execute($stmt);
