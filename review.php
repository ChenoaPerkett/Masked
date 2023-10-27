<?php
$servername = "localhost";
$username = "root";
$dbpassword = "";
$dbname = "u19109572";

$conn = new mysqli($servername, $username, $dbpassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the necessary elements are set
    $articleID = $_POST['articleID'];
    $userID = $_POST['userID'];
    if (isset($_POST['comment'])) {
        $comment = $_POST['comment'];

        // Process the review text and store it in the "Review" table
        $sql = "INSERT INTO review (article_id, user_id, review_text) 
            VALUES ('$articleID', '$userID', '$comment')";

        if ($conn->query($sql) === TRUE) {
            // Review text added successfully
        } else {
            echo "Error: " . $conn->error;
        }

        if (isset($_FILES['image'])) {
            // Process file upload for the image
            $image = file_get_contents($_FILES['image']['tmp_name']); // Get the image content

            // Store the image data in the "Review" table
            $sql = "UPDATE review SET image = ? WHERE article_id = ? AND user_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sii", $image, $articleID, $userID);
            if ($stmt->execute()) {
                // Image added successfully
            } else {
                echo "Error: " . $conn->error;
            }
        }
        echo 'Rating and review submitted successfully.';
    } else {
        echo 'Incomplete data provided.';
    }
} else {
    echo 'Invalid request.';
}

$conn->close();
?>
