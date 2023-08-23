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

if (isset($_GET["id"])) {

    // store id from link
    $id = $_GET["id"];

    // selecting row match to id
    $result = mysqli_query($con, "SELECT * FROM upload WHERE product_id =$id");

    // storing all the value in array into $row
    $row = mysqli_fetch_array($result);

    $product_name = $row['product_name'];
    $product_price = $row['product_price'];
    $product_info = $row['product_info'];
    $current_img = $row['product_img'];
    $featured = $row['featured'];
    $category = $row['category'];
}

//check is submit post button press or not
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    //something was posted
    $product_name = ucwords($_POST['product_name']);
    $product_price = $_POST['product_price'];
    $product_info = $_POST['product_info'];
    $featured = $_POST['featured'];
    $category = $_POST['category'];

    // update image
    if (isset($_FILES['product_img']['name'])) {

        $product_img = $_FILES['product_img']['name'];

        // check image is avilable or not
        if ($product_img !== "") {
            // auto rename our image
            // get the extension of our image (jpg,png)
            $tmp = explode('.', $product_img);
            $fileExtension = end($tmp);

            // rename the image
            $product_img = "image" . rand(0, 9999) . '.' . $fileExtension;

            $sourcepath = $_FILES['product_img']['tmp_name'];
            $destination = "upload/" . $product_img;

            // Upload image
            $upload = move_uploaded_file($sourcepath, $destination);

            if ($upload == false) {
                $_SESSION['umsg'] = "Failed to upload image!";
            }
        } else {
            $product_img = $current_img;
        }
    } else {
        $product_img = $current_img;
    }

    //save to database
    $query = "UPDATE `upload` SET
        product_name = '$product_name',
        product_price = '$product_price',
        product_img = '$product_img',
        product_info = '$product_info',
        featured = '$featured',
        category = '$category'
        WHERE product_id='$id'
        ";
    if(mysqli_query($con, $query)){
        $_SESSION['umsg'] = 'Update successfully';

        // redirect to login page
        header("Location: admin-upload.php");
        die;
    }else{
        $_SESSION['umsg'] = 'Fail to Update';

        // redirect to login page
        header("Location: admin-upload.php");
        die;
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
                <a href="admin-appointment.php"><i class="fas fa-calendar-check"></i> Appointment</a>
                <a href="admin-shop.php"><i class="fas fa-shopping-bag"></i> Shop</a>
                <a class="active" href="admin-upload.php"><i class="fas fa-cloud-upload-alt"></i> Upload</a>
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
                        if (isset($_SESSION['umsg'])) {
                            echo $_SESSION['umsg'];
                            unset($_SESSION['umsg']);
                        }
                        ?>

                        <div class="signup">
                            <h2>
                                Update Item
                            </h2>
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="box">
                                            <label for="product_name">Product Name</label><br>
                                            <input type="text" name="product_name" id="product_name" value="<?php echo $product_name ?>" required>
                                        </div>
                                        <div class="box">
                                            <label for="category">Categories</label><br>
                                            <select id="category" name="category">
                                                <option value="pants" <?php if ($category == "pants") {
                                                                            echo "selected";
                                                                        } ?>>Pants</option>
                                                <option value="coats" <?php if ($category == "coats") {
                                                                            echo "selected";
                                                                        } ?>>Coats and Blazers</option>
                                                <option value="shirts" <?php if ($category == "shirts") {
                                                                            echo "selected";
                                                                        } ?>>Shirts</option>
                                                <option value="ties" <?php if ($category == "ties") {
                                                                            echo "selected";
                                                                        } ?>>Ties & Bow Ties</option>
                                            </select>
                                        </div>
                                        <div class="box">
                                            <label>Product Image</label><br>
                                            <input type="file" name="product_img">
                                            <input type="hidden" name="current_img" value="<?php echo $current_img ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="box">
                                            <label for="product_price">Product Price</label><br>
                                            <input type="number" name="product_price" id="product_price" value="<?php echo $product_price ?>" required>
                                        </div>
                                        <div class="box">
                                            <label for="featured">Featured</label><br>
                                              <input type="radio" id="yes" value="yes" name="featured" <?php if ($featured == "yes") {
                                                                                                            echo "checked";
                                                                                                        } ?>>
                                              <label for="yes">Yes</label>
                                              <input type="radio" id="no" value="no" name="featured" <?php if ($featured == "no") {
                                                                                                            echo "checked";
                                                                                                        } ?>>
                                              <label for="no">No</label>
                                        </div>
                                        <div class="box">
                                            <label>Current Image</label><br>
                                            <?php
                                            if ($current_img != "") {
                                            ?>
                                                <img src="upload/<?php echo $current_img; ?>" alt="image of item" width="80px" height="80px">
                                            <?php
                                            } else {
                                                echo "Image not found";
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label for="product_info">Product Description</label><br>
                                    <textarea class="textinput p-2" name="product_info" id="product_info" placeholder="Description"><?php echo $product_info ?></textarea>
                                </div>
                                <button>Update</button>
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