<?php
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);
session_start();
include 'private.php';

$username = $_SESSION['username'];
//Check for login submission
if (isset($_SESSION['username'])){
	$username = $_SESSION['username'];
	//Get user_id of current user
	$mysqli2 = new mysqli("oniddb.cws.oregonstate.edu", "burrellp-db", $myPassword, "burrellp-db");
	$userQuery = "SELECT user_id FROM users WHERE user_name = '$username'";
	$userArr = $mysqli2->query($userQuery);
	$row = $userArr->fetch_assoc();
	$id = $row['user_id'];
	
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
}
?>

<h2>Welcome <?php echo $username?>!</h2>
	<div id="addBeer">
		<h3>Tried a new beer? Add it to your list</h3>
		<form id="addBeer" action="addBeer.php" method="POST">
			Style of Beer<input name="style" type="text"><br>
			Name of Brewery<input name="brewery" type="text" required="required"><br>
			Name of Beer<input name="beer" type ="text" required="required"><br>
			Your Rating (0.0-5.0)<input name="rating" type="number" required="required"><br>
			Add comment<textarea name="comment"></textarea>
			<input type="submit" id="addNow" value="Add Beer" disabled>
		</form>
	</div>
	  <h3>Your Beers</h3>
	  <table border = "1">
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
</table>
	<h3>See What Other Users Have Been Drinking</h3>
	<table border = "1">
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
