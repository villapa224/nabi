<?php
    session_start();
    if (isset($_SESSION["user"])) {
        header("Location: home.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="assets/css/login.css" rel="stylesheet">
</head>
<body>
    <div class="container">
    <?php 
        if (isset($_POST["Login"])){
            $email = $_POST["email"];
            $password = $_POST["password"];
                require_once "database.php";
                $sql = "SELECT * FROM re WHERE email = '$email'";
                $result = mysqli_query($conn, $sql);
                $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
                if ($user) {
                    $hashedPassword = $user["Password"];
                    if (password_verify($password, $hashedPassword)) {
                        $_SESSION["user"] = "yes";
                        header("Location: home.php");
                        die();
                    } else {
                        echo "<div class = 'alert alert-danger'> Password does not match </div>";
                    }
                } else {
                    echo "<div class = 'alert alert-danger'> Email does not match </div>";
                }
            }
    ?>
    <div class="container">
        <form action="home.php" method="post">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" class="form-control" placeholder="Enter Email"required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" class="form-control" placeholder="Enter Password" required>
            </div>

            <div class="form-btn">
                <input type="submit" value="Login" name="login" class="btn btn-primary">        
            </div>
        </form>
        <div><p>Not Registered yet? <a href="registration.php"> Register Here</a></div>
    </div>
</body>
</html>