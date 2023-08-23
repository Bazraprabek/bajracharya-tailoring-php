<?php

session_start();

include("connection.php");
include("functions.php");

//check if user if login or not
$user_data = check_login($con);

if (isset($_POST['hopNow'])) {
    $_SESSION['product_size'] = $_POST['product_size'];
    $_SESSION['quantity'] = $_POST['quantity'];
}

if (isset($_GET["id"])) {

    // store id from link
    $id = $_GET["id"];

    // selecting row match to id
    $result = mysqli_query($con, "SELECT * FROM upload WHERE product_id =$id");

    // storing all the value in array into $row
    $row = mysqli_fetch_array($result);

    $product_name = $row['product_name'];
    $_SESSION['product_price'] = $row['product_price'];
}

if (isset($_POST['cartNow'])) {
    $_SESSION['product_price'] = $_POST['product_price'];
    $_SESSION['quantity'] = $_POST['quantity'];
}

if (isset($_POST['shopNow'])) {
    $i = 0;
    foreach ($_SESSION["shopping_cart"] as $keys => $values) {

        $product_name = $values["product_name"];
        $username = $user_data['username'];
        $quantity = $values['quantity'];
        $product_size = $values["product_size"];
        $product_price = $values['product_price'];
        $fullname = ucwords($_POST['fullname']);
        $total = $values['product_price'] * $values['quantity'] + 50;
        $city = $_POST['city'];
        $saddress = $_POST['saddress'];
        if (isset($_POST['contact'])) {
            $contact = $_POST['contact'];
            // count total digit
            $contactlen = strlen($contact);
            // store first 2 digit of contact
            $contact98 = $contact[0] . $contact[1];
            $contact01 = $contact[0] . "a" . $contact[1];
        }

        // check if contact is 9digit and start from 01 or contact is 10digit and start from 98
        if (($contact01 == "0a1" && $contactlen == 9) || ($contact98 == 98 && $contactlen == 10)) {

            $query = "INSERT INTO `shop` (`product_name`, `username`, `product_price`, `product_size`, `quantity`, `fullname`,
        `total`, `contact`, `city`, `saddress`, `order_date`, `status`) 
       VALUES ('$product_name', '$username', '$product_price','$product_size', '$quantity', '$fullname', '$total', '$contact',
        '$city', '$saddress', CURRENT_TIMESTAMP, 'no')";

            $result = mysqli_query($con, $query);
            $count = count($_SESSION["shopping_cart"]);
            $i++;

            if ($count == $i) {
                $_SESSION['finished'] = 'Order Sucessful';
                unset($_SESSION["shopping_cart"]);
                header("Location: index.php");
                die;
            } else {
                $_SESSION['nmsg'] = 'Fail to order';
            }
        } else {
            $_SESSION['nmsg'] = 'Please Enter Valid Contact Number!';
        }
    }
}

if (isset($_POST['orderNow'])) {

    $product_name = $_POST['product_name'];
    $username = $user_data['username'];
    $product_price = $_POST['product_price'];
    $product_size = $_SESSION['product_size'];
    $quantity = $_SESSION['quantity'];
    $fullname = ucwords($_POST['fullname']);
    $total = $_POST['total'];
    $city = $_POST['city'];
    $saddress = $_POST['saddress'];
    if (isset($_POST['contact'])) {
        $contact = $_POST['contact'];
        // count total digit
        $contactlen = strlen($contact);
        // store first 2 digit of contact
        $contact98 = $contact[0] . $contact[1];
        $contact01 = $contact[0] . "a" . $contact[1];
    }

    // check if contact is 9digit and start from 01 or contact is 10digit and start from 98
    if (($contact01 == "0a1" && $contactlen == 9) || ($contact98 == 98 && $contactlen == 10)) {

        $query = "INSERT INTO `shop` (`product_name`, `username`, `product_price`, `product_size`, `quantity`, `fullname`,
     `total`, `contact`, `city`, `saddress`, `order_date`, `status`) 
    VALUES ('$product_name', '$username', '$product_price','$product_size', '$quantity', '$fullname', '$total', '$contact',
     '$city', '$saddress', CURRENT_TIMESTAMP, 'no')";

        if (mysqli_query($con, $query)) {
            $_SESSION['finished'] = 'Order Sucessful';
            header("Location: index.php");
            die;
        } else {
            $_SESSION['nmsg'] = 'Fail to order';
        }
    } else {
        $_SESSION['nmsg'] = 'Please Enter Valid Contact Number!';
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
    <link rel="stylesheet" href="css/description.css">
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
    <div class="container">
        <section class="profile mx-2">
            <div class="container">

                <!-- Error Message -->
                <?php
                if (isset($_SESSION['nmsg'])) {
                    echo $_SESSION['nmsg'];
                    unset($_SESSION['nmsg']);
                }
                ?>

                <div class="signup">
                    <h2>
                        Delivery Information
                    </h2>
                    <form action="" method="post">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="box">
                                    <label for="username">Username</label><br>
                                    <h4><?php echo $user_data['username']; ?></h4>
                                </div>
                                <div class="box">
                                    <label for="fullname">Full Name</label><br>
                                    <input type="text" name="fullname" id="fullname" value="<?php echo $user_data['fullname']; ?>" required>
                                </div>
                                <div class="box">
                                    <label for="contact">Contact Number</label><br>
                                    <input type="number" name="contact" id="contact" value="<?php echo $user_data['contact']; ?>" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="box">
                                    <label for="city">City</label><br>
                                    <select id="city" name="city">
                                        <option value="kathmandu">Kathmandu</option>
                                        <option value="banepa">Banepa</option>
                                        <option value="bhaktapur">Bhaktapur</option>
                                        <option value="lalitpur">Lalitpur</option>
                                        <option value="janakpur">Janakpur</option>
                                        <option value="hetauda">Hetauda</option>
                                        <option value="pokhara">Pokhara</option>
                                        <option value="chitwan">Chitwan</option>
                                        <option value="dharan">Dharan</option>
                                        <option value="butwal">Butwal</option>
                                    </select>
                                </div>
                                <label for="product_name">Address</label><br>
                                <textarea style="padding: 5px;" name="saddress" id="saddress" cols="30" rows="6" placeholder="Eg: Area#, Street# 123" required></textarea>
                            </div>
                        </div>
                        <div class="box mt-2 mx-auto" style="max-width: 40vh;">
                            <label><strong>Order Summary</strong></label>
                            <hr>
                            <table width="100%">
                                <tr>
                                    <th width="50%">Items(<?php echo $_SESSION['quantity']; ?>)</th>
                                    <?php
                                    if (isset($_POST['hopNow'])) { ?>
                                        <input type="hidden" name="product_name" id="product_name" value="<?php echo $product_name ?>">
                                        <input type="hidden" name="product_price" id="product_price" value="<?php echo $_SESSION['product_price'] ?>">
                                        <td width="50%">Rs.<?php echo $price = $_SESSION['product_price'] * $_SESSION['quantity']; ?></td>
                                    <?php } else { ?>
                                        <td width="50%">Rs.<?php echo $price = $_SESSION['product_price'] ?></td>
                                    <?php } ?>
                                </tr>
                                <tr>
                                    <th width="50%">Fee</th>
                                    <td width="50%">Rs.50</td>
                                </tr>
                            </table>
                            <hr>
                            <table width="100%">
                                <tr>
                                    <th width="50%">Total</th>
                                    <input type="hidden" name="total" id="total" value="<?php echo $total = $price + 50; ?>">
                                    <td width="50%">Rs.<?php echo $total; ?></td>
                                </tr>
                            </table>
                        </div>
                        <button type="submit" <?php if ($_GET['action'] == "cart") { ?> name="shopNow" <?php } else { ?> name="orderNow" <?php } ?>>
                            Order Now</button>
                        <div class="box bg-white mt-4">
                            <label><strong>Note:</strong></label>
                            <p class="p-0">Cash and Delivery Only!</p>
                            <p class="p-0">Out fo Valley will be fined Rs.200</p>
                        </div>
                </div>
                </form>
            </div>
    </div>
    </section>
    </div>



    <!-- footer -->

    <?php include("parts/footer.php"); ?>

    <!-- End of footer -->

</body>

</html>