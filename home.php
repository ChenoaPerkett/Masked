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
if (isset($_POST["submitArticle"])) {
    $articleName = $_POST["articleName"];
    $articleAuthor = $_POST["articleAuthor"];
    $articleDescription = $_POST["articleDescription"];

    // Process file upload
    $targetDir = "uploads/"; // Directory to store uploaded images
    $targetFile = $targetDir . basename($_FILES["articleImage"]["name"]);

    if (move_uploaded_file($_FILES["articleImage"]["tmp_name"], $targetFile)) {
        // File uploaded successfully
       // $userID = $userID; // Assuming you have the user's ID already

        $sql = "INSERT INTO articles (user_id, title, description, author, date, image) 
                    VALUES ('$userID', '$articleName', '$articleDescription', '$articleAuthor', NOW(), '$targetFile')";

        if ($conn->query($sql) === TRUE) {
            //echo "Article added successfully";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Error uploading image";
    }
}



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
    <script src="homeScript.js"></script>
    <script src="fetchArticles.js"></script>
    <title>Home</title>
</head>

<body class="row ">
    <div class="row mb-3" id="nav">
        <div id="logo" class="col-2 mt-2 offset-1">
            <img src="images/logo.png" alt="Logo" class="logo">
        </div>
        <h1 class="col-3 mt-3 offset-2">UNMASKED</h1>
        <div id=" links" class="col-2 mt-3 offset-2">
            <a href=<?php echo "'profile.php?user=" .$userID. "'" ?>>Profile</a>
            <a href="#"><button class="btn btn">LogOut</button></a>
        </div>
    </div>

    <div id="feed" class="col-10 offset-1">
        <div class="nav feed mt-3 offset-5">
            <div class="links">
    <a href="javascript:void(0);" id="localLink" onclick="toggleArticles('local')">Local</a> |
    <a href="javascript:void(0);" id="globalLink" onclick="toggleArticles('global')">Global</a>
                <!-- <a href="#">Local </a>|
                <a href="#"> Global</a> -->
            </div>
        </div>
        <div id="archives" class="col-10 offset-1">
            <div class="theArchive">
                <?php {
                    echo     "<form action='home.php' method='POST' enctype='multipart/form-data'>
                            <div class='row p-2 card-header'>
                                <div class='col-lg-6 col-sm-12'>
                                    <label for='articleName'>Article Name:</label><br>
                                    <input type='text' class='form-control' name='articleName' /><br>	
                                </div>

                                <div class='col-lg-6 col-sm-12'>
                                    <label for='articleAuthor'>Article Author:</label><br>							
                                    <input type='text' class='form-control' name='articleAuthor' /><br>
                                </div>
                                <div class='form-group'>

                                <label for='articleDescription'>Article Description:</label><br>
								<input type='text' class='form-control' name='articleDescription' /><br>

								<label for='articleImage'>Upload Image:</label><br>
                                 <input type='file' class='form-control' name='articleImage' id='articleImage' accept='image/*' required /><br>
            

								<button class='btn btn-dark' name='submitArticle'>Post</button>
                                </div>
							</div>
					  	</form>";
                }

                ?>
            </div>
            <div id="articles">
            </div>
        </div>

</body>
<script>
     var UserID = <?php echo $userID; ?>;
</script>
</html>