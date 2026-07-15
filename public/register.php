<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
session_start();
    $conn=mysqli_connect('localhost', 'root', '','chatbot');

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require 'vendor/autoload.php';

    function verify_email($full_name, $email, $token){
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
            $mail->setFrom('calmbot01@gmail.com', $full_name);
            $mail->addAddress($email,);     //Add a recipient
        
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Email verification from Calmbot';
            $mail->Body    = "Hello " . $full_name . "<br> You have recieved this email because you try to register to CalmBot. Please click the link below: 
            <a href='http://localhost:3000/verifiedEmail?token=$token'>Click Me</a>";
            
            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

    }
    
    if(isset($_POST['submit'])){
        $full_name=$_POST['full_name'];
        $email=$_POST['email'];
        $pass=$_POST['pass'];
        $token= md5(rand());

        //check email already exists or not
        // $check_email="SELECT email FROM signup WHERE email='$email' LIMIT 1";
        // $result=mysqli_query($conn, $check_email);
        // if(mysqli_num_rows($result) > 0){
        //     $_SESSION['status']= 'Email already exists';
        //     header('Location: sign_up.html');
        // }else{
            $sql="INSERT INTO signup(full_name, email, pass, token) VALUES ('$full_name', '$email', '$pass', '$token')";
            $result=mysqli_query($conn, $sql);
            if($result){
                verify_email("$full_name", "$email", "$token");
                $_SESSION['status']= 'Registration successful';
                header('Location: verifyEmail.html');
            }else{
                $_SESSION['status']= 'Registration Failed';
                header('Location: sign_up.html');
            }
        // }



    }
?>