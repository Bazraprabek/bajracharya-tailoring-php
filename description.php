<?php

session_start();

include("connection.php");
include("functions.php");

if (isset($_GET["id"])) {

    // store id from link
    $id = $_GET["id"];

    // selecting row match to id
    $result = mysqli_query($con, "SELECT * FROM upload WHERE product_id =$id");

    // storing all the value in array into $row
    $items = mysqli_fetch_array($result);

    $product_name = $items['product_name'];
    $product_img = $items['product_img'];
    $product_price = $items['product_price'];
    $product_info = $items['product_info'];
    $category = $items['category'];
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
    <section class="description">
            <div class="row">
                <div class="col-md-7">
                    <img src="upload/<?php echo $items['product_img']; ?>" alt="image of item">
                </div>
                <div class="col-md-5">
                    <h1><?php echo $items['product_name']; ?></h1>
                    <p><?php echo $items['product_info']; ?></p>
                    <hr>
                    <h3 style="color:green;">Rs. <?php echo $items['product_price']; ?>
                    </h3>
                    <strike><span style="color:green;">Rs.<?php echo $items['product_price'] + round($items['product_price'] * 10 / 100); ?></span></strike>
                    <span>-10%</span>
                    <hr>
                    <form action="" method="post">
                        <input type="hidden" name="product_name" value="<?php echo $product_name; ?>">
                        <input type="hidden" name="product_img" value="<?php echo $items['product_img']; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $product_price; ?>">
                        <select id="product_size" name="product_size">
                            <option value="small">Small</option>
                            <option value="medium">Medium</option>
                            <option value="large">Large</option>
                            <option value="extraLarge">Extra Large</option>
                        </select>
                        <label for="quantity" style="margin-left:10px;">Quantity <input type="number" style="width:40px; margin-top:10px;" value="1" id="quantity" name="quantity" min="1" max="5" required></label>
                        <br><br>
                        <button formaction="shop-now.php?id=<?php echo $items['product_id']; ?>&action=order" name="hopNow" class="btn btn-warning" style="margin-right: 10px;">Shop Now</button>
                        <button name="cart" class="btn btn-primary">Add to Cart</button>
                    </form>
                </div>
            </div>
        </section>
        <section class="new_products">
            <div class="container">
                <h1 class="text-center"><strong>Related Products</strong></h1>
                <div class="row">
                    <?php
                    $result = mysqli_query($con, "SELECT * FROM `upload` WHERE `category` = '$category' and product_id != '$id' LIMIT 4");

                    while ($product = mysqli_fetch_array($result)) {
                    ?>
                        <div class=" col-lg-3 col-md-4 col-sm-6">
                            <a href="description.php?id=<?php echo $product['product_id']; ?>">
                                <div class="card">
                                    <img src="upload/<?php echo $product['product_img']; ?>" class="img-fluild" alt="pic of featured items">
                                    <h2><?php echo $product['product_name']; ?></h2>
                                    <p>Rs. <?php echo $product['product_price']; ?></< /p>
                                </div>
                            </a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </section>
    </div>



    <!-- footer -->

    <?php include("parts/footer.php"); ?>

    <!-- End of footer -->

</body>

</html>