<?php
    date_default_timezone_set('Pacific/Auckland');
    // echo getenv(DB_HOST);
    // echo getenv(DB_USERNAME);
    // echo getenv(DB_PASSWORD);
    // echo getenv(DB_TABLE);
    $dbc = mysqli_connect(getenv('DB_HOST'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'), getenv('DB_TABLE'));

    if($dbc){
        // var_dump('we are connected');
        $dbc->set_charset('utf8mb4');
    } else {
        die('ERROR, connection could not be made to the database, please check your envirnoment varables in your .env file. There is an example provided if you do not have one.');
    }

 ?>
