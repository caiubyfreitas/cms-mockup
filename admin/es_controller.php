<?php
	
	/*
	* CONTROLLER HANDLER
	* jan-2018
	* By Caiuby Freitas
	*
	* This module works as middle layer between view and model abstractions by handing the action required down to the specific controller.
	*
	* Addition of new data groups should start here by defining the associated controller.
	* The name of the module may follow any naming conventions, but for every new module there must be
	* correspondent model and view physical file, so that any further implementation stays loosely coupled.
	*/
		
	// Read data package parameters
	$module = isset($_POST["module"]) ? $_POST["module"] : "";
	$action = isset($_POST["action"]) ? $_POST["action"] : "";
	$params	= isset($_POST["params"]) ? $_POST["params"] : "";

	// Select the proper controller to instantiate
	switch($module){
		case "Admin":
			require_once("controller/es_ctrl_admin.php");
			$controller = new AdminController();
			break;
		case "Prospect":
			require_once("controller/es_ctrl_prospects.php");
			$controller = new ProspectController();
			break;
	}
	
	// Call on-demand instantiated controller
	$return = $controller->call($action, $params);
	
	echo json_encode($return);

?>