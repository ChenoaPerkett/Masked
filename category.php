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
    <title>Home</title>
</head>

<body class="row ">
    <div class="row mb-3" id="nav">
        <div id="logo" class="col-2 mt-2 offset-1">
            <img src="images/logo.png" alt="Logo" class="logo">
        </div>
        <h1 class="col-3 mt-3 offset-2">UNMASKED</h1>
        <div id=" links" class="col-2 mt-3 offset-2">
            <a href="profile.php">Profile</a>
            <a href="#"><button class="btn btn">LogOut</button></a>
        </div>
    </div>

    <div id="feed" class="col-10 offset-1">
        <div class="nav feed mt-3 offset-5">
            <div class="links">
                <h1>Catorgories</h1>
            </div>
        </div>
        <div id="archives" class="col-10 offset-1">
            <div class="theArchive">
                <?php {
                    echo     "<form action='create-category.php' method='POST' enctype='multipart/form-data'>
                            <div class='row p-2 card-header'>Create Category<hr/>

                                <div class='col-sm-12'>
                                <label for='categoryName'>Category Name:</label><br>
                                <input type='text' class='form-control' name='categoryName' id='categoryName' required /><br>
                            </div>
                            <div class='col-sm-12'>
                            <label for='categoryDescription'>Category Description:</label><br>
                            <textarea class='form-control' name='categoryDescription' id='categoryDescription' required></textarea><br>
                        </div>
                                <div class='form-group'>

                                <label>Select Articles:</label><br>
                                ";
                }
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
                // Fetch articles from the database
                $articleQuery = "SELECT * FROM articles";
                $articleResult = $conn->query($articleQuery);

                if ($articleResult->num_rows > 0) {
                    while ($articleRow = $articleResult->fetch_assoc()) {
                        $articleId = $articleRow['article_id'];
                        $articleName = $articleRow['title'];
                        echo "<input type='checkbox' name='articleIds[]' value='$articleId'> $articleName<br>";
                    }
                } else {
                    echo "No articles found.";
                } {
                    echo "

                                <button class='btn btn-dark'>+</button>
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

</html>