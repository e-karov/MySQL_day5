<?php
session_start();

if (isset($_SESSION['user'])) {
    header("location: home.php");
} else if (isset($_SESSION['adm'])) {
    header("location: dahboard.php");
}

require_once "../actions/db_connect.php";
require_once "../actions/file_upload.php";

$error = false;
$first_name = $last_name = $email = $birthdate = $pass = $picture = "";
$fname_error = $lname_error = $email_error = $date_error = $pass_error = $pic_error = "";

if (isset($_POST['btn-signup'])) {
    $first_name = trim($_POST['fname']);
    $first_name = strip_tags($first_name);
    $first_name = htmlspecialchars($first_name);

    $last_name = trim($_POST['lname']);
    $last_name = strip_tags($last_name);
    $last_name = htmlspecialchars($last_name);

    $email = trim($_POST['email']);
    $email = strip_tags($email);
    $email = htmlspecialchars($email);

    $birthdate = trim($_POST['date']);
    $birthdate = strip_tags($birthdate);
    $birthdate = htmlspecialchars($birthdate);

    $pass = trim($_POST['pass']);
    $pass = strip_tags($pass);
    $pass = htmlspecialchars($pass);

    $uploadError = "";
    $picture = file_upload($_FILES['picture']);

    if (empty($first_name || empty($last_name))) {
        $error = true;
        $fname_error = "Please enter your full name and surname.";
    } else if (strlen($first_name < 3 || strlen($last_name < 3))) {
        $error = true;
        $fname_error = "Name and Surname must have at least 3 characters.";
    } else if (!preg_match("/^[a-zA-Z]+$/", $first_name) || !preg_match("/^[a-zA-Z]+$/", $last_name)) {
        $error = true;
        $fname_error = "Name and Surname can contain only letters and no spaces.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $email_error = "Please enter a valid email address.";
    } else {
        $query = "SELECT email FROM users WHERE email = '$email'";
        $result = mysqli_query($connection, $query);
        if (mysqli_num_rows($result) > 0) {
            $error = true;
            $email_error = "This email is already in use.";
        }
    }

    if (empty($birthdate)) {
        $error = true;
        $date_error = "Please enter your date of birth.";
    }

    if (empty($pass)) {
        $error = true;
        $pass_error = "Please enter a password.";
    } else if (strlen($pass < 6)) {
        $error = true;
        $pass_error = "Password must have at least 6 characters.";
    }

    $hashedPass = hash('sha256', $pass);

    if (!$error) {
        $query = "
                INSERT INTO users(first_name, last_name, password, birthdate, email, picture)
                VALUES ('$first_name', '$last_name', '$hashedPass', '$birthdate', '$email', '$picture->fileName')
            ";

        $result = mysqli_query($connection, $query);

        if ($result) {
            $class = "success";
            $errMSG = "Successfully registered! You may login now.";
        } else {
            $class = "danger";
            $errMSG = "Something went wrong. Plese try again...";
            $uploadError = ($picture->error != 0) ? $picture->ErrorMessage : "";
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
    <?php require_once "../components/boot.php" ?>
</head>

<body>
    <div class="container">
        <form class="w-75" method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off" enctype="multipart/form-data">
            <h2>Sign Up.</h2>
            <hr />
            <?php
            if (isset($errMSG)) {
            ?>
                <div class="alert alert-<?php echo $class ?>">
                    <p><?php echo $errMSG; ?></p>
                    <p><?php echo $uploadError; ?></p>
                </div>

            <?php
            }
            ?>

            <input type="text" name="fname" class="form-control" placeholder="First name" maxlength="50" value="<?php echo $first_name ?>" />
            <span class="text-danger"> <?php echo $fname_error; ?> </span>

            <input type="text" name="lname" class="form-control" placeholder="Surname" maxlength="50" value="<?php echo $last_name ?>" />
            <span class="text-danger"> <?php echo $lname_error; ?> </span>

            <input type="email" name="email" class="form-control" placeholder="Enter Your Email" maxlength="40" value="<?php echo $email ?>" />
            <span class="text-danger"> <?php echo $email_error; ?> </span>
            <div class="d-flex">
                <input class='form-control w-50' type="date" name="date" value="<?php echo $birthdate ?>" />
                <span class="text-danger"> <?php echo $date_error; ?> </span><br>

                <input class='form-control w-50' type="file" name="picture" placeholder="Picture" />
                <span class="text-danger"> <?php echo $pic_error; ?> </span>
            </div>
            <input type="password" name="pass" class="form-control" placeholder="Enter Password" maxlength="15" />
            <span class="text-danger"> <?php echo $pass_error; ?> </span>
            <hr />
            <button type="submit" class="btn btn-block btn-primary" name="btn-signup">Sign Up</button>
            <hr />
            <a href="../index.php">Sign in Here...</a>
        </form>
    </div>
</body>

</html>