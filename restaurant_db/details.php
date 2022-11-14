<?php
require_once "actions/db_connect.php";

if ($_GET['id']) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM dishes WHERE id = '$id'";
    $result = mysqli_query($connection, $sql);
    $tbody = "";
    if (mysqli_num_rows($result) == 1) {
        $data = mysqli_fetch_assoc($result);
        $name = $data['name'];
        $image = $data['image'];
        $price = $data['price'];
        $description = $data['description'];
        $tbody = "
            <tr>
            <td><img class='img-thumbnail' src='pictures/$image'</td>
            <td>$name</td>
            <td>$price</td>
            <td>$description</td> 
            <td><a href='update.php?id=$id'><button class='btn btn-primary btn-sm' type='button'>Edit</button></a>
            <a href='delete.php?id=$id'><button class='btn btn-danger btn-sm' type='button'>Delete</button></a>
            </td>
            </tr>
        ";
    } else {
        header("location: error.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once "components/boot.php"; ?>
    <style type="text/css">
        .manageProduct {
            margin: auto;
        }

        .img-thumbnail {
            width: 70px !important;
            height: 70px !important;
        }

        td {
            text-align: left;
            vertical-align: middle;
        }

        tr {
            text-align: center;
        }
    </style>
    <title>Restaurant</title>
</head>

<body>
    <div class="manageProduct w-75 mt-3">
        <div class='mb-3'>
            <a href='index.php'><button class='btn btn-secondary btn-sm' type='button'>Back</button></a>
            <a href="create.php"><button class='btn btn-primary' type="button">Add product</button></a>
        </div>
        <p class='h2'>Dishes</p>
        <table class='table table-striped'>
            <thead class='table-success'>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php echo $tbody; ?>
            </tbody>
        </table>
    </div>
</body>

</html>