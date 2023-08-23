<?php
session_start();

//clear session 
if (isset($_SESSION['id'])) {
    header("Location: index.php");
}

include("connection.php");
include("functions.php");

//check is submit post button press or not
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    // check if all the input is empty or not
    if (!empty($_POST['fullname']) && !empty($_POST['contact']) && !empty($_POST['address']) && !empty($_POST['email']) && !empty($_POST['username']) && !empty($_POST['password'])) {

        //something was posted
        $fullname = ucwords($_POST['fullname']);
        $address = $_POST['address'];

        // contact
        $contact = $_POST['contact'];
        // count total digit
        $contactlen = strlen($contact);
        // store first 2 digit of contact
        $contact98 = $contact[0] . $contact[1];
        $contact01 = $contact[0] . "a" . $contact[1];

        $email = $_POST['email'];

        // username
        $username = $_POST['username'];
        $a = strlen($username);

        $password = $_POST['password'];

        // check if fullname is numerical or not and fullname is alphabet or not
        if (!is_numeric($fullname) && preg_match("/^[a-zA-z]*$/", $fullname)) {

            // check if username is numerical or not and username is alphabet or not and string length must be greater equal to 3
            if (preg_match("/^[a-zA-z]*$/", $username) && !is_numeric($username) && $a >= 3) {

                // check if contact is 9digit and start from 01 or contact is 10digit and start from 98
                if (($contact01 == "0a1" && $contactlen == 9) || ($contact98 == 98 && $contactlen == 10)) {

                    // check if username already exist
                    $sql = "SELECT * FROM `users` WHERE `username` = '$username'";
                    $checkSQL = mysqli_query($con, $sql);

                    // check if username contain value
                    if (mysqli_num_rows($checkSQL) != 0) {
                        $_SESSION['message'] = 'Username already exists!';
                    } else {

                        //save to database
                        $query = "INSERT INTO `users` (`role`,`fullname`, `address`,`contact`,`email`,`username`, `password`, `date`) 
					  VALUES ('user','$fullname', '$address','$contact','$email', '$username', '$password', CURRENT_TIMESTAMP);";
                        mysqli_query($con, $query);

                        // redirect to login page
                        header("Location: login.php");
                        die;
                    }
                } else {
                    $_SESSION['message'] = 'Please enter valid contact number!';
                }
            } else {
                $_SESSION['message'] = 'Please enter valid username!';
            }
        } else {
            $_SESSION['message'] = 'Please enter valid fullname!';
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
        <div class="container">

            <!-- Error Message -->
            <?php
            if (isset($_SESSION['message'])) {
                echo $_SESSION['message'];
                unset($_SESSION['message']);
            }
            ?>

            <div class="signup">
                <h2>
                    Signup
                </h2>
                <form action="signup.php" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="box">
                                <label for="fullname">Full Name</label><br>
                                <input type="text" name="fullname" id="fullname">
                            </div>
                            <div class="box">
                                <label for="address">Address</label><br>
                                <input type="text" name="address" id="address">
                            </div>
                            <div class="box">
                                <label for="contact">Contact no.</label><br>
                                <input type="number" name="contact" id="contact">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="box">
                                <label for="email">Email</label><br>
                                <input type="email" name="email" id="email">
                            </div>
                            <div class="box">
                                <label for="username">Username</label><br>
                                <input type="text" name="username" id="username">
                            </div>
                            <div class="box">
                                <label for="password">Password</label><br>
                                <input type="password" name="password" id="password">
                            </div>
                        </div>
                    </div>
                    <button>Signup</button>
                    <p>Already have account?<a href="login.php">Login</a></p>
                </form>
            </div>
        </div>
    </section>

    <!-- end of login form -->

    <!-- footer -->

    <?php include("parts/footer.php"); ?>

    <!-- End of footer -->

</body>

</html>