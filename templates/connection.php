<?php
    date_default_timezone_set('Pacific/Auckland');
    $dbc = mysqli_connect(getenv('DB_HOST'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'), getenv('DB_TABLE'));



 ?>
