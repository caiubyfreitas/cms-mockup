<?php
	
	// Read data package parameters
	$action = isset($_POST["action"]) ? $_POST["action"] : "";
	$module = isset($_POST["module"]) ? $_POST["module"] : "";
	$params	= isset($_POST["params"]) ? $_POST["params"] : "";

	// Select the proper controller to instantiate
	switch($module){
		case "G01":
			require_once("controller/es_ctrl_admin.php");
			$controller = new AdminController();
			break;
		case "prospects":
			require_once("controller/es_ctrl_prospects.php");
			$controller = new ProspectController();
			break;
	}
	
	// Call on-demand instantiated controller
	$return = $controller->call($action, $params);
	
	echo json_encode($return);

?>