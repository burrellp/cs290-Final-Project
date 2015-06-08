<?php
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);
session_start();
include 'private.php';

if (!isset($_SESSION['username'])) {
	header("Location: login.php");
}

$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html>
  <head>
  	<title>User Home Page</title>
  	<link rel="stylesheet" type="text/css" href="style.css">
  </head>
<body>
	<div id="banner">Drink, Drank, Drunk It</div>
	<div>
	  <h2 id="welcome">Welcome <?php echo $username?>!</h2>
    <form id="logOutForm" method="GET" action="login.php">
    	<p><a href="login.php?status=loggedOut">Logout</a>
    </div>
	<div>
		<h3>Tried a new beer? Add it to your list</h3>
		<form id="addBeer" action="addBeer.php" method="POST">
			Style of Beer<input name="style" type="text">
			Name of Brewery<input name="brewery" type="text" required="required">
			Name of Beer<input name="beer" type ="text" required="required"><br><br>
			Your Rating (0.0-5.0)<input name="rating" type="number" required="required" min="0" max = "5">
			Add comment<textarea name="comment"></textarea>
			<input type="submit" id="addNow" value="Add Beer" onclick="updateInfo()">
		</form>
	</div>
	<div id="updateArea"></div>
	  <script>
	function updateInfo() {
		if (window.XMLHttpRequest) {
			xmlhttp = new XMLHttpRequest();
		}
		else {
			xmlhttp = new ActiveXObject("Microsof.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				document.getElementById("updateArea").innerHTML = xmlhttp.responseText;
			}
		}
		xmlhttp.open("POST", "addBeer.php");
		xmlhttp.send();
	}
	window.onload = updateInfo;
	</script>
</body>
