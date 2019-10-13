<?php

    require("../templates/head.php");
    $bookID = $_GET['id'];
    $sql = "SELECT * FROM `books` WHERE _id = $bookID";
    $result = mysqli_query($dbc, $sql);

    if($result && mysqli_affected_rows($dbc) > 0){
        $singleBook = mysqli_fetch_array($result, MYSQLI_ASSOC);
        var_dump($singleBook);
    } else if ($result && mysqli_affected_rows($dbc) === 0){
        header("Location: ../errors/404.php");
    } else {
        die("something went wrong with getting a single movie");
    }
?>

<body>
    <?php require("../templates/banner.php"); ?>

    <div class="container">
        <?php require("../templates/nav.php"); ?>

        <div class="row mb-2">
            <div class="col">
                <h1><?php echo $singleMovie['title'] ?></h1>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col">
                <a class="btn btn-outline-primary" href="">Edit</a>
                <button class="btn btn-outline-danger" type="button" name="button" data-toggle="modal" data-target="#confirmModal">Delete</button>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-12 col-sm-4 align-self-center">
                <img class="img-fluid" src="images/shrek1.jpeg" alt="">
            </div>
            <div class="col-12 col-sm-8 align-self-center">
                <h3><?php echo $singleMovie['title'] ?></h3>
                <h4><?php echo $singleMovie['year'] ?></h4>
                <h4><?php echo $singleMovie['author_id'] ?></h4>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-12">
                <p><?php echo $singleMovie['description'] ?></p>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Are you sure you want to delete <?php echo $singleMovie['title']; ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger">Confirm Delete</button>
                </div>
            </div>
        </div>
    </div>

    <?php require("../templates/scripts.php"); ?>
</body>
</html>
