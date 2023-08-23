   <?php
    session_start();
    include 'connection.php';
    // restore previous loaction
    $location = $_GET["location"];

    // check from contact
    if (isset($_GET["cid"])) {
        $cid = $_GET["cid"];
        // delete
        $csql = "DELETE FROM contact WHERE cid=$cid";

        //  display msg if the delete process done
        if (mysqli_query($con, $csql)) {
            $_SESSION['cerror'] = "Deleted Successfully.";
            header('Location:' . $location);
        } else {
            $_SESSION['cerror'] = "Error deleting record: " . mysqli_error($con);
        }
    }


    // check form account
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        // delete
        $sql = "DELETE FROM users WHERE id=$id";

        // display msg if the delete process done
        if (mysqli_query($con, $sql)) {
            $_SESSION['message'] = "Deleted Successfully.";
            header('Location:' . $location);
        } else {
            $_SESSION['message'] = "Error deleting record: " . mysqli_error($con);
        }
    }

    // check form upload
    if (isset($_GET["product_id"])) {
        $product_id = $_GET["product_id"];
        // delete
        $sql = "DELETE FROM upload WHERE product_id=$product_id";

        // display msg if the delete process done
        if (mysqli_query($con, $sql)) {
            $_SESSION['umsg'] = "Deleted Successfully.";
            header('Location:' . $location);
        } else {
            $_SESSION['umsg'] = "Error deleting record: " . mysqli_error($con);
        }
    }

    // check from shop
    if (isset($_GET["sid"])) {
        $sid = $_GET["sid"];
        // delete
        $sql = "DELETE FROM shop WHERE sid=$sid";

        // display msg if the delete process done
        if (mysqli_query($con, $sql)) {
            $_SESSION['smsg'] = "Deleted Successfully.";
            header('Location:' . $location);
        } else {
            $_SESSION['smsg'] = "Error deleting record: " . mysqli_error($con);
        }
    }

    // check from appointment
    if (isset($_GET["aid"])) {
        $aid = $_GET["aid"];
        // delete
        $sql = "DELETE FROM appointment WHERE aid=$aid";

        // display msg if the delete process done
        if (mysqli_query($con, $sql)) {
            $_SESSION['amsg'] = "Deleted Successfully.";
            header('Location:' . $location);
        } else {
            $_SESSION['amsg'] = "Error deleting record: " . mysqli_error($con);
        }
    }
    ?>
