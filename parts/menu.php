<?php

if (isset($_POST["cart"])) {
    if (isset($_SESSION["shopping_cart"])) {

        // store value of product_id from session of shopping_cart in $item_array_id
        $item_array_id = array_column($_SESSION["shopping_cart"], "product_id");

        // store value of product_size from session of shopping_cart in $item_array_size
        $item_array_size = array_column($_SESSION["shopping_cart"], "product_size");

        // check if the product_id and product_size is exits or not if one exits then execute
        if (!in_array($_GET["id"], $item_array_id) || !in_array($_POST["product_size"], $item_array_size)) {

            // store number of array in variable
            $count = count($_SESSION["shopping_cart"]);

            // store all the post data in array
            $item_array = array(
                'product_id'            =>    $_GET["id"],
                'product_img'            =>    $_POST["product_img"],
                'product_name'            =>    $_POST["product_name"],
                'product_size'            =>    $_POST["product_size"],
                'product_price'        =>    $_POST['product_price'],
                'quantity'        =>    $_POST["quantity"]
            );

            // give number to array by count number
            $_SESSION["shopping_cart"][$count] = $item_array;
        } else {
            echo '<script>alert("Item Already Added")</script>';
        }
    } else {
        $item_array = array(
            'product_id'            =>    $_GET["id"],
            'product_img'            =>    $_POST["product_img"],
            'product_name'            =>    $_POST["product_name"],
            'product_size'            =>    $_POST["product_size"],
            'product_price'        =>    $_POST["product_price"],
            'quantity'        =>    $_POST["quantity"]
        );
        // give 0 to first array
        $_SESSION["shopping_cart"][0] = $item_array;
    }
}

if (isset($_GET["action"])) {
    // if the click link is delete
    if ($_GET["action"] == "delete") {

        foreach ($_SESSION["shopping_cart"] as $keys => $values) {
            if ($values["product_id"] == $_GET["id"] && $values["product_size"] == $_GET["product_size"]) {
                unset($_SESSION["shopping_cart"][$keys]);
                echo '<script>alert("Item Removed")</script>';
                // Redirect to previous page
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
        }
    }
}

?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Bajracharya Tailoring</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="appointment.php">Appointment</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="shop.php">Shop</a>
                </li>
                <li class="nav-item dropdown"">
                    <?php
                    // check if user is login or not
                    if (isset($_SESSION['id'])) {
                        $user_data = check_login($con);

                        // check if user is admin or not
                        if ($user_data['role'] == "admin") { ?>
                            <a class=" nav-link" href="admin.php">
                    <!-- dispaly username of login user -->
                    <?php echo ucwords($user_data['username']); ?>
                    </a>
                <?php
                        } else {
                ?>
                    <a class="nav-link" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php echo ucwords($user_data['username']); ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                <?php }
                    } else {
                ?>
                <a class="nav-link" href="login.php">Profile</a>
            <?php } ?>
                </li>
                <li class="nav-item">
                    <a class="nav-link" style="cursor: pointer;" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                        <i class="fas fa-shopping-cart"></i>
                        <!-- show count of items added in cart -->
                        <?php if (isset($_SESSION["shopping_cart"])) { ?>
                            <span style="font-size: 10px;" class="badge bg-secondary">
                                <?php
                                $count = count($_SESSION["shopping_cart"]);
                                echo $count; ?>
                            </span>
                        <?php } ?>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Add to cart popup -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h3 id="offcanvasRightLabel" class="text-center"><strong>Add to Cart</strong></h3>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <?php
        // if shopping cart session is exit then it execute
        if (!empty($_SESSION["shopping_cart"])) {
        ?>
            <h5>Order Details</h5>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <th>Item Name</th>
                        <th>Size</th>
                        <th>Price</th>
                        <th></th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                    <?php
                    $total = 0;
                    $quantity = 0;
                    // store all the data in value in array form
                    foreach ($_SESSION["shopping_cart"] as $keys => $values) {
                    ?>
                        <tr>
                            <td><?php echo $values["product_name"]; ?></td>
                            <td><?php echo $values["product_size"]; ?></td>
                            <td>Rs. <?php echo $values["product_price"]; ?></td>
                            <td><?php echo $values["quantity"]; ?></td>
                            <td>Rs. <?php echo $values["quantity"] * $values["product_price"]; ?></td>
                            <td><a title="Remove" href="description.php?action=delete&id=<?php echo $values["product_id"]; ?>&product_size=<?php echo $values["product_size"]; ?>"><i class="fas fa-trash"></i></td>
                        </tr>
                    <?php
                        $total = $total + ($values["quantity"] * $values["product_price"]);
                        $quantity = $quantity + $values["quantity"];
                    }
                    ?>
                    <tr>
                        <td colspan="3" align="center">Total</td>
                        <td><?php echo $quantity; ?></td>
                        <td>Rs. <?php echo $total; ?></td>
                        <td></td>
                    </tr>
                </table>
            </div>
            <br><br>
            <div class="text-center">
                <form action="shop-now.php?action=cart" method="POST">
                    <input type="hidden" name="product_price" value="<?php echo $total; ?>">
                    <input type="hidden" name="quantity" value="<?php echo $quantity; ?>">
                    <button name="cartNow" class="btn btn-warning">Shop Now</button>
                </form>
            </div>
        <?php
        } else {
        ?>
            <div class="text-center" style="padding: 150px 0;">
                <h2>No items in</h2>
                <h2>add to cart</h2>
            </div>
        <?php
        }
        ?>
    </div>
</div>