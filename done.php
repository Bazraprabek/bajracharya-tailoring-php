<?php
session_start();
include 'connection.php';

// restore previous loaction
$location = $_GET["location"];

// Execute if shop id exist
if (isset($_GET["sid"])) {
    $sid = $_GET["sid"];

    // upaate status value from no to yes
    $query = "UPDATE `shop` SET
        status = 'on'
        WHERE sid='$sid'
        ";

    //  display msg if the delivered process done or else display error message
    if (mysqli_query($con, $query)) {
        // $_SESSION['smsg'] = "Delivered Successfully.";
        header('Location:' . $location);
    } else {
        $_SESSION['smsg'] = "Error : " . mysqli_error($con);
    }
}

// Execute if shop id exist
if (isset($_GET["oid"])) {
    $sid = $_GET["oid"];

    // upaate status value from no to yes
    $query = "UPDATE `shop` SET
        status = 'yes'
        WHERE sid='$sid'
        ";

    //  display msg if the delivered process done or else display error message
    if (mysqli_query($con, $query)) {
        $_SESSION['smsg'] = "Delivered Successfully.";
        header('Location:' . $location);
    } else {
        $_SESSION['smsg'] = "Error : " . mysqli_error($con);
    }
}

// Execute if appointment id exist
if (isset($_GET["aid"])) {
    $aid = $_GET["aid"];

    // upaate status value from no to yes
    $query = "UPDATE `appointment` SET
        status = 'yes'
        WHERE aid='$aid'
        ";

    //  display msg if the delivered process done or else display error message
    if (mysqli_query($con, $query)) {
        $_SESSION['amsg'] = "Appointment Finished Successfully.";
        header('Location:' . $location);
    } else {
        $_SESSION['amsg'] = "Error : " . mysqli_error($con);
    }
}

