<?php
require_once "db_connect.php";

if ($_POST) {
    $id = $_POST["dishId"];
    $picture = $_POST["picture"];
    ($picture == "default-image.png") ?: unlink("../pictures/$picture");

    $sql = "DELETE FROM dishes WHERE dishId = {$id}";

    if (mysqli_query($connection, $sql) === TRUE) {
        $class = "success";
        $message = "Successfuly deleted!";
    } else {
        $class = "danger";
        $message = "The entry was not deleted due to: <br>" . $connection->error;
    }
    mysqli_close($connection);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Delete</title>
    <?php require_once "../components/boot.php" ?>
</head>

<body>
    <div class="container">
        <div class="mt-3 mb-3">
            <h1>Delete request response</h1>
        </div>
        <div class="alert alert-<?= $class; ?>" role="alert"></div>
        <p><?= $message; ?></p>
        <a href="../index.php"><button class="btn btn-success" type="button">Home</button></a>
    </div>
</body>

</html>