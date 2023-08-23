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

//check is submit post button press or not
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //something was posted
    $fullname = ucwords($_POST['fullname']);
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // check if username and fullname is numerical
    if (!is_numeric($username) && !is_numeric($fullname)) {
        // check if username already exist
        $sql = "SELECT * FROM `users` WHERE `username` = '$username'";
        $checkSQL = mysqli_query($con, $sql);

        // check if username contain value
        if (mysqli_num_rows($checkSQL) != 0) {
            $_SESSION['message'] = 'Username already exists!';
        } else {

            //save to database
            $query = "INSERT INTO `users` (`role`, `fullname`, `address`,`contact`,`email`,`username`, `password`, `date`) 
                  VALUES ('admin','$fullname', '$address','$contact','$email', '$username', '$password', CURRENT_TIMESTAMP);";
            mysqli_query($con, $query);

            $_SESSION['message'] = 'Admin Added Sucessfully.';

            // redirect to login page
            header("Location: admin-account.php");
            die;
        }
    } else {
        $_SESSION['message'] = 'Please enter valid usrname or fullname!';
    }
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
    <link rel="stylesheet" href="css/login.css">
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
            <a class="navbar-brand" href="index.php">Bajracharya Tailoring</a>
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
                <section class="profile m-0">
                    <!-- Error Message -->
                    <?php
                    if (isset($_SESSION['message'])) {
                        echo $_SESSION['message'];
                        unset($_SESSION['message']);
                    }
                    ?>

                    <div class="signup">
                        <h2>
                            Add Admin
                        </h2>
                        <form action="add-admin.php" method="post">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="box">
                                        <label for="fullname">Full Name</label><br>
                                        <input type="text" name="fullname" id="fullname" required>
                                    </div>
                                    <div class="box">
                                        <label for="address">Address</label><br>
                                        <input type="text" name="address" id="address" required>
                                    </div>
                                    <div class="box">
                                        <label for="contact">Contact no.</label><br>
                                        <input type="number" name="contact" id="contact" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="box">
                                        <label for="email">Email</label><br>
                                        <input type="email" name="email" id="email" required>
                                    </div>
                                    <div class="box">
                                        <label for="username">Username</label><br>
                                        <input type="text" name="username" id="username" required>
                                    </div>
                                    <div class="box">
                                        <label for="password">Password</label><br>
                                        <input type="password" name="password" id="password" required>
                                    </div>
                                </div>
                            </div>
                            <button>Add</button>
                        </form>
                    </div>
                </section>
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