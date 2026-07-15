<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "chatbot";
    $connection = new mysqli($servername, $username, $password, $dbname);
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }
    function fetchUserProfileData($connection) {
        $query = "SELECT full_name, email FROM signup LIMIT 1"; 
        $result = $connection->query($query);
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return false;
        }
    }
    $userData = fetchUserProfileData($connection);
    $defaultProfilePicture = "default_profile_picture.jpg";
    $response = [
        'userData' => $userData,
        'profilePicture' => $defaultProfilePicture
    ];
    header('Content-Type: application/json');
    echo json_encode($response);
    $connection->close();
?>
