<?php

	require_once("../glb/db.php");
	require_once("es_adminuser.php");
	
	use Globals\db\MySQLDBConnection;
	use function Globals\helpers\debug_to_console;

	$dbc = new MySQLDBConnection();
	try{
		$dbc->open();
		
		$user = new AdminUser();
		
		$user->setDBC($dbc);

		/*
		// Update a record
		$user->setName("aaaaaa");
		$user->setEmail("bbbbbb");
		$user->setPassword("ccccc");
		$user->update(521);
		*/
		
		/*
		// Delete a record
		$user->remove(525);
		*/
		
		/*
		// Find a record by primary key
		$user->findById(522);
		echo $user->getId();
		echo $user->getName();
		echo $user->getEmail();
		echo $user->getPassword();
		*/
		
		/*
		// Authenticate user
		$user->setName("cf5");
		$user->setPassword("chuchu");
		$stmt = "SELECT ID FROM USER WHERE NAME = :name AND PASSWORD = :password";
		$rows = $dbc->getRows($stmt, array("name" => $user->getName(), "password" => $user->getPassword()));
		echo $rows["ID"];
		echo empty($rows["ID"]);
		*/
		
		/*
		// Inserts a bunch of records
		for ($i=1; $i<10; $i++){
			$user->setName("cf".$i);
			$user->setEmail("cfreitas@test.com".$i);
			$user->setPassword("chuchu");
			$user->add();
		}
		*/
	}
	catch (Exception $e){
		debug_to_console($e->getMessage(), "Admin User Control Process:");		
	}
	finally{
		$dbc->close();
	}
	
	
?>