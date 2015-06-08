<?php
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);
session_start();
include 'private.php';

//Check for login submission
$username = $_SESSION['username'];

//Get user_id of current user
$mysqli2 = new mysqli("oniddb.cws.oregonstate.edu", "burrellp-db", $myPassword, "burrellp-db");
$userQuery = "SELECT user_id FROM users WHERE user_name = '$username'";
$userArr = $mysqli2->query($userQuery);
$row = $userArr->fetch_assoc();
$id = $row['user_id'];

//Store all beer information from post form if posted
//Rating is required, so all will be posted if it is
if (isset($_POST['rating'])){
	$style = $_POST['style'];
	$brewery = $_POST['brewery'];
	$beer = $_POST['beer'];
	$rating = $_POST['rating'];
	$comment = $_POST['comment'];

	$mysqli3 = new mysqli("oniddb.cws.oregonstate.edu", "burrellp-db", $myPassword, "burrellp-db");

	$addBeer = "INSERT INTO beers".
	"(id, style, brewery, name, rating, comment)".
	"VALUES ".
	"('$id', '$style', '$brewery', '$beer', '$rating', '$comment')";

	$mysqli3->query($addBeer);

	//mysqli_close();
}

$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "burrellp-db", $myPassword, "burrellp-db");

if(!$mysqli || $mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (". $mysqli->error . ")" . $mysqli->connect_error;
 }
//Set up prepared statement for displaying videos and test for success
if(!$stmt = $mysqli->prepare("SELECT id, style, brewery, name, rating, comment FROM beers")) {
	echo "Prepare failed: (" . $mysqli->error . ")" . $mysqli->error;
}
//Bind results and test for success
if(!$stmt->bind_result($bId, $style, $brewery, $name, $rating, $comment)) {
	echo "Binding results failed: (" . $stmt->errno . ")" . $stmt->error;
}
//Execute statment and test for success
if(!$stmt->execute()) {
	echo "Execute failed: (" . $stmt->errno . ")" . $stmt->error;
}
?>
<h3>Your Beers</h3>
	  <table border = "1" class="center">
	  	<tr>
        <td>Style</td>
      	<td>Brewery</td>
      	<td>Beer Name</td>
      	<td>Rating (0-5)</td>
      	<td>Comment</td>
      </tr>
<?php
//Add user beer data to table
$result = $stmt->get_result();
while ($rowArr = $result->fetch_assoc()) {
	if ($rowArr['id'] == $id){
		echo "<tr><td>".$rowArr['style']."</td>";
		echo "<td>".$rowArr['brewery']."</td>";
		echo "<td>".$rowArr['name']."</td>";
		echo "<td>".$rowArr['rating']."</td>";
		echo "<td>".$rowArr['comment']."</td>";
		//Button to edit beer information
		//echo "<td><form action='editBeer.php' method='POST id='".$name."'><button type='submit;"
	}
}
?>
</table >
	<h3>See What Other Users Have Been Drinking</h3>
	<table border="1" class="center"
	  	<tr>
        <td>Style</td>
      	<td>Brewery</td>
      	<td>Beer Name</td>
      	<td>Rating (0-5)</td>
      	<td>Comment</td>

<?php
//$result2 = $stmt->get_result();
$result->data_seek(0);
while ($rowArr = $result->fetch_assoc()) {
	if ($rowArr['id'] != $id){
		echo "<tr><td>".$rowArr['style']."</td>";
		echo "<td>".$rowArr['brewery']."</td>";
		echo "<td>".$rowArr['name']."</td>";
		echo "<td>".$rowArr['rating']."</td>";
		echo "<td>".$rowArr['comment']."</td>";
	}
}
?>