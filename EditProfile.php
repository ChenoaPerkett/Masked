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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $surname = $_POST["surname"];
    $birthday = $_POST["birthday"];
    $email = $_POST["email"];

    $query = "UPDATE users SET name='$name', surname='$surname', birthday='$birthday', email='$email' WHERE user_id='$userID'";
    if ($conn->query($query) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
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
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        Name: <input type="text" name="name" value="<?php echo $row['name'] ?>"><br>
        Surname: <input type="text" name="surname" value="<?php echo $row['surname'] ?>"><br>
        Birthday: <input type="date" name="birthday" value="<?php echo $row['birthday'] ?>"><br>
        Email: <input type="email" name="email" value="<?php echo $row['email'] ?>"><br>
        <input type="submit">
    </form>
</body>

</html>