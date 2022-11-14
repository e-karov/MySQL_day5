<?php
require_once "db_connect.php";
require_once "file_upload.php";

if ($_POST) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $upload_error = "";
    $image = file_upload($_FILES['image']);

    $sql = "INSERT INTO dishes (name, price, image, description)
                VALUES ('$name', '$price', '$image->fileName', '$description')";
    if (mysqli_query($connection, $sql) === true) {
        $class = "succsess";
        $message = "
            The entry below was successfully created <br>
            <table class = 'table w-50'>
            <tr>
                <td> $name </td>
                <td> $price </td>
            </tr>
            </table>
            <hr> 
            ";
        $upload_error = ($image->error != true) ? $image->ErrorMessage : "";
    } else {
        $class = "danger";
        $message = "Error while creating record. Try again: <br> {$connection->error}";
        $upload_error = ($image->error != 0) ? $image->ErrorMessage : "";

        mysqli_close($connection);
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
            <h1>Create request response</h1>
        </div>
        <div class="alert alert-<?= $class; ?>" role="alert">
            <p><?php echo ($message) ?? ''; ?></p>
            <p><?php echo ($uploadError) ?? ''; ?></p>
            <a href='../index.php'><button class="btn btn-primary" type='button'>Home</button></a>
        </div>
    </div>
</body>

</html>