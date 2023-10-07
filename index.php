<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="author" content="Chenoa Perkett" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=REM:wght@400;700&family=Roboto+Slab&display=swap" rel="stylesheet">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style/style.css" />

    <title>Project</title>
</head>

<body>
    <section class="row">
        <div id="headings" class="card col-4 mt-5 offset-1">
            <img src="images/logo.png" alt="Logo" class="logo">
            <h2>THEORIES</h2>
            <h1>UNMASKED</h1>
            <p> Conspiracy theories ,critically examine and explore their origins, evidence, and
                cultural impact</p>
        </div>
        <div id="forms" class="card col-4 mt-5 offset-2">
            <div id="login-form" class="active">
                <form action="validate-login.php" method="post">
                    <div class="row card-header">
                        <li class="col-lg-6"><a href="#" id="activeL">Log in</a></li> |<li class="col-lg-5"><a href="#" id="register-link">Register</a></li>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12">
                                <label for="email" class="form-label">Email address:</label>
                                <input type="email" class="form-control" name="loginEmail" id="loginEmail" placeholder="name@gmail.com" />
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <label class="form-label" for="pass">Password:</label>
                                <input class="form-control" type="password" name="loginPass" id="loginPass" placeholder="********" />
                            </div>

                        </div>
                        </br>
                        <button class=" btn btn-dark">Log in</button>
                    </div>
                </form>
            </div>

            <div class="card col-sm-10 mx-sm-2" id="register-form" style="display: none;">
                <form action="index.php" method="post">
                    <div class="row card-header">
                        <li class="col-lg-6"><a href="#" id="login-link">Log in</a></li> |<li class="col-lg-5"><a href="#" id="activeR">Register</a></li>
                    </div>
                    <div class="card-body">
                        <div class="row" id="form-Inputs">
                            <div class="col-lg-6 col-sm-12">
                                <label for="fname" class="form-label">First name:</label>
                                <input type="text" class="form-control" name="fname" id="fname" placeholder="John" />
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <label for="lname" class="form-label">Last name:</label>
                                <input type="text" class="form-control" name="lname" id="lname" placeholder="Doe" />
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <label for="email1" class="form-label">Email address:</label>
                                <input type="email" class="form-control" name="email1" id="email1" placeholder="john.doe@gmail.com" />
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <label for="date" class="form-label">Date of birth:</label>
                                <input type="date" class="form-control" name="date" id="date" />
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <label for="pass1" class="form-label">Create password:</label>
                                <input type="password" class="form-control" name="pass1" id="pass1" placeholder="********" />
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <label for="pass1" class="form-label">Confirm password:</label>
                                <input type="password" class="form-control" name="pass2" id="pass2" placeholder="********" />
                            </div>

                        </div>
                        </br>
                        <button class="btn btn-dark">Register</button>
                    </div>

                </form>
            </div>
        </div>
    </section>
    <?php
    $servername = "localhost";
    // $username = "u19109572";
    $username = "root";
    $dbpassword = "";
    // $dbpassword = "umambwmh";
    $dbname = "u19109572";

    $name = $_POST["fname"];
    $surname = $_POST["lname"];
    $email = $_POST["email1"];
    $date = $_POST["date"];
    $password = $_POST["pass1"];

    $conn = new mysqli($servername, $username, $dbpassword, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT email FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo 'unavailable';
    } else {
        addUser($name, $surname, $email, $password, $date, $conn);
    }

    $conn->close();
    function addUser($name, $surname, $email, $password, $date, $conn)
    {
        $stmt = $conn->prepare("INSERT INTO users (name, surname, email, password, birthday) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $surname, $email, $password, $date);
        if ($stmt->execute()) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
    ?>
    <script>
        const loginLink = document.getElementById('login-link');
        const registerLink = document.getElementById('register-link');
        const loginForm = document.getElementById('login-form');
        const registerForm = document.getElementById('register-form');

        loginLink.addEventListener('click', function(event) {
            event.preventDefault();
            loginForm.style.display = 'block';
            registerForm.style.display = 'none';
            loginForm.classList.add('active');
            registerForm.classList.remove('active');
        });

        registerLink.addEventListener('click', function(event) {
            event.preventDefault();
            loginForm.style.display = 'none';
            registerForm.style.display = 'block';
            loginForm.classList.remove('active');
            registerForm.classList.add('active');
        });
    </script>
</body>

</html>