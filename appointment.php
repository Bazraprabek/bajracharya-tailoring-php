<?php
session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($con);

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
    <link rel="stylesheet" href="css/appointment.css">
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

    <!-- End Navbar -->

    <!-- Title -->

    <section id="title">
        <h1 class="text-center">Book Appointment</h1>
    </section>

    <!-- End of Title -->

    <!-- Appointment -->
    <div id="appointment">
    <section class="profile my-4">
        <div class="container">

            <!-- Error Message -->
            <?php
            if (isset($_SESSION['amsg'])) { ?>
                <p style="color: red;"><strong><?php echo $_SESSION['amsg']; ?></strong></p>
            <?php unset($_SESSION['amsg']);
            }
            ?>

            <div class="signup">
                <h2>
                    Appointment
                </h2>
                <form action="add-appointment.php?location=appointment.php" method="post">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="box">
                                <label for="fullname"><strong>Full Name</strong></label><br>
                                <input type="text" name="fullname" id="fullname" >
                            </div>
                            <div class="box">
                                <label for="contact"><strong>Contact Number</strong></label><br>
                                <input type="tel" name="contact" id="contact" >
                            </div>

                        </div>
                        <div class="col-lg-6">
                            <div class="box">
                                <label for="datemin"><strong>Date</strong></label><br>
                                <input name="adate" type="date" id="datemin" name="datemin""
                                            max=" <?php echo date("Y-m-d", strtotime("+16 day")); ?>" min="<?php echo date("Y-m-d", strtotime("+1 day")); ?>" >
                            </div>
                            <div class="box">
                                <label for="wedding"><strong>Wedding</strong></label><br>
                                  <input type="radio" id="yes" value="yes" name="wedding">
                                  <label for="yes">Yes</label>
                                  <input type="radio" id="no" value="no" name="wedding" checked>
                                  <label for="no">No</label>
                            </div>
                        </div>
                    </div>
                    <div class="box">
                        <label for="time"><strong>Time</strong></label><br>
                        <table width="100%">
                            <tr>
                                <td>
                                    <label for="10am"><input type="radio" id="10am" name="time" value="10am" > 10am</label>
                                </td>
                                <td>
                                    <label for="11am"><input type="radio" id="11am" name="time" value="11am"> 11am</label>
                                </td>
                                <td>
                                    <label for="12pm"><input type="radio" id="12pm" name="time" value="12pm"> 12pm</label>
                                </td>
                                <td>
                                    <label for="1pm"><input type="radio" id="1pm" name="time" value="1pm"> 1pm</label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="2pm"><input type="radio" id="2pm" name="time" value="2pm"> 2pm</label>
                                </td>
                                <td>
                                    <label for="3pm"><input type="radio" id="3pm" name="time" value="3pm"> 3pm</label>
                                </td>
                                <td>
                                    <label for="5pm"><input type="radio" id="5pm" name="time" value="5pm"> 5pm</label>
                                </td>
                                <td>
                                    <label for="6pm"><input type="radio" id="6pm" name="time" value="6pm"> 6pm</label>
                                </td>
                            </tr>
                        </table>
                        <br>
                    </div>
                    <button>Book</button>
                </form>
            </div>
        </div>
    </section>
    
    </div>

    <!-- End of Appointment -->




















    <!-- footer -->

    <?php include("parts/footer.php"); ?>

    <!-- End of footer -->

</body>

</html>