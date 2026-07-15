<?php
session_start();
    $conn=mysqli_connect('localhost', 'root', '', 'chatbot');

    if(isset($_POST['reset_submit'])){
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $new_pass = mysqli_real_escape_string($conn, $_POST['new_pass']);
        $pass = mysqli_real_escape_string($conn, $_POST['pass']);
        $token = mysqli_real_escape_string($conn, $_POST['password_token']);
    
        if(!empty($token)){
            if(!empty($email) && !empty($new_pass) && !empty($pass)){
                $sql = "SELECT token FROM signup WHERE token='$token' LIMIT 1";
                $result = mysqli_query($conn, $sql);
    
                if(mysqli_num_rows($result) > 0){
                    if($new_pass == $pass){
    
                        $sql = "UPDATE signup SET pass='$new_pass' WHERE token='$token' LIMIT 1";
                        $update_result = mysqli_query($conn, $sql);
                        if($update_result){
                            $_SESSION['status'] = 'Password successfully updated';
                            header('Location: login.html');
                            exit();
                        }
                        // else {
                        //     $_SESSION['status'] = 'Failed to update password';
                        //     header('Location: resetPassword.php');
                        //     exit();
                        // }
                    } 
                    // else {
                    //     $_SESSION['status'] = 'New password and confirm password do not match';
                    //     header('Location: resetPassword.php');
                    //     exit();
                    // }
                } 
                // else {
                //     $_SESSION['status'] = 'Invalid token';
                //     header('Location: resetPassword.php');
                //     exit();
                // }
            }
        } 
        // else {
        //     $_SESSION['status'] = 'Invalid token';
        //     header('Location: resetPassword.php');
        //     exit();
        // }
    }

?>