<?php
session_start();

$servername = "localhost";
$username = "root";
$dbpassword = "";
$dbname = "u19109572";

// Create a database connection
$conn = new mysqli($servername, $username, $dbpassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user ID from the session
$userID = $_SESSION['user_id'];

// Get category name and description from the form
$categoryName = $_POST["categoryName"];
$categoryDescription = $_POST["categoryDescription"];

// Insert the new category into the database
$sql = "INSERT INTO categories (user_id, category_name, category_description) VALUES ('$userID', '$categoryName', '$categoryDescription')";
if ($conn->query($sql) === TRUE) {
    $categoryId = $conn->insert_id; // Get the ID of the newly inserted category

    // Loop through the selected articles
    foreach ($_POST["articleIds"] as $articleId) {
        // Insert the association between the category and the article
        $sql = "INSERT INTO category_articles (category_id, article_id) VALUES ('$categoryId', '$articleId')";
        if ($conn->query($sql) !== TRUE) {
            echo "Error associating article: " . $conn->error;
            // Handle the error as needed
        }
    }

    echo "Category and articles added successfully.";
} else {
    echo "Error adding category: " . $conn->error;
}


// Close the database connection
$conn->close();
