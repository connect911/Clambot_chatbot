<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '', 'chatbot');

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Logout functionality
if (isset($_GET['logout'])) {
    // Unset all of the session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Close the database connection
    mysqli_close($conn);

    // Redirect to the login page
    header("Location: firstPage.html");
    exit();
}

// Login functionality (this part might be in a separate file for better organization)
if (isset($_POST['submit'])) {
    if (!empty(trim($_POST['email'])) && !empty(trim($_POST['pass']))) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $pass = mysqli_real_escape_string($conn, $_POST['pass']);

        $sql = "SELECT * FROM signup WHERE email='$email' AND pass='$pass' LIMIT 1";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);
            if ($row['verify_status'] == '1') {
                $_SESSION['authenticated'] = true;
                $_SESSION['auth_user'] = [
                    'full_name' => $row['full_name'],
                    'email' => $row['email'],
                ];

                $sql = "SELECT email FROM signup WHERE email='$email' LIMIT 1";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    $sql = "INSERT INTO login(email, pass) VALUES('$email', '$pass')";
                    $result = mysqli_query($conn, $sql);
                    header('Location: firstPage.html');
                    exit();
                } else {
                    $_SESSION['status'] = 'You are not a registered user';
                    header('Location: login.html');
                    exit();
                }
            } else {
                $_SESSION['status'] = 'You are not a verified user';
                header('Location: sign_up.html');
                exit();
            }
        }
    }
}

mysqli_close($conn);
?>
