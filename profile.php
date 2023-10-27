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


$userID = $_SESSION['user_id'];
$profileUserID = $_GET['user']; // User whose profile is being viewed

// Check if the current user is already following the profile user
$checkQuery = "SELECT * FROM followers WHERE follower_id = '$userID' AND following_id = '$profileUserID'";
$checkResult = $conn->query($checkQuery);

if (isset($_POST['follow'])) {

    if ($checkResult->num_rows == 0) {
        // Current user is not following, so follow them
        $followQuery = "INSERT INTO followers (follower_id, following_id) VALUES ('$userID', '$profileUserID')";
        $conn->query($followQuery);

        $checkBackQuery = "SELECT * FROM followers WHERE follower_id = '$profileUserID' AND following_id = '$userID'";
        $checkBackResult = $conn->query($checkBackQuery);

        if ($checkBackResult->num_rows > 0) {
            // They follow each other, so add to friends database
            $addFriendQuery = "INSERT INTO friends (user_id, friend_id) VALUES ('$userID', '$profileUserID')";
            $conn->query($addFriendQuery);
        }
    } else {
        // Current user is already following, so unfollow them
        $unfollowQuery = "DELETE FROM followers WHERE follower_id = '$userID' AND following_id = '$profileUserID'";
        $conn->query($unfollowQuery);

        $checkBackQuery = "SELECT * FROM followers WHERE follower_id = '$profileUserID' AND following_id = '$userID'";
        $checkBackResult = $conn->query($checkBackQuery);

        if ($checkBackResult->num_rows == 0) {
            // They no longer follow each other, so remove from friends database
            $removeFriendQuery = "DELETE FROM friends WHERE (user_id = '$userID' AND friend_id = '$profileUserID') OR (user_id = '$profileUserID' AND friend_id = '$userID')";
            $conn->query($removeFriendQuery);
        }
    }
}

// Check if the current user and the profile user are friends
$checkFriendsQuery = "SELECT * FROM friends WHERE (user_id = '$userID' AND friend_id = '$profileUserID') OR (user_id = '$profileUserID' AND friend_id = '$userID')";
$checkFriendsResult = $conn->query($checkFriendsQuery);

$friendsListQuery = "SELECT users.name, users.surname 
                         FROM users
                         INNER JOIN friends ON (friends.user_id = users.user_id OR friends.friend_id = users.user_id)
                         WHERE (friends.user_id = '$profileUserID' OR friends.friend_id = '$profileUserID')";
// AND users.user_id != '$profileUserID'"; // Exclude the user's own entry

$friendsListResult = $conn->query($friendsListQuery);

$query = "SELECT * FROM users WHERE user_id = '$profileUserID'";
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
    <link rel="stylesheet" href="style/profile.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="fetchProfileArticles.js"></script>
    <title>Profile</title>
</head>

<body>
    <section class="row">
        <div id="profile" class="row col-10 mt-3 offset-1">
            <div id="headings" class="card col-4 mt-4 mb-4 p-3 offset-4">
                <h1>Profile page </h1>
                <hr />
                <img src="<?php echo $row['profile_image'] ? $row['profile_image'] : 'images/logo.png'; ?>" alt="Profile Image" id="profileImage">
                <hr />
                <p>Name: <?php echo $row['name'] ?></p>
                <p>Surname: <?php echo $row['surname']  ?></p>
                <p>Birthday: <?php echo $row['birthday'] ?></p>
                <?php
                if ($profileUserID == $userID)
                    echo "<p>Email:" .  $row['email']  . "</p>
                <div id='catList'>
                    <a href='category.php'>Create Category </a> | <a href='#'> Saved Category </a>
                </div>
                <div>
                    <a href='EditProfile.php'><button class='btn btn-dark'>Edit</button></a>
                    <a href='home.php'><button><svg height='16' width='16' xmlns='http://www.w3.org/2000/svg' version='1.1' viewBox='0 0 1024 1024'>
                                <path d='M874.690416 495.52477c0 11.2973-9.168824 20.466124-20.466124 20.466124l-604.773963 0 188.083679 188.083679c7.992021 7.992021 7.992021 20.947078 0 28.939099-4.001127 3.990894-9.240455 5.996574-14.46955 5.996574-5.239328 0-10.478655-1.995447-14.479783-5.996574l-223.00912-223.00912c-3.837398-3.837398-5.996574-9.046027-5.996574-14.46955 0-5.433756 2.159176-10.632151 5.996574-14.46955l223.019353-223.029586c7.992021-7.992021 20.957311-7.992021 28.949332 0 7.992021 8.002254 7.992021 20.957311 0 28.949332l-188.073446 188.073446 604.753497 0C865.521592 475.058646 874.690416 484.217237 874.690416 495.52477z'></path>
                            </svg><span>Back</span></button>
                    </a>
                </div>"
                ?><!-- Display friends list if they are friends -->
                <?php if ($checkFriendsResult->num_rows > 0) : ?>
                    <p>Friends:</p>
                    <!-- Fetch and display the friends list -->
                    <?php
                    while ($friend = mysqli_fetch_array($friendsListResult)) {
                        echo "<p>{$friend['name']} {$friend['surname']}</p>";
                    }

                    ?>
                <?php endif; ?>
                <!-- Display Follow/Unfollow button -->
                <?php if ($userID !== $profileUserID) : ?>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?user=' . $profileUserID; ?>">
                        <button type="submit" name="follow">
                            <?php
                            if ($checkResult->num_rows == 0) {
                                echo "Follow";
                            } else {
                                echo "Unfollow";
                            }
                            ?>
                        </button>
                    </form>
                <?php endif; ?>
            </div>
            <div class= "row col-6 mt-4 mb-4 p-3 offset-3">
                    <div id="articles">
                    <h2>Written Reviews and Read Articles</h2>
                    
                    </div>
            </div>
        </div>
    </section>
</body>
<script>
     var profileUserID = <?php echo $profileUserID; ?>;
</script>
</html>