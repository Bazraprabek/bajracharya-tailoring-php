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

    <!-- Chart -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

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
                <a class="active" href="admin.php"><i class="fas fa-home"></i> Dashboard</a>
                <a href="admin-account.php"><i class="fas fa-user-circle"></i> Account</a>
                <a href="admin-appointment.php"><i class="fas fa-calendar-check"></i> Appointment</a>
                <a href="admin-shop.php"><i class="fas fa-shopping-bag"></i> Shop</a>
                <a href="admin-upload.php"><i class="fas fa-cloud-upload-alt"></i> Upload</a>
                <a href="admin-contact.php"><i class="far fa-address-book"></i> Contact</a>
            </div>
        </div>

        <!-- Page content -->
        <div class="content">
            <div class="text-center p-2" style=" background:black; color: blanchedalmond;">
                <h1>
                    Welcome, <?php echo ucwords($user_data['username']); ?>
                </h1>
            </div>
            <div class="row m-auto text-center">
                <div class="col-lg-4">
                    <h3>Number of user :
                        <?php
                        $sql = "SELECT * FROM `users` ";
                        $result = mysqli_query($con, $sql);
                        echo $accountcount = mysqli_num_rows($result);
                        ?></h3>
                </div>
                <div class="col-lg-4">
                    <h3>Number of upload :
                        <?php
                        $sql = "SELECT * FROM `upload` ";
                        $result = mysqli_query($con, $sql);
                        echo $uploadcount = mysqli_num_rows($result);
                        ?></h3>
                </div>
                <div class="col-lg-4">
                    <h3>Number of contact :
                        <?php
                        $sql = "SELECT * FROM `contact` ";
                        $result = mysqli_query($con, $sql);
                        echo $contactcount = mysqli_num_rows($result);
                        ?></h3>
                </div>
            </div>
            <div class="row m-auto">
                <div class="pie col-lg-6">
                    <canvas id="myChart"></canvas>
                    <?php

                    // Appointment total row count
                    $sql = "SELECT * FROM `appointment` ";
                    $result = mysqli_query($con, $sql);
                    $appointmentcount = mysqli_num_rows($result);

                    // Shop total row count
                    $sql = "SELECT * FROM `shop` ";
                    $result = mysqli_query($con, $sql);
                    $shopcount = mysqli_num_rows($result);
                    ?>
                    <script>
                        var xValues = ["Appointment", "Ready-made"];
                        var yValues = [<?php echo $appointmentcount ?>, <?php echo $shopcount ?>];
                        var barColors = [
                            "red",
                            "blue"
                        ];

                        new Chart("myChart", {
                            type: "pie",
                            data: {
                                labels: xValues,
                                datasets: [{
                                    backgroundColor: barColors,
                                    data: yValues
                                }]
                            },
                            options: {
                                title: {
                                    display: true,
                                    text: "Orders"
                                }
                            }
                        });
                    </script>
                </div>
                <div class="pie col-lg-6">
                    <canvas id="MyChart"></canvas>
                    <script>
                        <?php

                        // For Appointment
                        $a1 = date("F-d");
                        $t1 = date("Y-m-d");
                        $st1 = date("Y-m-d 0:0:0");
                        $sql = "SELECT * FROM `appointment` WHERE adate='$t1' and status = 'yes'";
                        $result = mysqli_query($con, $sql);
                        $acount1 = mysqli_num_rows($result);
                        $sql = "SELECT * FROM `shop` WHERE order_date > '$st1' and status = 'yes'";
                        $result = mysqli_query($con, $sql);
                        $scount1 = mysqli_num_rows($result);

                        $a2 = date("F-d", strtotime("-1 day"));
                        $t2 = date("Y-m-d", strtotime("-1 day"));
                        $st2 = date("Y-m-d 0:0:0", strtotime("-1 day"));
                        $sql = "SELECT * FROM `appointment` WHERE adate='$t2' ";
                        $result = mysqli_query($con, $sql);
                        $acount2 = mysqli_num_rows($result);
                        $sql = "SELECT * FROM `shop` WHERE order_date > '$st2' and order_date < '$st1'";
                        $result = mysqli_query($con, $sql);
                        $scount2 = mysqli_num_rows($result);

                        $a3 = date("F-d", strtotime("-2 day"));
                        $t3 = date("Y-m-d", strtotime("-2 day"));
                        $st3 = date("Y-m-d 0:0:0", strtotime("-2 day"));
                        $sql = "SELECT * FROM `appointment` WHERE adate='$t3' ";
                        $result = mysqli_query($con, $sql);
                        $acount3 = mysqli_num_rows($result);
                        $sql = "SELECT * FROM `shop` WHERE order_date > '$st3' and order_date < '$st2'";
                        $result = mysqli_query($con, $sql);
                        $scount3 = mysqli_num_rows($result);

                        $a4 = date("F-d", strtotime("-3 day"));
                        $t4 = date("Y-m-d", strtotime("-3 day"));
                        $st4 = date("Y-m-d 0:0:0", strtotime("-3 day"));
                        $sql = "SELECT * FROM `appointment` WHERE adate='$t4' ";
                        $result = mysqli_query($con, $sql);
                        $acount4 = mysqli_num_rows($result);
                        $sql = "SELECT * FROM `shop` WHERE order_date > '$st4' and order_date < '$st3'";
                        $result = mysqli_query($con, $sql);
                        $scount4 = mysqli_num_rows($result);

                        $a5 = date("F-d", strtotime("-4 day"));
                        $t5 = date("Y-m-d", strtotime("-4 day"));
                        $st5 = date("Y-m-d 0:0:0", strtotime("-4 day"));
                        $sql = "SELECT * FROM `appointment` WHERE adate='$t5' ";
                        $result = mysqli_query($con, $sql);
                        $acount5 = mysqli_num_rows($result);
                        $sql = "SELECT * FROM `shop` WHERE order_date > '$st5' and order_date < '$st4'";
                        $result = mysqli_query($con, $sql);
                        $scount5 = mysqli_num_rows($result);
                        ?>

                        var xValues = ['<?php echo $a1 ?>', '<?php echo $a2 ?>', '<?php echo $a3 ?>', '<?php echo $a4 ?>', '<?php echo $a5 ?>'];

                        new Chart("MyChart", {
                            type: "line",
                            data: {
                                labels: xValues,
                                datasets: [{
                                    // Appointment
                                    data: [<?php echo $acount1 . ',' . $acount2 . ',' . $acount3 . ',' . $acount4 . ',' . $acount5 ?>],
                                    borderColor: "red",
                                    fill: false
                                }, {
                                    // Shop or Ready-made
                                    data: [<?php echo $scount1 . ',' . $scount2 . ',' . $scount3 . ',' . $scount4 . ',' . $scount5 ?>],
                                    borderColor: "blue",
                                    fill: false
                                }]
                            },
                            options: {
                                legend: {
                                    display: false,
                                }
                            }
                        });
                    </script>
                </div>
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