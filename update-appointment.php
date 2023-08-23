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


if (isset($_GET["aid"])) {

    // store id from link
    $aid = $_GET["aid"];

    // selecting row match to id
    $result = mysqli_query($con, "SELECT * FROM appointment WHERE aid =$aid");

    // storing all the value in array into $row
    $row = mysqli_fetch_array($result);

    $fullname = $row['fullname'];
    $username = $row['username'];
    $contact = $row['contact'];
    $wedding = $row['wedding'];
    $adate = $row['adate'];
    $time = $row['time'];
}

//check is submit post button press or not
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $fullname = $_POST['fullname'];
    $username = $user_data['username'];
    $wedding = $_POST['wedding'];
    $contact = $_POST['contact'];
    $adate = $_POST['adate'];
    $time = $_POST['time'];

    $query = "SELECT * FROM `appointment` WHERE `adate` = '$adate' and time = '$time'";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) <= 0) {

        $query = "UPDATE `appointment` SET
        fullname = '$fullname',
        username = '$username',
        wedding = '$wedding',
        contact = '$contact',
        adate = '$adate',
        time = '$time',
        status = 'no'
        WHERE aid='$aid'
        ";

        if (mysqli_query($con, $query)) {
            $_SESSION['amsg'] = 'Updated Successfully';
            header("Location: admin-appointment.php");
            die;
        } else {
            $_SESSION['amsg'] = 'Fail to update';
            header('Location: admin-appointment.php');
            die;
        }
    } else {
        $_SESSION['amsg'] = 'Already booked in that time!';
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
    <link rel="stylesheet" href="css/admin.css">
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
                <a href="admin-account.php"><i class="fas fa-user-circle"></i> Account</a>
                <a class="active" href="admin-appointment.php"><i class="fas fa-calendar-check"></i> Appointment</a>
                <a href="admin-shop.php"><i class="fas fa-shopping-bag"></i> Shop</a>
                <a href="admin-upload.php"><i class="fas fa-cloud-upload-alt"></i> Upload</a>
                <a href="admin-contact.php"><i class="far fa-address-book"></i> Contact</a>
            </div>
            <div class="side-footer">
                <p>Copyright&copy;2020</p>
            </div>
        </div>

        <!-- Page content -->
        <div class="content">
            <div class="box">
                <section class="profile m-0">
                    <div class="container">

                        <!-- Error Message -->
                        <?php
                        if (isset($_SESSION['amsg'])) {
                            echo $_SESSION['amsg'];
                            unset($_SESSION['amsg']);
                        }
                        ?>

                        <div class="signup">
                            <h2>
                                Update Appointment
                            </h2>
                            <form action="" method="post">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="box">
                                            <label for="fullname">Full Name</label><br>
                                            <input type="text" name="fullname" id="fullname" value="<?php echo $fullname ?>" required>
                                        </div>
                                        <div class="box">
                                            <label for="contact">Contact</label><br>
                                            <input type="text" name="contact" id="contact" value="<?php echo $contact ?>" required>
                                        </div>

                                    </div>
                                    <div class="col-lg-6">
                                        <div class="box">
                                            <label for="datemin">Date</label><br>
                                            <input name="adate" type="date" id="datemin" name="datemin" value="<?php echo $adate ?>"
                                            max="<?php echo date("Y-m-d", strtotime("+16 day")); ?>" min="<?php echo date("Y-m-d", strtotime("+1 day")); ?>" required>
                                        </div>
                                        <div class="box">
                                            <label for="wedding">Wedding</label><br>
                                              <input type="radio" id="yes" value="yes" name="wedding" <?php if ($wedding == "yes") {
                                                                                                            echo "checked";
                                                                                                        } ?>>
                                              <label for="yes">Yes</label>
                                              <input type="radio" id="no" value="no" name="wedding" <?php if ($wedding == "no") {
                                                                                                        echo "checked";
                                                                                                    } ?>>
                                              <label for="no">No</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="box">
                                <label for="time">Time</label><br>
                                    <input type="radio" id="time" name="time" value="10am" <?php if ($time == "10am") { echo "checked";} ?> required>
                                    <label for="yes">10am</label>
                                    <input type="radio" id="time" name="time" value="11am" <?php if ($time == "11am") { echo "checked";} ?>>
                                    <label for="no">11am</label>
                                    <input type="radio" id="timed" name="time" value="12pm" <?php if ($time == "12pm") { echo "checked";} ?>>
                                    <label for="no">12pm</label>
                                    <input type="radio" id="time" name="time" value="1pm" <?php if ($time == "1pm") { echo "checked";} ?>>
                                    <label for="no">1pm</label>
                                    <br>
                                    <input type="radio" id="time" name="time" value="2pm" <?php if ($time == "2pm") { echo "checked";} ?>>
                                    <label for="yes">2pm</label>
                                    <input type="radio" id="time" name="time" value="3pm" <?php if ($time == "3pm") { echo "checked";} ?>>
                                    <label for="no">3pm</label>
                                    <input type="radio" id="time" name="time" value="5pm" <?php if ($time == "5pm") { echo "checked";} ?>>
                                    <label for="no">5pm</label>
                                    <input type="radio" id="time" name="time" value="6pm" <?php if ($time == "6pm") { echo "checked";} ?>>
                                    <label for="no">6pm</label>
                                </div>
                                <button type="submit">Update</button>
                            </form>
                        </div>
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