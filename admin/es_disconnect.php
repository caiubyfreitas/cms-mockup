<?php 

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
	
	// redirect to login page 
	$host = $_SERVER["HTTP_HOST"];
	$uri  = rtrim(dirname($_SERVER["PHP_SELF"]), "\//") . "/";
	$page = "es_login.html";
	header("Location: http://$host$uri$page");	
	
?>