<?php
session_start();
    $conn=mysqli_connect('localhost', 'root', '', 'chatbot');

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require 'vendor/autoload.php';

    function password_reset_link($name, $email, $token){
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'calmbot01@gmail.com';                     //SMTP username
            $mail->Password   = 'xxbe ncbh ddwz odwp';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
            //Recipients
            $mail->setFrom('calmbot01@gmail.com', $name);
            $mail->addAddress($email);     //Add a recipient
        
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Password reset Link from Calmbot';
            $mail->Body    = "Hello " . $name . "<br> You have recieved this email because you forget your password and request for reset it. Please click the link below: 
            <a href='http://localhost:3000/resetPassword.html?token=$token&email=$email'>Click Me</a>";
        
            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    if(isset($_POST['submit'])){
        $email= mysqli_real_escape_string($conn, $_POST['email']);
        $token= md5(rand());

        //check email registered or not
        $sql="SELECT email FROM signup WHERE email='$email' LIMIT 1";
        $result=mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) > 0){
            $row= mysqli_fetch_array($result);
            $name=$row['full_name'];
            $email=$row['email'];
            echo $email;            
            $sql= "UPDATE signup SET token='$token' WHERE email='$email' LIMIT 1";
            $result= mysqli_query($conn, $sql);
            if($result){
                password_reset_link($name, $email, $token);
                header('Location: resetPasswordLink.html');
            }
            else{
                $_SESSION['status']= 'Something went wrong';
                header('Location: forgot_password.html');
            }

        }
        else{
            $_SESSION['status']= 'Email not found';
            header('Location: forgot_password.html');
        }

    }
    
?>