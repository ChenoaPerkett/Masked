<?php
$servername = "localhost";
// $username = "u19109572";
$username = "root";
$dbpassword = "";
// $dbpassword = "umambwmh";
$dbname = "u19109572";

$conn = new mysqli($servername, $username, $dbpassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the necessary elements are set
    $articleID = $_POST['articleID'];
    $userID = $_POST['userID'];
    if (isset($_POST['rating'])) {
        $rating = $_POST['rating'];

        // Process the rating data and store it in your "Rating" table
        // Insert data into the "Rating" table, including article_id, user_id, and rating value
        $sql = "INSERT INTO rating (article_id, user_id , value) 
        VALUES ('$articleID', '$userID', '$rating')";

        if ($conn->query($sql) === TRUE) {
            //echo "Article added successfully";
        } else {
            echo "Error: " . $conn->error;
        }
    }
   
} else {
    echo 'Invalid request.';
}
$conn->close();
?>