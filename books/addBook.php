<?php
    require("../templates/head.php");

    if ($_POST) {
        // var_dump($_POST);
        // var_dump("You have submitted a form");
        extract($_POST);
        // var_dump($title);
        // var_dump($author);
        // var_dump($description);

        $errors = array();

        if(empty($title)){
            // var_dump('the title is empty');
            array_push($errors, "The title is empty, please add a value");
        } else if(strlen($title) < 5 ){
            // var_dump('the length must be at least 5');
            array_push($errors, "The title length must be at least 5 characters");
        } else if(strlen($title) > 100){
            // var_dump('the length must be less than 100');
            array_push($errors, "The title length must be no more than 100 characters");
        }

        if(empty($author)){
            array_push($errors, "The title is empty, please add a value");
        } else if(strlen($author) < 5 ){
            array_push($errors, "The author length must be at least 5 characters");
        } else if(strlen($author) > 100){
            array_push($errors, "The author length must be no more than 100 characters");
        }

        if(empty($description)){
            array_push($errors, "The title is empty, please add a value");
        } else if(strlen($description) < 10 ){
            array_push($errors, "The author length must be at least 10 characters");
        } else if(strlen($description) > 65535){
            array_push($errors, "The author length must be no more than 65535 characters");
        }
    }
?>

<body>
    <?php require("../templates/banner.php"); ?>

    <div class="container">
        <?php require("../templates/nav.php"); ?>

        <div class="row mb-2">
            <div class="col">
                <h1>Add New Book</h1>
            </div>
        </div>

        <?php if($_POST && !empty($errors)): ?>
            <div class="row mb-2">
                <div class="col">
                    <div class="alert alert-danger pb-0" role="alert">
                        <ul>
                            <li>Error Message</li>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="row mb-2">
            <div class="col">
                <form action="./books/addBook.php" method="post" enctype="multipart/form-data" autocomplete="off">
                    <div class="form-group">
                      <label for="title">Book Title</label>
                      <input type="text" class="form-control" name="title"  placeholder="Enter book title" value="">
                    </div>

                    <div class="form-group author-group">
                      <label for="author">Author</label>
                      <input type="text" autocomplete="off" class="form-control"  name="author" placeholder="Enter books author" value="">
                    </div>

                    <div class="form-group">
                      <label for="description">Book Description</label>
                      <textarea class="form-control" name="description" rows="8" cols="80" placeholder="Description about the book"></textarea>
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
