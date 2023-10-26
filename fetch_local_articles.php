<?php
$servername = "localhost";
$username = "root";
$dbpassword = "";
$dbname = "u19109572";

$conn = new mysqli($servername, $username, $dbpassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$UserId = $_GET['user'];
$query = "SELECT * FROM articles WHERE user_id = $UserId
UNION
SELECT A.*
FROM Articles AS A
INNER JOIN Followers AS F ON A.user_id = F.following_id
WHERE F.follower_id = $UserId ORDER BY date DESC";
$result = $conn->query($query);
$articles = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $articles[] = $row;
    }
}

$conn->close();

echo json_encode($articles);
