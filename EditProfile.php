<?php
session_start();
$servername = "localhost";
$username = "root";
$dbpassword = "";
$dbname = "u19109572";

$conn = new mysqli($servername, $username, $dbpassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$userID = $_SESSION['user_id'];

if (isset($_POST['deleteAccount'])) {
    // Delete the user's articles from ReadArticles first
    $deleteReadArticlesQuery = "DELETE FROM ReadArticles WHERE article_id IN (SELECT article_id FROM Articles WHERE user_id = '$userID')";
    
    if ($conn->query($deleteReadArticlesQuery) === TRUE) {
        // Delete the user's articles from Category_Articles
        $deleteCategoryArticlesQuery = "DELETE FROM Category_Articles WHERE article_id IN (SELECT article_id FROM Articles WHERE user_id = '$userID')";
        
        if ($conn->query($deleteCategoryArticlesQuery) === TRUE) {
            // Now delete the user's articles
            $deleteArticlesQuery = "DELETE FROM Articles WHERE user_id = '$userID'";
            
            if ($conn->query($deleteArticlesQuery) === TRUE) {
                // User's articles have been deleted, now delete the user
                $deleteUserQuery = "DELETE FROM users WHERE user_id = '$userID'";
                
                if ($conn->query($deleteUserQuery) === TRUE) {
                    // User has been deleted successfully, log out and redirect to index.php
                    session_destroy(); // Destroy the current session
                    header("Location: index.php");
                    exit();
                } else {
                    echo "Error deleting user: " . $conn->error;
                }
            } else {
                echo "Error deleting articles: " . $conn->error;
            }
        } else {
            echo "Error deleting articles from Category_Articles: " . $conn->error;
        }
    } else {
        echo "Error deleting articles from ReadArticles: " . $conn->error;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $surname = $_POST["surname"];
    $birthday = $_POST["birthday"];
    $email = $_POST["email"];

    if (isset($_FILES['profile_image'])) {
    $file = $_FILES['profile_image'];
    $uploadDirectory = 'profile_images/';
    $fileName = $file['name'];
    $targetPath = $uploadDirectory . $fileName;

    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        $query = "UPDATE users SET name='$name', surname='$surname', birthday='$birthday', email='$email' , profile_image='$targetPath' WHERE user_id='$userID'";
        if ($conn->query($query) === TRUE) {
            echo "Record successful";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        // Error handling if the file upload fails
        echo 'error';
    }
} 
    $query = "UPDATE users SET name='$name', surname='$surname', birthday='$birthday', email='$email' WHERE user_id='$userID'";
    if ($conn->query($query) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    };


}

$query = "SELECT * FROM users WHERE user_id = '$userID'";
$result = $conn->query($query);
$row = mysqli_fetch_array($result);
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
    <link rel="stylesheet" href="style/styleHome.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Edit Profile</title>
</head>

<body>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
        <input type="file" name="profile_image" id="fileUpload" accept="image/*">
        <img id="profileImage" src="<?php echo $row['profile_image'] ? $row['profile_image'] : 'images/logo.png'; ?>"  alt="Profile Image">
        Name: <input type="text" name="name" value="<?php echo $row['name'] ?>"><br>
        Surname: <input type="text" name="surname" value="<?php echo $row['surname'] ?>"><br>
        Birthday: <input type="date" name="birthday" value="<?php echo $row['birthday'] ?>"><br>
        Email: <input type="email" name="email" value="<?php echo $row['email'] ?>"><br>
        <input type="submit">
    </form>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?user=' . $userID; ?>">
    <button type="submit" name="deleteAccount" class="btn btn-danger">Delete Account</button>
</form>
</body>

</html>