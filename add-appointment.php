<?php
session_start();
include 'connection.php';
include 'functions.php';

$user_data = check_login($con);

$location = $_GET["location"];

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (!empty($_POST['fullname']) && !empty($_POST['contact']) && !empty($_POST['adate']) && !empty($_POST['time'])) {

        $fullname = ucwords($_POST['fullname']);
        $username = $user_data['username'];
        $wedding = $_POST['wedding'];
        if (isset($_POST['contact'])) {
            $contact = $_POST['contact'];
            // count total digit
            $contactlen = strlen($contact);
            // store first 2 digit of contact
            $contact98 = $contact[0] . $contact[1];
            $contact01 = $contact[0] . "a" . $contact[1];
        }
        $adate = $_POST['adate'];
        $time = $_POST['time'];

        $query = "SELECT * FROM `appointment` WHERE `adate` = '$adate' and time = '$time'";
        $result = mysqli_query($con, $query);

        // check if fullname is numerical or not and fullname is alphabet or not
        if (!is_numeric($fullname) && preg_match("/^[a-z A-Z]*$/", $fullname)) {

            // check if contact is 9digit and start from 01 or contact is 10digit and start from 98
            if (($contact01 == "0a1" && $contactlen == 9) || ($contact98 == 98 && $contactlen == 10)) {

                // check if appointment in same date and time is exit or not
                if ($result && mysqli_num_rows($result) <= 0) {

                    $query = "INSERT INTO `appointment` (`fullname`, `username`, `wedding`, `contact`, `adate`, `time`,`status`) 
                VALUES ('$fullname', '$username', '$wedding', '$contact', '$adate', '$time', 'no')";

                    if (mysqli_query($con, $query)) {
                        $_SESSION['finished'] = 'Appointment Sucessful';
                        header("Location: index.php");
                        die;
                    } else {
                        $_SESSION['amsg'] = 'Fail to appoint';
                        header('Location:' . $location);
                        die;
                    }
                } else {
                    $_SESSION['amsg'] = 'Already booked in that time!';
                    header('Location:' . $location);
                    die;
                }
            } else {
                $_SESSION['amsg'] = 'Please enter valid contact number!';
                header('Location:' . $location);
                die;
            }
        } else {
            $_SESSION['amsg'] = 'Please enter valid Fullname!';
            header('Location:' . $location);
            die;
        }
    } else {
        $_SESSION['amsg'] = 'Please fill all input!';
        header('Location:' . $location);
        die;
    }
}
