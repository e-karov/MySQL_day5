<?php
session_start();
require_once "actions/db_connect.php";

$sql = "SELECT * FROM dish";
$data = mysqli_query($connection, $sql);
$tbody = "";

if (mysqli_num_rows($data) > 0) {
    while ($row = mysqli_fetch_assoc($data)) {
        $tbody .= "
        <tr>
            <td><img class='img-thumbnail' src='pictures/" . $row['image'] . "'</td>
            <td>" . $row['name'] . "</td>
            <td>" . $row['price'] . "</td>
            <td> <a href='details.php?id=" . $row['id'] . "'>
                    <button class='btn btn-info btn-sm' type='button'>Details</button>
                </a> 
            </td> 
        </tr>
        ";
    }
} else {
    $tbody = "<tr><td colspan='4' class='text-center'>No data available</td></tr>";
}

if (isset($_SESSION['user'])) {
    $nav = "
        <div class='container'>
        <div class='hero'>
        <a href='main-page.php' style='display: inline-block;margin-right:30px; color:yellow;'>Main Page</a>
        <a href='login/update.php?id=$_SESSION[user]' style='display: inline-block;margin-right:30px; color:yellow;'>Update your profile</a>
        <a href='login/logout.php?logout' style='display: inline-block;float: right; color:yellow;'>Sign Out</a>
        </div>
        </div>
    ";
} elseif (isset($_SESSION['adm'])) {
    $nav = "
        <div class='container'>
        <div class='hero'>
        <a href='login/dashboard.php' style='display: inline-block;margin-right:30px; color:yellow;'>Dashboard</a>
        <a href='create.php' style='display: inline-block;margin-right:30px; color:yellow;'>Add Product</a>
        <a href='login/update.php?id=$_SESSION[adm]' style='display: inline-block;margin-right:30px; color:yellow;'>Update your profile</a>
        <a href='login/logout.php?logout' style='display: inline-block;float:right; color:yellow;'>Sign Out</a>
        </div>
        </div>
    ";
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

        .userImage {
            width: 200px;
            height: 200px;
        }

        .hero {
            background: rgb(2, 0, 36);
            background: linear-gradient(24deg, rgba(2, 0, 36, 1) 0%, rgba(0, 212, 255, 1) 100%);
        }
    </style>
    <title>Restaurant</title>
</head>

<body>
    <div class="manageProduct w-75 mt-3">
        <div class='mb-3'>
            <?= $nav; ?>
        </div>
        <p class='h2'>Dishes</p>
        <table class='table table-striped'>
            <thead class='table-success'>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                <?php echo $tbody; ?>
            </tbody>
        </table>
    </div>
</body>

</html>