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
    <meta http-equiv="refresh" content="10">

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
                <a href="admin-account.php"><i class="fas fa-user-circle"></i> Account</a>
                <a href="admin-appointment.php"><i class="fas fa-calendar-check"></i> Appointment</a>
                <a class="active" href="admin-shop.php"><i class="fas fa-shopping-bag"></i> Shop</a>
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
                <div class="text-center">
                    <h1><strong>Shop</strong></h1>
                    <button type="button" class="btn btn-primary">
                        New Order <span class="badge bg-secondary">
                            <!-- show count of order in last 5 minutes -->
                            <?php
                            // -5 mintues from current time
                            $datetime = date("Y-m-d H:i:s", strtotime("+5 hours 40 minutes"));

                            $result = mysqli_query($con, "SELECT * FROM shop WHERE order_date > '$datetime' and status = 'no'");
                            $rowcount = mysqli_num_rows($result);
                            if ($rowcount >= 1) {
                                echo $rowcount;
                            } else {
                                echo 0;
                            }
                            ?>

                        </span>
                    </button>

                </div>
                <?php
                if (isset($_SESSION['smsg'])) {
                    echo $_SESSION['smsg'];
                    unset($_SESSION['smsg']);
                    echo "<br><br>";
                }
                ?>
                <div class="abox">
                    <h5><strong>Delivery Products</strong></h5>
                    <hr>
                    <?php
                    $sql = "SELECT * FROM `shop` WHERE status = 'no' ";
                    $result = mysqli_query($con, $sql);
                    $rowcount = mysqli_num_rows($result);
                    if ($rowcount == 0) {
                    ?>
                        <div class="text-center p-2">
                            <p>No Delivery Item</p>
                        </div>
                        <hr>
                        <?php
                    } else {
                        $result = mysqli_query($con, "SELECT * FROM shop WHERE status='no' ORDER BY order_date");
                        while ($row = mysqli_fetch_array($result)) {
                        ?>
                            <button class="accordion">
                                <span><strong>SID: <?php echo $row['sid']; ?></strong>
                                    <span class="px-2"><strong>Username: <?php echo $row['username']; ?></strong></span>
                                    <span class="operation">
                                        <!-- done-->
                                        <a href="done.php?sid=<?php echo $row["sid"]; ?>&location=admin-shop.php"><i class="far fa-check-circle"><span class="hide"> Sent to ongoing</span></i></a>
                                        <!-- passing multiple form link and delete it -->
                                        <a class="px-2" href="delete.php?sid=<?php echo $row["sid"]; ?>&location=admin-shop.php" onclick="return confirm('Are you sure want to delete?')"><i class="fas fa-trash"><span class="hide"> Delete</span></i></a>
                                    </span>
                            </button>
                            <div class="panel">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Contacter Information:</strong></p>
                                        <p>Name: <?php echo $row['fullname']; ?></p>
                                        <p>Contact: <?php echo $row['contact']; ?></p>
                                        <p>City: <?php echo $row['city']; ?></p>
                                        <p>Address: <?php echo $row['saddress']; ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Product Information:</strong></p>
                                        <p>Product Name: <?php echo $row['product_name']; ?></p>
                                        <p>Product Size: <?php echo $row['product_size']; ?></p>
                                        <p>Product Pricet: <?php echo $row['product_price']; ?></p>
                                        <p>Quantity: <?php echo $row['quantity']; ?></p>
                                        <p>Amount: <?php echo $row['total']; ?></p>
                                    </div>
                                </div>
                            </div>
                            <hr>
                    <?php }
                    } ?>

                    <div class="abox">
                        <h5 style="padding: 30px 0 20px;"><strong>Ongoing Products</strong></h5>
                        <hr>
                        <?php
                        $sql = "SELECT * FROM `shop` WHERE status = 'on' ";
                        $result = mysqli_query($con, $sql);
                        $rowcount = mysqli_num_rows($result);
                        if ($rowcount == 0) {
                        ?>
                            <div class="text-center p-2">
                                <p>No Ongoing Item</p>
                            </div>
                            <?php
                        } else {
                            $result = mysqli_query($con, "SELECT * FROM shop WHERE status='on' ORDER BY order_date");
                            while ($row = mysqli_fetch_array($result)) {
                            ?>
                                <button class="accordion">
                                    <span><strong>SID: <?php echo $row['sid']; ?></strong>
                                        <span class="px-2"><strong>Username: <?php echo $row['username']; ?></strong></span>
                                        <span class="operation">
                                            <!-- done-->
                                            <a href="done.php?oid=<?php echo $row["sid"]; ?>&location=admin-shop.php"><i class="far fa-check-circle"><span class="hide"> Delivered</span></i></a>
                                            <!-- passing multiple form link and delete it -->
                                            <a class="px-2" href="delete.php?sid=<?php echo $row["sid"]; ?>&location=admin-shop.php" onclick="return confirm('Are you sure want to delete?')"><i class="fas fa-trash"><span class="hide"> Delete</span></i></a>
                                        </span>
                                </button>
                                <div class="panel">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>Contacter Information:</strong></p>
                                            <p>Name: <?php echo $row['fullname']; ?></p>
                                            <p>Contact: <?php echo $row['contact']; ?></p>
                                            <p>City: <?php echo $row['city']; ?></p>
                                            <p>Address: <?php echo $row['saddress']; ?></p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Product Information:</strong></p>
                                            <p>Product Name: <?php echo $row['product_name']; ?></p>
                                            <p>Product Size: <?php echo $row['product_size']; ?></p>
                                            <p>Product Pricet: <?php echo $row['product_price']; ?></p>
                                            <p>Quantity: <?php echo $row['quantity']; ?></p>
                                            <p>Amount: <?php echo $row['total']; ?></p>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                        <?php }
                        } ?>


                        <div class="abox">
                            <h5 style="padding: 30px 0 20px;"><strong>Delivered Products</strong></h5>
                            <hr>
                            <?php
                            $sql = "SELECT * FROM `shop` WHERE status = 'yes' ";
                            $result = mysqli_query($con, $sql);
                            $rowcount = mysqli_num_rows($result);
                            if ($rowcount == 0) {
                            ?>
                                <div class="text-center p-2">
                                    <p>No Delivered Item</p>
                                </div>
                                <hr>
                                <?php
                            } else {
                                $result = mysqli_query($con, "SELECT * FROM shop WHERE status='yes' ORDER BY order_date");
                                while ($row = mysqli_fetch_array($result)) {
                                ?>
                                    <button class="accordion">
                                        <span><strong>SID: <?php echo $row['sid']; ?></strong>
                                            <span class="px-2"><strong>Username: <?php echo $row['username']; ?></strong></span>
                                            <span class="operation">
                                                <!-- passing multiple form link and delete it -->
                                                <a class="px-2" href="delete.php?sid=<?php echo $row["sid"]; ?>&location=admin-shop.php" onclick="return confirm('Are you sure want to delete?')"><i class="fas fa-trash"><span class="hide"> Delete</span></i></a>
                                            </span>
                                    </button>
                                    <div class="panel">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p><strong>Contacter Information:</strong></p>
                                                <p>Name: <?php echo $row['fullname']; ?></p>
                                                <p>Contact: <?php echo $row['contact']; ?></p>
                                                <p>City: <?php echo $row['city']; ?></p>
                                                <p>Address: <?php echo $row['saddress']; ?></p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><strong>Product Information:</strong></p>
                                                <p>Product Name: <?php echo $row['product_name']; ?></p>
                                                <p>Product Size: <?php echo $row['product_size']; ?></p>
                                                <p>Product Pricet: <?php echo $row['product_price']; ?></p>
                                                <p>Quantity: <?php echo $row['quantity']; ?></p>
                                                <p>Amount: <?php echo $row['total']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                            <?php }
                            } ?>
                        </div>
                    </div>
                </div>




                <script>
                    var acc = document.getElementsByClassName("accordion");
                    var i;

                    for (i = 0; i < acc.length; i++) {
                        acc[i].addEventListener("click", function() {
                            /* Toggle between adding and removing the "active" class,
                            to highlight the button that controls the panel */
                            this.classList.toggle("active");

                            /* Toggle between hiding and showing the active panel */
                            var panel = this.nextElementSibling;
                            if (panel.style.display === "block") {
                                panel.style.display = "none";
                            } else {
                                panel.style.display = "block";
                            }
                        });
                    }
                </script>



                <!-- Fontawesome -->
                <script src="https://kit.fontawesome.com/caa7c84843.js" crossorigin="anonymous"></script>

                <!-- Option 1: Bootstrap Bundle with Popper -->
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

                <!-- Option 2: Separate Popper and Bootstrap JS -->

                <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>

</body>

</html>