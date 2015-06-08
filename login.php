<?php
ob_start();
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'private.php';
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Login Page</title>
    <link rel="stylesheet" type="text/css" href="style.css">
  </head>
  <div id="banner">Drink, Drank, Drunk It</div>
  <h1>Welcome Back to Drink, Drank, Drunk It!</h1>
  <h2>Your home for all of your drink rating and tracking needs</h2>
  <body><h3>Enter your username and password to login<h3>
    <form id="login" action="login.php" method="post">
      <input style="display:none" type="text" name="fakeusernameremembered"/>
      Username: <input type="text" name="username" required="required"><br><br>
      <input style="display:none" type="password" name="fakepasswordremembered"/>
      Password: <input type="password" name="password" required="required"><br><br>
      <button id="submit" name="submit">Login</button>
    </form>
    <h3>Don't have an account yet? Register <a href="registration.html">here.</a></h3>
  </body>
 </html>
<?php
//User has clicked login button
if (isset($_POST['submit'])){
	$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "burrellp-db", $myPassword, "burrellp-db");
	$username = $_POST['username'];   
	$password = $_POST['password'];
	$username = $mysqli->real_escape_string($username);	   	//Escape special characters
	$hash = password_hash($password, PASSWORD_DEFAULT);   	//hash password
	//$rows > 0 means username is valid
	$sql = "SELECT * FROM users WHERE user_name = '$username'";
	$result = $mysqli->query($sql);
	$rows = $result->num_rows;
	if ($rows > 0) {
		$row = $result->fetch_assoc();
		//verify that correct password was entered
		if (password_verify($password, $row['password'])){
			$_SESSION["username"] = $username;
			//header("Location: welcomePage.php");
			header("Location: homePage.php");
		}else {
			echo '<p>Incorrect password. Please try again.';
		}
	}else {
		echo '<p>That information does not match our user records. Please check your <br>'.
		 'username and password and try again or click <a href="registration.html">here</a><br>'.
		 'to create a new account.';
	}
}

//Session terminating/resetting code adapted largely from session.php lecture code
//Run the following if user has logged out of session
if(isset($_GET["status"]) && $_GET["status"] == "loggedOut") {
	$_SESSION = array();	//Clear session array
	session_unset();
	session_destroy();		//Destroy session data
	//Redirect user back to login page
	$filePath = explode('/', $_SERVER['PHP_SELF'], -1);
	$filePath = implode('/',$filePath);
	$redirect = "http://" . $_SERVER['HTTP_HOST'] . $filePath;
	header("Location: {$redirect}/login.php", true);
	die();
}



?>

  

