<?php
$showError = "false"; 
if($_SERVER["REQUEST_METHOD"] == "POST"){
    include '_dbconnect.php';
    $user_email = $_POST['signupEmail'];
    $user_name = $_POST['signupUsername'];
    $pass = $_POST['signupPassword'];
    $cpass = $_POST['signupcPassword'];

    // Check whether this email exists
    $existSql = "select * from `users` where user_email='$user_email' OR user_name='$user_name'";
    $result = mysqli_query($conn, $existSql);
    $numRows = mysqli_num_rows($result);
    if($numRows>0){
        $showError = "Email or Username already in use";
    }
    else{
        if($pass == $cpass){
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `users` (`user_name`, `user_email`, 
            `user_pass`, `timestamp`)
             VALUES ( '$user_name', '$user_email', '$hash',
              current_timestamp())";
            $result = mysqli_query($conn, $sql);

            if($result){
                $showAlert = true;
                header("Location: /forum/index.php?signupsuccess=true");
                exit();
            }

        }
        else{
            $showError = "Passwords do not match"; 
           
        }
    }
    header ("Location: /forum/index.php?signupsuccess=false&error=$showError");
            

}
?>