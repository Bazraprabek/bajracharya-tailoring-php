<?php
session_start();

include("connection.php");
include("functions.php");
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
  <link rel="stylesheet" href="css/shop.css">

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

  <!-- Title -->

  <section id="title">
    <h1 class="text-center">Shop</h1>
  </section>

  <!-- End of Title -->
  <div class="text-center">
    <div class="btn-group btn-group-md btn-block ">
      <button type="button" data-filter=".all" class="btn btn-outline-success">ALL</button>
      <button type="button" data-filter=".coats" class="btn btn-outline-success">Coats</button>
      <button type="button" data-filter=".pants" class="btn btn-outline-success">Pants</button>
      <button type="button" data-filter=".shirts" class="btn btn-outline-success">Shirts</button>
      <button type="button" data-filter=".ties" class="btn btn-outline-success">Ties</button>
    </div>
  </div>
  <section id="Container" class="new_products shop">
    <div class="container">
      <div class="row">

        <!-- Category items to display -->

        <?php
        $result = mysqli_query($con, "SELECT * FROM `upload`");

        while ($product = mysqli_fetch_array($result)) {
        ?>
          <div class=" mix <?php echo $product['category']; ?> all col-lg-3 col-md-4 col-sm-6">
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

  <script type="text/javascript">
    $(document).ready(function() {
      var mixer = mixitup('.shop');
    })
  </script>
  <script type="text/javascript" src="jquery/mixitup.min.js"></script>













  <!-- footer -->

  <?php include("parts/footer.php"); ?>

  <!-- End of footer -->

</body>

</html>