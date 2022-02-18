<?php
//print_r($_REQUEST);

$first_name = $_POST["first_name"];
$last_name = $_POST["last_name"];
$pie_flavor = $_POST["flavor"];
$quantity = $_POST["quantity"];

if($quantity > 4 || $quantity < 1)
{
    die("Invalid quantity specified!");
}


echo "Thank you " . $first_name . " " . $last_name . "!  You ordered " . $quantity . " " . $pie_flavor . "pie(s).";