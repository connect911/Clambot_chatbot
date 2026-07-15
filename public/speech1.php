<?php
$conn = mysqli_connect('localhost', 'root', '', 'chatbot');
if($_SERVER["REQUEST_METHOD"] === "POST") {
    $speechData = $_POST["text"];
    $sql = "INSERT INTO spokenword (words) VALUES ('$speechData')";
    $query = mysqli_query($conn, $sql);

    if ($query) {
        echo "Spoken words stored successfully!";
    } else {
        echo "Error storing spoken words: " . mysqli_error($conn);
    }
}
?>
