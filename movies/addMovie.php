<?php
    require("../templates/head.php");

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
            $safeDirector = mysqli_real_escape_string($dbc, $author);
            $safeYear = mysqli_real_escape_string($dbc, $year);
            $safeDescription = mysqli_real_escape_string($dbc, $description);

            $directorID = 1;

            $moviesSql = "INSERT INTO `movies`( `title`, `year`, `description`, `director_id`) VALUES ('$safeTitle',$safeYear,'$safeDescription',$directorID)";
            $moviesResult = mysqli_query($dbc, $moviesSql);
            if($moviesResult && mysqli_affected_rows($dbc) > 0){
                header('Location: singleMovie.php');
            } else {
                die('Something went wrong with adding in our movies');
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
                <form action="" method="post" enctype="multipart/form-data" autocomplete="off">
                    <div class="form-group">
                      <label for="title">Movie Title</label>
                      <input type="text" class="form-control" name="title"  placeholder="Enter movie title" value="<?php if($_POST){ echo $title; }; ?>">
                    </div>

                    <div class="form-group">
                      <label for="year">Year</label>
                      <input type="number" autocomplete="off" class="form-control"  name="year" placeholder="Enter the year it was released" max="<?php echo date('Y'); ?>" value="<?php if($_POST){ echo $year; }; ?>">
                    </div>

                    <div class="form-group director-group">
                      <label for="director">Director/s</label>
                      <input type="text" autocomplete="off" class="form-control"  name="director" placeholder="Enter the movies director" value="<?php if($_POST){ echo $director; }; ?>">
                    </div>

                    <div class="form-group">
                      <label for="description">Movie Description</label>
                      <textarea class="form-control" name="description" rows="8" cols="80" placeholder="Description about the movie"><?php if($_POST){ echo $description; }; ?></textarea>
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
