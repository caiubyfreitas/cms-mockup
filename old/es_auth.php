<?php

	require_once("es_AdminUser.php");
	require_once("../glb/db.php");
	
	$errors = array();
	$return = array();
	
	if (empty($_POST["fldName"])){
		$errors["fldName"] = "Informe seu nome de usuario.";
	}
	
	if (empty($_POST["fldPassword"])){
		$errors["fldPassword"] = "A senha de acesso deve ser informada.";
	}
	
	// if there are any errors in our errors array, return a success boolean of false
    if (!empty($errors)) {

        // if there are items in our errors array, return those errors
        $return["errors"]  = $errors;
    }
	else{
		
		$user = new AdminUser();
		$user->setName($_POST["fldName"]);
		$user->setPassword($_POST["fldPassword"]);

		$dbc = new Globals\db\MySQLDBConnection();
		$dbc->open();
		try{
			$user->setDBC($dbc);
			if (!$user->exists()){
				$return["message"] = "Credenciais Inválidas.";
			}
			else{
				session_start();
				$_SESSION["USER_ID"] = $user->getId();
				$_SESSION["FULLNAME"] = $user->getFullName();
				$_SESSION["PICTURE"] = $user->getPicture();
			}
		}
		catch(Exception $e){
			throw $e;
		}
		finally{
			$dbc->close();
		}
		
	}
	echo json_encode($return);
	
?>