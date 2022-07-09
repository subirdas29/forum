<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <style>
    #ques {
        min-height: 500px;
    }
    </style>
    <title>Welcome to EngineeringDiscuss - Forums</title>
</head>

<body>
    <?php include 'partials/_header.php';?>
    <?php include 'partials/_dbconnect.php';?>

    <?php
    $id = $_GET['catid'];
    $sql = "SELECT * FROM `catagories` WHERE category_id=$id"; 
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result)){
        $catname = $row['category_name'];
        $catdesc = $row['category_description'];
    }
    ?>
    <?php
    $showAleart=false;
    $method = $_SERVER['REQUEST_METHOD'];
    if($method=='POST'){
        $th_title=$_POST['title'];
        $th_desc=$_POST['desc'];
        $sql = "INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`,  `timestamp`)
         VALUES ('$th_title', '$th_desc', '$id', '0', current_timestamp())";
        $result = mysqli_query($conn, $sql);
        $showAleart=true;
        if($showAleart)
        {
            echo'<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Your thread has been added! Please wait for community to respond.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
          </div>';
        }
    };

    ?>

    <!--Category container start here-->
    <div class="container my-4">
        <div class="jumbotron">
            <h1 class="display-4">Welcome to <?php echo $catname;?> forum</h1>
            <p class="lead"><?php echo $catdesc;?></p>
            <hr class="my-4">
            <p>This is peer to peer forum.No Spam / Advertising / Self-promote in the forums.Do not post
                copyright-infringing material.
                Do not post “offensive” posts, links or images.Do not post “offensive” posts, links or images.Do not PM
                users asking for help.
            </p>
            <a class="btn btn-success btn-lg" href="#" role="button">Learn more</a>
        </div>

        <?php
        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
        echo '<div class="container">

            <h1 class="py-2">Start a Discussion</h1>
            <form action="'. $_SERVER["REQUEST_URI"] . '" method="post">
        <div class="form-group">
            <label for="exampleInputEmail1">Problem Title</label>
            <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
            <small id="emailHelp" class="form-text text-muted">Keep your title as short and crisp as possible

            </small>
        </div>
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Ellaborate your concern</label>
            <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </div>';
    }
    else{
    echo ' 
    <div class="container">
    <h1 class="py-2">Start a Discussion</h1>
    <p>You are not logged in.Please login to be able to start a Discussion</p></div>
    ';
    }
    ?>



        <div class="container" id="ques">
            <h1 class="py-2">Browse Questions</h1>
            <?php
            $id = $_GET['catid'];
            $sql = "SELECT * FROM `threads` WHERE thread_cat_id=$id"; 
            $result = mysqli_query($conn, $sql);
            $noResult=true;
            while($row = mysqli_fetch_assoc($result)){
                $noResult=false;
                $id = $row['thread_id'];
                $title = $row['thread_title'];
                $desc = $row['thread_desc'];
                $thread_time = $row['timestamp'];
                


           echo ' <div class="media my-3">
                <img src="Images/userdefault.png" width=54px class="mr-3" alt="...">
                <div class="media-body">
                <p class="font-weight-bold my-0">Anonymous User at '.$thread_time.'</p>
                    <h5 class="mt-0"><a class="text-dark" href="thread.php?threadid='.$id.'">'.$title.'</a></h5>
                    '.$desc.'
                </div>
            </div>';

        }
        if($noResult)
        {
            echo'<div class="jumbotron jumbotron-fluid">
            <div class="container">
              <p class="display-4">No Threads Found</p>
              <p class="lead">Be the first person to ask a question</p>
            </div>
          </div>';
        }
        ?>

        </div>
    </div>
    <?php include 'partials/_footer.php';?>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">
    </script>
</body>

</html>