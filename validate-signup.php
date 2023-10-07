<?php
$servername = "localhost";
// $username = "u19109572";
$username = "root";
$dbpassword = "";
// $dbpassword = "umambwmh";
$dbname = "u19109572";

$name = $_POST["fname"];
$surname = $_POST["lname"];
$email = $_POST["email1"];
$date = $_POST["date"];
$password = $_POST["pass1"];

$conn = new mysqli($servername, $username, $dbpassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT email FROM users WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo 'unavailable';
} else {
    addUser($name, $surname, $email, $password, $date, $conn);
}

$conn->close();
function addUser($name, $surname, $email, $password, $date, $conn)
{
    $stmt = $conn->prepare("INSERT INTO users (name, surname, email, password, birthday) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $surname, $email, $password, $date);
    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
