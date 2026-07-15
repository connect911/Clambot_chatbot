<?php
    session_start();
            if(isset($_SESSION['status'])){
                ?>
                <div class="alert alert-success">
                    <h5><?= $_SESSION['status']; ?></h5>
                </div>
                <?php
                    unset($_SESSION['status']);
            }
    $conn=mysqli_connect('localhost', 'root', '', 'chatbot');

    if(isset($_GET['token'])){
        $token= $_GET['token'];
        $sql="SELECT token, verify_status FROM signup WHERE token='$token' LIMIT 1";
        $result=mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) > 0){
            $row=mysqli_fetch_array($result);
            if($row['verify_status'] == '0'){
                $click_token=$row['token'];
                $sql="UPDATE signup SET verify_status='1' WHERE token='$click_token' LIMIT 1";
                $result= mysqli_query($conn, $sql);
            }
            if($result){
                $_SESSION['status']= 'Verified';
                header('Location: login.html');
            }
        }
        // else{
        //     $_SESSION['status']= 'Already verified';
        //     header('Location: login.html');
        // }

    }
    // else{
    //     $_SESSION['status']= 'Invalid token';
    //     header('Location: login.html');
    // }
?>