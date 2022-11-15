<?php
session_start();
require_once "actions/db_connect.php";

if (isset($_SESSION['user'])) {
    header("location: login/home.php");
    exit;
} elseif (isset($_SESSION['adm'])) {
    header("location: login/dashboard.php");
}

$error = false;
$email = $password = $emailError = $passError = "";

if (isset($_POST['btn-login'])) {
    $email = trim($_POST['email']);
    $email = strip_tags($email);
    $email = htmlspecialchars($email);

    $pass = trim($_POST['pass']);
    $pass = strip_tags($pass);
    $pass = htmlspecialchars($pass);

    if (empty($email)) {
        $error = true;
        $emailError = "Please enter your email address.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $emailError = "Please enter valid email address.";
    }

    if (empty($pass)) {
        $error = true;
        $passError = "Please enter your password.";
    }

    if (!$error) {
        $password = hash('sha256', $pass);

        $query = "SELECT id, first_name, password, status FROM users WHERE email = '$email'";

        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_assoc($result);

        if (mysqli_num_rows($result) == 1 && $row['password'] == $password) {
            $_SESSION['username'] = $row['first_name'];
            if ($row['status'] == "adm") {
                $_SESSION['adm'] = $row['id'];
                header("location:login/dashboard.php");
            } elseif ($row['status'] == "user") {
                $_SESSION['user'] = $row['id'];
                header("location: login/home.php");
            }
        } else {

            $errMsg = "Incorect Credentials, please try again...";
        }
    }
}
mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Registration System</title>
    <?php require_once 'components/boot.php' ?>
</head>

<body>
    <div class="container">
        <form class="w-75" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
            <h2>Login</h2>
            <hr />
            <?php
            if (isset($errMsg)) {
                echo $errMsg;
            }
            ?>

            <input type="email" name="email" class="form-control" placeholder="Your Email" value="<?php echo $email; ?>" maxlength="40" />
            <span class="text-danger"><?php echo $emailError; ?></span>

            <input type="password" name="pass" class="form-control" placeholder="Your Password" maxlength="15" />
            <span class="text-danger"><?php echo $passError; ?></span>
            <hr />
            <button class="btn btn-block btn-primary" type="submit" name="btn-login">Log In</button>
            <hr />
            <a href="login/register.php">Not registered yet? Click here</a>
        </form>
    </div>
</body>

</html>