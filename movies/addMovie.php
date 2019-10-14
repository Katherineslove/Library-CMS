<?php
    require("../templates/head.php");

    if(isset($_GET['id'])) {
        // var_dump("We are editing a movie");
        $pageTitle = "Edit Movie";
        $movieID = $_GET['id'];
        $sql = "SELECT movies.`_id` as movieID, `title`, `year`, `description`, authors.name as author_name FROM `movies` INNER JOIN authors ON movie.director_id = directors._id WHERE movie._id = $movieID";
        $result = mysqli_query($dbc, $sql);
        if($result && mysqli_affected_rows($dbc) > 0){
            $singleMovie = mysqli_fetch_array($result, MYSQLI_ASSOC);
            // var_dump($singleMovie);
            extract($singleMovie);
        } else if ($result && mysqli_affected_rows($dbc) === 0){
            header("Location: ../errors/404.php");
        } else {
            die("something went wrong with getting a single movie");
        }
    } else {
        // var_dump("We are adding a new movie");
        $pageTitle = "Add New Movie";
    }

    if ($_POST) {
        // var_dump($_POST);
        // var_dump("You have submitted a form");
        extract($_POST);
        // var_dump($title);
        // var_dump($year);
        // var_dump($director);
        // var_dump($description);

        $errors = array();

        if(empty($title)){
            // var_dump("the title is empty");
            array_push($errors, "The title is empty, please add a value");
        } else if(strlen($title) < 5 ){
            // var_dump("the length must be at least 5");
            array_push($errors, "The title length must be at least 5 characters");
        } else if(strlen($title) > 100){
            // var_dump("the length must be less than 100");
            array_push($errors, "The title length must be no more than 100 characters");
        }

        if(empty($year)){
            array_push($errors, "The year is empty, please add a value");
        } else if(strlen($year) < 4 ){
            array_push($errors, "The year length must be less than 4");
        }

        if(empty($director)){
            array_push($errors, "The director is empty, please add a value");
        } else if(strlen($director) < 5 ){
            array_push($errors, "The director length must be at least 5 characters");
        } else if(strlen($director) > 100){
            array_push($errors, "The director length must be no more than 100 characters");
        }

        if(empty($description)){
            array_push($errors, "The description is empty, please add a value");
        } else if(strlen($description) < 10 ){
            array_push($errors, "The description length must be at least 10 characters");
        } else if(strlen($description) > 65535){
            array_push($errors, "The description length must be no more than 65535 characters");
        }

        if(empty($errors)){
            // $title = mysqli_real_escape_string($dbc, $title);
            $safeTitle = mysqli_real_escape_string($dbc, $title);
            $safeDirector = mysqli_real_escape_string($dbc, $director);
            $safeYear = mysqli_real_escape_string($dbc, $year);
            $safeDescription = mysqli_real_escape_string($dbc, $description);

            $findSql = "SELECT * FROM `directors` WHERE name = '$safeDirector'";
            $findResult = mysqli_query($dbc, $findSql);
            if($findResult && mysqli_affected_rows($dbc) > 0){
                $foundDirector = mysqli_fetch_array($findResult, MYSQLI_ASSOC);
                $directorID = $foundDirector["_id"];
            } else if ($findResult && mysqli_affected_rows($dbc) === 0){
                $sql = "INSERT INTO `directors`(`name`) VALUES ('$safeDirector')";
                $result = mysqli_query($dbc, $sql);
                if($result && mysqli_affected_rows($dbc) > 0){
                    $directorID = $dbc->insert_id;
                } else {
                    die("Something went wrong with adding in our directors");
                }
            } else {
                die("Something went wrong with adding in our movies");
            }

            if (isset($_GET['id'])) {
                $moviesSql = "UPDATE `movies` SET `title`= '$safeTitle',`year`= $safeYear,`description`='$safeDescription',`director_id`= $directorID WHERE _id = $movieID";
            } else {
                $moviesSql = "INSERT INTO `movies`( `title`, `year`, `description`, `director_id`) VALUES ('$safeTitle',$safeYear,'$safeDescription',$directorID)";
            }

            $moviesResult = mysqli_query($dbc, $moviesSql);
            if($moviesResult && mysqli_affected_rows($dbc) > 0){
                if (!isset($_GET['id'])) {
                    $movieID = $dbc->insert_id;
                }
                header("Location: singleMovie.php?id=".$movieID);
            } else {
                die("Something went wrong with adding in our movies");
            }

        }
    }
?>

<body>
    <?php require("../templates/banner.php"); ?>

    <div class="container">
        <?php require("../templates/nav.php"); ?>

        <div class="row mb-2">
            <div class="col">
                <h1>Add New Movie</h1>
            </div>
        </div>

        <?php if($_POST && !empty($errors)): ?>
            <div class="row mb-2">
                <div class="col">
                    <div class="alert alert-danger pb-0" role="alert">
                        <ul>
                            <?php foreach($errors as $error): ?>
                                <li><?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="row mb-2">
            <div class="col">
                <form action="./movies/addMovie.php<?php if(isset($_GET['id'])){ echo '?id='.$_GET['id'];};?>" method="post" enctype="multipart/form-data" autocomplete="off">
                    <div class="form-group">
                      <label for="title">Movie Title</label>
                      <input type="text" class="form-control" name="title"  placeholder="Enter movie title" value="<?php if(isset($title)){ echo $title; }; ?>">
                    </div>

                    <div class="form-group">
                      <label for="year">Year</label>
                      <input type="number" autocomplete="off" class="form-control"  name="year" placeholder="Enter the year it was released" max="<?php echo date('Y'); ?>" value="<?php if(isset($year)){ echo $year; }; ?>">
                    </div>

                    <div class="form-group director-group">
                      <label for="director">Director/s</label>
                      <input type="text" autocomplete="off" class="form-control"  name="director" placeholder="Enter the movies director" value="<?php if(isset($director_name)){ echo $director_name; }; ?>">
                    </div>

                    <div class="form-group">
                      <label for="description">Movie Description</label>
                      <textarea class="form-control" name="description" rows="8" cols="80" placeholder="Description about the movie"><?php if(isset($description)){ echo $description; }; ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="file">Upload an Image</label>
                        <input type="file" name="image" class="form-control-file">
                    </div>

                    <button type="submit" class="btn btn-outline-info btn-block">Submit</button>
                </form>
            </div>
        </div>

    </div>

    <?php require("../templates/scripts.php"); ?>
</body>
</html>
