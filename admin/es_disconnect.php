<?php 

	// Purge all session data so that a new log in will be required to access the system.   
	if (version_compare(phpversion(), '5.4.0', '<')) {
		if(session_id() == ''){
			session_start();
		}
	}
	else{
		if (session_status() == PHP_SESSION_NONE){
			session_start();
		}
	}
	session_destroy();
		
	// Redirect user to renew authentication
	require_once ("../glb/helpers.php");
	use function Globals\helpers\redirect;
	redirect("es_login.html");
	
?>