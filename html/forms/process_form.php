<?php

    $first_name = $_POST['fname'];
    $last_name = $_POST['lname'];
    $address = $_REQUEST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zipcode = $_POST['zipcode'];
    $pie = $_POST['pie'];
    $quantity = $_POST['quantity'];


    echo "Hi $first_name $last_name!  We'll be sending $quantity $pie pie(s) to your address in the state of $state.";
?>