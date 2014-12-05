<?php
	function redirect_to ($location) {
	    if($location != NULL) {
	        header("Location: {$location}");
	        exit;
	    }
	}
	
	session_start();
	
	//2. Unset all the session variables
	$_SESSION = array();
	
	//3. Destroy te session cookie
	if(isset($_COOKIE[session_name()])) {
		setcookie(session_name(), '', time()-9001, '/');
	}
	
	//4. Destroy the session
	session_destroy();
	
	redirect_to("index.php");
?>