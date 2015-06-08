<?php
ob_start();
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);
ini_set('display_startup_errors', TRUE);
ini_set("log_errors",true);
ini_set("html_errors",false);
ini_set("error_log","/var/log/php_error_log");
include 'private.php';

$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "burrellp-db", $myPassword, "burrellp-db");

if (!isset($_POST['new_username'])){
	header("Location: registration.html");
}

$username = $_POST['new_username'];   
$password = $_POST['new_password'];
$username = $mysqli->real_escape_string($username);	   	//Escape special characters
$hash = password_hash($password, PASSWORD_DEFAULT);   	//hash password

//Begin session connected to username
session_start();
$_SESSION["username"] = $username;

//add user to table
$add_user = "INSERT INTO users (user_name, password) VALUES ('$username', '$hash')";
$mysqli->query($add_user);
//header("Location: welcomePage.php");
header("Location: homePage.html");
?>