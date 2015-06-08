<?php
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);
include 'private.php';
$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "burrellp-db", $myPassword, "burrellp-db");

$username = $_POST['new_username'];

//Query database for existence of desired username
$sql = "SELECT user_name FROM users WHERE user_name = '$username'";
$result = $mysqli->query($sql);
$rows = $result->num_rows;

//Availability result of username - data sent to check_username.js
if ($rows > 0) { //Username is taken 
    echo 'Unavailable';
  }else{
    echo 'Available'; //Username available
  }
?>