//Username availability adapted from http://web.enavu.com/tutorials/checking-username-availability-with-ajax-using-jquery/
$(document).ready(function() {
	var checking_html = "checking availability";

	//Function runs when field is exited
	$('#new_username').change(function() {
		$('#user-result').html(checking_html);
		if ('#new_username')
		check_availability();
	});
});

function check_availability() {
	//Get and store username
	var username = $('#new_username').val();
	//Check availability if username is 6+ chars
	if (username.length > 5){
	//Run AJAX request to check availability
	$.post("checkAvailability.php", {'new_username': username}, 
		function(result){
			if(result == 'Available'){
				$('#user-result').html(username + ' is available');
				$('#user-result').css('color', 'green');
				$('#create_account')[0].disabled = false;
			}else {
				$('#user-result').html(username + ' is already taken');
				$('#user-result').css('color', 'red');
				$('#create_account')[0].disabled = true;
			}
		});	
	} else {
		$('#user-result').html("Username must be at least six characters");
		$('#user-result').css('color', 'red');
	}
}