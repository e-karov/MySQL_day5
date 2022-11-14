<?php
require_once "db_connect.php";
require_once "file_upload.php";

if ($_POST) {
    $id = $_POST['id'];
    $name = htmlspecialchars($_POST['name'], ENT_QUOTES);
    $price = htmlspecialchars($_POST['price'] . ENT_QUOTES);
    $ingredients = htmlspecialchars($_POST['ingredients'], ENT_QUOTES);

    $upload_error = "";
    $image = file_upload($_FILES['image']);

    if (!$image->error) {
        ($_POST['image'] == 'default_pic.jpg') ?: unlink("../pictures/$_POST[image]");
        $query = "
        UPDATE dish SET name = '$name', price = '$price', ingredients = '$ingredients', image = '$image->fileName'
                    WHERE id = {$id}
        ";
    } else {
        $query = "
        UPDATE dish SET name = '$name', price = '$price', ingredients = '$ingredients' WHERE id = {$id}
        ";
    }

    if (mysqli_query($connection, $query) === true) {
        $class = "success";
        $message = "The record was successfully updated";
        $uploadError = ($image->error != 0) ? $image->ErrorMessage : '';
    } else {
        $class = "danger";
        $message = "Error while updating record : <br>" . mysqli_connect_error();
        $uploadError = ($image->error != 0) ? $image->ErrorMessage : '';
    }
} else {
    header("location: ../error.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Update</title>
    <?php require_once '../components/boot.php' ?>
</head>

<body>
    <div class="container">
        <div class="mt-3 mb-3">
            <h1>Update request response</h1>
        </div>
        <div class="alert alert-<?php echo $class; ?>" role="alert">
            <p><?php echo ($message) ?? ''; ?></p>
            <p><?php echo ($uploadError) ?? ''; ?></p>
            <a href='../update.php?id=<?= $id; ?>'><button class="btn btn-warning" type='button'>Back</button></a>
            <a href='../index.php'><button class="btn btn-success" type='button'>Home</button></a>
        </div>
    </div>
</body>

</html>