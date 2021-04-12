<?php

include "../includes/db.php"; // include database connection

$showData = '';

function splitAthleteFileAddDataOnce()
{

    global $connection;

// Split the content in de file elk op een nieuwe lijn
    $content = file_get_contents("../txt/athletes.txt");
    $split = explode("\n", $content);
    $athletes = [];
    $i = 0;

// Stop de data in een object en push de data naar de lege array $athletes
    foreach ($split as $splitAthletes) {
        if ($i % 2 === 0) { // naam van athleten
            $currentAthlete = new stdClass;
            $currentAthlete->nameAthlete = trim($splitAthletes);
        } else { // info athleten
            $currentAthlete->infoAthlete = trim($splitAthletes);
            array_push($athletes, $currentAthlete);
        }
        $i++;
    }

    // Voegt de data 1x toe in de database na het openen van index.php
    // Na refreshen zal het niet meer werken want er zit een check over heen
    // De check is gekoppeld aan het aantal rows in de database die alleen de data
    // toevoegd wanneer de row count gelijk is aan 0. (Wat dus maar 1x is)
    // $check = 175 na 1x toevoegen van data
    $id = "SELECT `id` FROM `athletes`";
    $result = mysqli_query($connection, $id);
    $check = mysqli_num_rows($result);

    if ($check == 0) {
        foreach ($athletes as $k => $v) {
            $query = "INSERT INTO `athletes` (name_athlete, info_athlete) ";
            $query .= "VALUES ('" . addslashes($v->nameAthlete) . "','" . addslashes($v->infoAthlete) . "')";
            $result = mysqli_query($connection, $query);
        }
        if ($result) {
            echo "Records created";
        } else {
            die("Query insert FAILED!" . mysqli_error($connection));
        }
    }

}

if (isset($_POST["sign-up"])) {

    $fullName = $_POST["fullname"];
    $email = $_POST["email"];
    $password = $_POST["pass1"];

    // Kleine check die bijhoudt of het registratie forumulier wel is ingevuld, zo niet, dan maakt
    // die een session aan met een variable die getoond word op index.php
    if (empty($fullName) || empty($email) || empty($password) || !preg_match("/^[a-zA-Z0-9 ]*$/", $fullName)) {
        session_start();
        $_SESSION["nosucces"] = "nosucces";
        header("location: ../index/index.php?error=emptyfields");
        exit();
    }

    // Tegen SQLI Injection op de manual manier, kwam tegen online dat je ook 'Prepared Statements' kan doen wat
    // weer nog beter is, want je maakt gebruik van placeholders (?). Dit ga ik bij de 'sign-in' btn gebruiken
    $fullName = htmlspecialchars(mysqli_real_escape_string($connection, trim($fullName)));
    $email = htmlspecialchars(mysqli_real_escape_string($connection, trim($email)));
    $password = htmlspecialchars(mysqli_real_escape_string($connection, trim($password)));
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    $accountExistsCheck = "SELECT `email` FROM `users` WHERE email='$email'";
    $resultExistsCheck = mysqli_query($connection, $accountExistsCheck);

    // check of er een connectie is met de database
    if (!$resultExistsCheck) {
        header("location: ../index/index.php?error=noconnection");
        exit();
    }

    // check of de gebruiker al bestaat in de database
    if (mysqli_num_rows($resultExistsCheck) > 0) {
        session_start();
        $_SESSION["accountExists"] = "accountExists";
        header("location: ../index/index.php?error=userexists");
        exit();
    }

    // bestaat de gebruiker niet, maak dan een query aan en plaats nieuwe data in de database
    $query = "INSERT INTO `users`(`name`, `email`, `password`) ";
    $query .= "VALUES ('$fullName', '$email', '$passwordHash')";

    $result = mysqli_query($connection, $query);

    // check of er een connectie is met de database
    if (!$result) {
        header("location: ../index/index.php?error=noconnection");
        exit();
    }

    // Succes message die door word gegeven via de session op index.php
    session_start();
    $_SESSION["succes"] = "succes";
    header("location: ../index/index.php?succes=accountcreated");
    exit();

}

if (isset($_POST["sign-in"])) {

    $email = $_POST["email-login"];
    $password = $_POST["password-login"];

    // Kleine check die bijhoudt of het registratie forumulier wel is ingevuld, zo niet, dan maakt
    // die een session aan met een variable die getoond word op index.php
    if (empty($email) || empty($password)) {
        session_start();
        $_SESSION["nosucces"] = "nosucces";
        header("location: ../index/index.php?error=emptyfields");
        exit();
    }

    // prepared statement aanmaken
    $query = "SELECT * FROM `users` WHERE email=?";
    $stmt = mysqli_stmt_init($connection);
    if (!mysqli_stmt_prepare($stmt, $query)) {
        header("location: ../index/index.php?error=sqlerror");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($result)) {
        $passwordCheck = password_verify($password, $row["password"]);
        if ($passwordCheck == false) {
            header("location: ../index/index.php?error=wrongpassword");
            exit();
        } else {
            session_start();
            $_SESSION["userid"] = $row["id"];

            header("location: ../index/index.php?login=success");
            exit();
        }
    } else {
        header("location: ../index/index.php?error=nouser");
        exit();
    }
}

// Bij klik op btn-logout maakt die de sessie kapot en logged de user uit de desbetreffende pagina
if (isset($_POST["btn-logout"])) {
    session_start();
    session_unset();
    session_destroy();
    header("location: ../index/index.php");
}