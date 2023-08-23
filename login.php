<?php
session_start();

include("connection.php");
include("functions.php");


//clear session 
if (isset($_SESSION['id'])) {
    header("Location: index.php");
}

//check is submit post button press or not
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (!empty($_POST['username']) && !empty($_POST['password'])) {

        //something was posted
        $username = $_POST['username'];
        $password = $_POST['password'];

        //read from database
        $query = "SELECT * FROM `users` WHERE `username` = '$username'";
        // $query = "select * from reg where user_name = '$user_name' limit 1";
        $result = mysqli_query($con, $query);
        if ($result) {
            // check if username contain value 
            if ($result && mysqli_num_rows($result) > 0) {
                // store values in associative array
                $user_data = mysqli_fetch_assoc($result);

                if ($user_data['password'] === $password) {

                    $_SESSION['id'] = $user_data['id'];

                    // redirect to login page
                    header("Location: index.php");
                    die;
                } else {
                    $_SESSION['message'] = 'Please enter valid password!';
                }
            } else {
                $_SESSION['message'] = 'Please enter valid username!';
            }
        }
    } else {
        $_SESSION['message'] = 'Please fill all input!';
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
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/login.css">

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

    <title>Bajracharya Tailoring</title>
</head>

<body>

    <!-- Navbar -->

    <?php include("parts/menu.php"); ?>

    <!-- End of Navber -->

    <!-- login form -->

    <section class="profile">
        <!-- Error Message -->
        <?php
        if (isset($_SESSION['message'])) {
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
        ?>

        <div class="login">
            <h2>
                Login
            </h2>
            <form action="login.php" method="post">
                <div class="box">
                    <label for="username">Username</label><br>
                    <input type="text" name="username" id="username">
                </div>
                <div class="box">
                    <label for="password">Password</label><br>
                    <input type="password" name="password" id="password">
                </div>
                <button>Login</button>
                <p>New Customers?<a href="signup.php">Signup</a></p>
            </form>
        </div>
    </section>

    <!-- end of login form -->

    <!-- footer -->

    <?php include("parts/footer.php"); ?>

    <!-- End of footer -->

</body>

</html>