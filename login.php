<?php
    session_start();
    require_once "db.php";

    //Getting variables with POST method
    if (isset($_POST["submit"])) {
        $email = $_POST["inputEmail"];
        $password = $_POST["inputPassword"];

        if (checkUser($email, $password)) {//This function is in db.php, 
            $_SESSION["user"] = getUser($email);//Getting user from the database with the email
            
            if ($_SESSION["user"]["userType"] == "customer") {
                header("Location: customerHome.php");//Customer, redirect to customerHome.php
            } else {
                header("Location: market.php");//Market user, redirect to market.php
            }
        } else {
            echo "<p>Wrong email or password</p>";//User varification failed
        }
    }

    //If the user already logged in, redirect to the home page
    if (isset($_SESSION["user"])) {
        $_SESSION["user"] = getUser($email);
        if ($_SESSION["user"]["userType"] == "customer") {
            header("Location: customerHome.php");
        } else {
            header("Location: market.php");
        }
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
    <form method="POST" class="col-3 mx-auto mt-4 p-3 rounded border border-success shadow">
        <div class="mb-3">
            <label for="inputEmail" class="form-label">E-mail Address</label>
            <input type="email" class="form-control" id="inputEmail" name="inputEmail" value="<?= isset($inputEmail) ? filter_var($inputEmail, FILTER_SANITIZE_FULL_SPECIAL_CHARS) : "" ?>" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text">We will not share your email with anyone. Trust us.</div>
        </div>
        <div class="mb-3">
            <label for="inputPassword" class="form-label">Password</label>
            <input type="password" class="form-control" id="inputPassword" name="inputPassword">
        </div> 

        <button type="submit" name="submit" class="col-12 btn btn-primary mb-1">Sign in</button>
        <div class="text-center">
            <a href="register.php" class="text-decoration-none">Don't have an account yet?</a>
        </div>
    </form>
</body>
</html>