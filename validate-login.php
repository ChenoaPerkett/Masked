<?php
session_start();
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
	
    $email = isset( $_POST["loginEmail"]) ? $_POST["loginEmail"] : null;
	$pass = isset($_POST["loginPass"]) ? $_POST["loginPass"] : null;

	$query = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($query);
	$row = mysqli_fetch_array($result);
	$userID = $row['user_id'];
	$_SESSION['user_id'] = $userID;
	if ($result->num_rows > 0) {
		// Redirect to home.php
		header("Location: home.php");
		exit(); // Make sure to exit to prevent further execution
	}

$conn->close();
