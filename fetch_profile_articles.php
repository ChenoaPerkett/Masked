<?php
$servername = "localhost";
$username = "root";
$dbpassword = "";
$dbname = "u19109572";

$conn = new mysqli($servername, $username, $dbpassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$profileId = $_GET['user']; // Replace with the actual profile ID of the user
// Retrieve articles written by the user's profile
$query = "SELECT * FROM Articles WHERE user_id = $profileId";
$result = $conn->query($query);

$writtenArticles = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $writtenArticles[] = $row;
    }
}

// Retrieve articles read by the user's profile
$query = "SELECT ra.read_id, a.* FROM ReadArticles ra
          INNER JOIN Articles a ON ra.article_id = a.article_id
          WHERE ra.user_id = $profileId";
$result = $conn->query($query);

$readArticles = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $readArticles[] = $row;
    }
}
$combinedArticles = [];

// Loop through read articles
foreach ($readArticles as $readArticle) {
    $articleId = $readArticle['article_id'];
    
    // Check if the article is not already in the combined array
    if (!array_key_exists($articleId, $combinedArticles)) {
        $combinedArticles[$articleId] = $readArticle;
    }
}

// Loop through written articles
foreach ($writtenArticles as $writtenArticle) {
    $articleId = $writtenArticle['article_id'];
    
    // Check if the article is not already in the combined array
    if (!array_key_exists($articleId, $combinedArticles)) {
        $combinedArticles[$articleId] = $writtenArticle;
    }
}

// Convert the combined array to a numerically indexed array (optional)
// $combinedArticles = array_values($combinedArticles);

// Now $combinedArticles contains a unique set of articles from both $readArticles and $writtenArticles


$conn->close();

echo json_encode($combinedArticles);