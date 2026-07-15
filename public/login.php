
<?php
session_start();
    $conn=mysqli_connect('localhost', 'root', '', 'chatbot');

    if(isset($_POST['submit'])){
        if(!empty(trim($_POST['email'])) && !empty(trim($_POST['pass']))){
            $email=mysqli_real_escape_string($conn, $_POST['email']);
            $pass=mysqli_real_escape_string($conn, $_POST['pass']);

            $sql="SELECT * FROM signup WHERE email='$email' AND pass='$pass' LIMIT 1";
            $result= mysqli_query($conn, $sql);
            if(mysqli_num_rows($result) > 0){
                $row=mysqli_fetch_array($result);
                if($row['verify_status'] == '1'){
                    $_SESSION['authenticated']= true;
                    $_SESSION['auth_user']= [
                        'ful_name' => $row['full_name'],
                        'email' => $row['email'],
                    ];

                    $sql="SELECT email FROM signup WHERE email='$email' LIMIT 1";
                    $result=mysqli_query($conn, $sql);
                    if(mysqli_num_rows($result) > 0){
                        $sql = "INSERT INTO login (email, pass) VALUES ('$email', '$pass')";
                        $result=mysqli_query($conn, $sql);
                        header('Location: index.html');
                    }else{
                        $_SESSION['status']= 'Your are not registered user';
                        header('Location: login.html');
                    }
                }else{
                    $_SESSION['status']= 'your are not verified user';
                    header('Location: sign_up.html');
                }
            }
        }
    }

?>