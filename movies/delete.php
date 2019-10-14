<?php
    $id = $_POST['movieID'];
    require "../vendor/autoload.php";

    $dotenv = Dotenv\Dotenv::create(__DIR__ . "/..");
    $dotenv->load();

    require('../templates/connection.php');

    $sql = "DELETE FROM `movies` WHERE _id = $id";

    $result = mysqli_query($dbc, $sql);

    if ($result && mysqli_affected_rows($dbc) > 0) {
        header('Location: ../movies/allMovies.php');
    } else if ($result && mysql_affected_rows($dbc) === 0 ){
        header('Location: ../errors/404.php');
    } else {
        die('Something went wrong with deleting a movie');
    }
