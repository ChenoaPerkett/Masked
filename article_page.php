<?php
session_start();
$servername = "localhost";
$username = "root"; // Update with your database username
$dbpassword = ""; // Update with your database password
$dbname = "u19109572";

$conn = new mysqli($servername, $username, $dbpassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$userID = $_SESSION['user_id'];
$articleID = $_GET['articleID']; // User whose profile is being viewed


$articlesQuery = "SELECT * FROM articles WHERE article_id = '$articleID'";
$articlesResult = $conn->query($articlesQuery);

$reviewsQuery = "SELECT users.name AS user_name, review.review_text, review.image
                 FROM review
                 INNER JOIN users ON review.user_id = users.user_id
                 WHERE review.article_id = '$articleID'";
$reviewsResult = $conn->query($reviewsQuery);


$ratingQuery = "SELECT users.name AS user_name, rating.value
                 FROM rating
                 INNER JOIN users ON rating.user_id = users.user_id
                 WHERE rating.article_id = '$articleID'";
$ratingResult = $conn->query($ratingQuery);


// Fetch the data for the article
$row = mysqli_fetch_array($articlesResult);
$review = mysqli_fetch_array($reviewsResult);
$rating = mysqli_fetch_array($ratingResult);
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="author" content="Chenoa Perkett" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=REM:wght@400;700&family=Roboto+Slab&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gloria+Hallelujah&family=Homemade+Apple&family=Montserrat:wght@400;800&display=swap" rel="stylesheet">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style/profile.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <title>Article </title>
</head>

<body>
    <section class="row">
        <div id="profile" class="row col-10 mt-3 offset-1">
            <div id="headings" class="card col-6 mt-4 mb-4 p-3 offset-2">
                <h1>Article page</h1>
                <hr />
                <hr />
                <img src="<?php echo $row['image'] ?>" alt="Profile Image" id="profileImage">
                <hr />
                <h1>title :<?php echo $row['title'] ?></h1>
                <p>Author: <?php echo $row['author'] ?></p>
                <p>Date: <?php echo $row['date'] ?></p>
                <p>Category: <?php echo $row['catorgory'] ?></p>
                <p>Description: <?php echo $row['description'] ?></p>
                <p>Full Article: <?php echo $row['full_article'] ?></p>
                        <?php
                        // If the current user is the author of the article, display an edit button
                        if ($userID == $row['user_id']) {
                            echo '<a href="edit_article.php?articleID=' . $row['article_id'] . '">Edit Article</a>';
                        }
                        ?>
                        <a href='home.php'><button>Back</button>
                    </a>
            </div>
            <div class= "row col-6 mt-4 mb-4 p-3 offset-2">
                    <div id="reviews" class="col-6">
                    <h2>Reviews</h2>
                    <?php
                    // Iterate through reviews and display them
                        for ($i = 0; $i < $reviewsResult->num_rows; $i++) {
                            echo '<p><strong>' . $review['user_name'] . '</strong></p>';
                            echo '<p>' . $review['review_text'] . '</p>';
                    
                            // Check if there is a review image
                            if ($review['image']) {
                                echo '<img src="' . $review['image'] . '" alt="Review Image">';
                            }
                        }
                        ?>
                </div>

                <!-- Add a div for ratings -->
                <div id="ratings" class="col-6">
                    <h2>Ratings</h2>
                    <?php
                    // Iterate through reviews and display them
                        for ($i = 0; $i < $ratingResult->num_rows; $i++) {
                            echo '<p><strong>' . $rating['user_name'] . '</strong> gave a rating of : ' . $rating['value'] . '</p>';
                
                        }
                        ?>
                </div>
                </div>
        </div>
    </section>
</body>
<script>
</script>
</html>