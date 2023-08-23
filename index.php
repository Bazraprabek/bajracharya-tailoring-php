<?php
session_start();

include("connection.php");
include("functions.php");
?>

<!-- Order finished message -->
<?php
if (isset($_SESSION['finished'])) {
    echo "<script type='text/javascript'>alert('{$_SESSION['finished']}');</script>";
    unset($_SESSION['finished']);
}
?>


<!doctype html>
<html lang="en">

<head>
    <!-- meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Fontawesome css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- css -->
    <link rel="stylesheet" href="css/home.css">

    <!-- favicon -->
    <link rel="shortcut icon" href="icon/favicon.ico" type="image/x-icon">

    <!-- Bootstrap Js-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    
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

    <!-- Carousel -->

    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel" data-interval="100">
        <div class="carousel-inner">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-item active">
                <img src="img/ad-min.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption">
                    <h1>Get wellfitting Cothing right now</h1>
                    <a href="appointment.php?wed=no" class="nbtn">SHOP NOW</a>
                </div>
            </div>
            <div class="carousel-item">
                <img src="img/12131.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption">
                    <h1>Order Gentlemen Clothing</h1>
                    <a href="shop.php" class="nbtn">SHOP NOW</a>
                </div>
            </div>
            <div class="carousel-item">
                <img src="img/524.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption">
                    <h1>Get 20% Off For Wedding</h1>
                    <a href="appointment.php?wed=yes" class="nbtn">SHOP NOW</a>
                </div>
            </div>
        </div>
    </div>

    <!-- End Carousel -->

    <!-- New products -->

    <section class="new_products">
        <div class="container">
            <h1 class="text-center"><strong>FEATURED ITEMS</strong></h1>
            <div class="row">
                <?php
                $result = mysqli_query($con, "SELECT * FROM `upload` WHERE `featured` = 'yes' LIMIT 4");

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
            <div class="text-center more">
                <a class="mbtn" href="shop.php">More</a>
            </div>
        </div>
    </section>

    <!-- End New products -->

    <!-- Collection -->

    <section class="collection">
        <div class="container">
            <h1 class="text-center"><strong>COLLECTION</strong></h1>
            <div class="row">
                <div class="collbox col-lg-3 col-md-4 col-sm-6">
                    <a href="shop.php">
                        <div class="card">
                            <img src="img/323124.jpg" class="img-fluild" alt="">
                            <span>COATS AND BLAZERS</span>
                        </div>
                    </a>
                </div>
                <div class="collbox col-lg-3 col-md-4 col-sm-6">
                    <a href="shop.php">
                        <div class="card">
                            <img src="img/905.jpg" class="img-fluild" alt="">
                            <span>PANTS</span>
                        </div>
                    </a>
                </div>
                <div class="collbox col-lg-3 col-md-4 col-sm-6">
                    <a href="shop.php">
                        <div class="card">
                            <img src="img/121.jpg" class="img-fluild" alt="">
                            <span>SHIRTS</span>
                        </div>
                    </a>
                </div>
                <div class="collbox col-lg-3 col-md-4 col-sm-6">
                    <a href="shop.php">
                        <div class="card">
                            <img src="img/Product-Ties-290x335.jpg" class="img-fluild" alt="">
                            <span>TIES AND BOW TIES</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- End Collection -->

    <!-- Services -->

    <section class="services">
        <div class="container">
            <h1 class="text-center"><strong>Our Services</strong></h1>
            <div class="row">
                <div class="col-sm-6 col-lg-3">
                    <h3><i class="fas fa-user-tie"></i></h3>
                    <h3>Customize Products</h3>
                    <p>We offer custom remarkable fit garments alterations for men and women in formal
                        traditional garments.</p>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <h3><i class="fas fa-tshirt"></i></h3>
                    <h3>Readymade Products</h3>
                    <p>We offer ready-made clothing with all sizes for men and women.</p>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <h3><i class="fas fa-truck"></i></i></h3>
                    <h3>Home Delivery</h3>
                    <p>We offer home delivery of Readymade Product.</p>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <h3><i class="fas fa-hand-holding-usd"></i></h3>
                    <h3>Cash and Delivery</h3>
                    <p>We perfer cash and delivery.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- End of Services -->

    <!-- Contact Us -->

    <?php
    //check is submit post button press or not
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $fname = $_POST['fname'];
        $cmail = $_POST['cmail'];
        $cmsg = $_POST['cmsg'];

        // store values to database
        $csql = "INSERT INTO `contact` (`fname`, `cmail`, `cmsg`, `date`) 
						VALUES ('$fname', '$cmail', '$cmsg', CURRENT_TIMESTAMP);";
        mysqli_query($con, $csql);
    }
    ?>

    <section class="contact">
        <div class="container">
            <h1 class="text-center">How May We Help You?</h1>
            <div class="row contact_box">
                <div class="contact_info col-md-6">
                    <div>
                        <h5><i class="fas fa-map-marker-alt"></i>Location</h5>
                        <p>Sundhara,Lalitpur</p>
                    </div>
                    <div>
                        <h5><i class="fas fa-phone-square-alt"></i>Phone</h5>
                        <p><a href="tel:9860234234">9860234234</a></p>
                    </div>
                    <div>
                        <h5><i class="fas fa-envelope"></i>Email</h5>
                        <p><a href="mailto:bajracharyatailoring@gmail.com">bajracharyatailoring@gmail.com</a></p>
                    </div>
                </div>
                <div class="contact_form col-md-6">
                    <form method="post">
                        <div class="row">
                            <input type="text" placeholder="Full Name" name="fname" id="" required>
                        </div>
                        <div class="row">
                            <input type="email" placeholder="Email" name="cmail" id="" required>
                        </div>
                        <div class="row">
                            <textarea placeholder="Message" name="cmsg" id="" cols="30" rows="5"></textarea>
                        </div>
                        <button class="cbtn">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- End of Contact Us -->

    <!-- footer -->

    <?php include("parts/footer.php"); ?>

    <!-- end of footer -->


</body>

</html>