<?php
session_start();
require_once "../actions/db_connect.php";

if (!isset($_SESSION['user']) && !isset($_SESSION['adm'])) {
    header("location: index.php");
    exit;
}

if (isset($_SESSION['adm'])) {
    header("location: dashboard.php");
    exit;
}

$result = mysqli_query($connection, "SELECT * FROM users WHERE id =" . $_SESSION['user']);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

mysqli_close($connection);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - <?php echo $row['first_name']; ?></title>
    <?php require_once '../components/boot.php' ?>
    <style>
        .userImage {
            width: 200px;
            height: 200px;
        }

        .hero {
            background: rgb(2, 0, 36);
            background: linear-gradient(24deg, rgba(2, 0, 36, 1) 0%, rgba(0, 212, 255, 1) 100%);
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="hero">
            <img class="userImage" src="pictures/<?php echo $row['picture']; ?>" alt="<?php echo $row['first_name']; ?>">
            <p class="text-white" style="margin-right: 100px; display:inline-block">Hi <?php echo $row['first_name']; ?></p>
            <a href="../main-page.php" style="display: inline-block;margin-right:30px; color:yellow;">Main Page</a>
            <a href="update.php?id=<?= $_SESSION['user'] ?>" style="display: inline-block;margin-right:30px; color:yellow;">Update your profile</a>
            <a href="logout.php" style="display: inline-block;margin-right:30px; color:yellow;">Sign Out</a>

        </div>
    </div>

</body>

</html>