<?php
session_start();

include("connection.php");
include("functions.php");

//check if user if login or not
$user_data = check_login($con);

//if non admin open this page it will redirect to home page.
if ($user_data['role'] == "user") {
    header('Location: user.php');
}
?>


<!doctype html>
<html lang="en">

<head>
    <!-- meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <!-- Fontawesome css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- css -->
    <link rel="stylesheet" href="css/admin.css">

    <!-- favicon -->
    <link rel="shortcut icon" href="icon/favicon.ico" type="image/x-icon">

    <!-- Bootstrap Js-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>

    <!-- Popper.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>

    <!-- Fontawesome js -->
    <script src="https://kit.fontawesome.com/caa7c84843.js" crossorigin="anonymous"></script>

    <title>Admin Dashboard</title>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php"><strong>Bajracharya Tailoring</strong></a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </nav>

    <div class="sbody">
        <!-- The sidebar -->
        <div class="sidebar">
            <div class="links">
                <a href="admin.php"><i class="fas fa-home"></i> Dashboard</a>
                <a class="active" href="admin-account.php"><i class="fas fa-user-circle"></i> Account</a>
                <a href="admin-appointment.php"><i class="fas fa-calendar-check"></i> Appointment</a>
                <a href="admin-shop.php"><i class="fas fa-shopping-bag"></i> Shop</a>
                <a href="admin-upload.php"><i class="fas fa-cloud-upload-alt"></i> Upload</a>
                <a href="admin-contact.php"><i class="far fa-address-book"></i> Contact</a>
            </div>
        </div>

        <!-- Page content -->
        <div class="content">
            <div class="box">
            <div class="text-center">
                    <h1><strong>Account</strong></h1>
                </div>
                <?php
                if (isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                    echo "<br><br>";
                }
                ?>
                <a class="btn btn-danger mb-2" href="add-admin.php">Add Admin</a>
                <table>
                    <tr>
                        <th>SN</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Address</th>
                        <th></th>
                    </tr>
                    <?php
                    $result = mysqli_query($con, "SELECT * FROM users ORDER BY role");
                    $sn = 1;
                    while ($row = mysqli_fetch_array($result)) {
                        //these are the fields that you have stored in your database table contact
                    ?>
                        <tr>
                            <td> <?php echo $sn++; ?></td>
                            <td> <?php echo $row['username']; ?></td>
                            <td> <?php echo $row['role']; ?></td>
                            <td> <?php echo $row['address']; ?></td>
                            <td>
                                <!-- update -->
                                <a class="px-2" href="update.php?id=<?php echo $row["id"]; ?>" title="Tooltip on bottom"><i class="fas fa-edit"></i></a>
                                <!-- passing multiple form link and delete it -->
                                <a class="px-2" href="delete.php?id=<?php echo $row['id'] ?>&location=admin-account.php" onclick="return confirm('Are you sure want to delete?')"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>

                    <?php
                    }

                    // $link = $_SERVER['PHP_SELF'];
                    // echo $link;

                    mysqli_close($con);
                    ?>
                </table>
            </div>
        </div>
    </div>







    <!-- Fontawesome -->
    <script src="https://kit.fontawesome.com/caa7c84843.js" crossorigin="anonymous"></script>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>

</body>

</html>