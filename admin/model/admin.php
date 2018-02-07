<?php

	require_once("../glb/db.php");

	class Admin{
	
		private $dbc;

		public function __construct($dbc){
			$this->dbc = $dbc;
		}
		
		public function __destruct(){
		}
		
		private function encrypt($string){
			return crypt($string, "essencial");
		}
		
		public function validate($params){	
			$row = NULL;
			$stmt = "SELECT ID, NAME, FULLNAME, EMAIL, PICTURE FROM USER WHERE NAME = :name AND PASSWORD = :password";
			try{
				$row = $this->dbc->getRows($stmt, array(
					"name" => $params["fldName"], 
					"password" => $this->encrypt($params["fldPassword"])
				));
			}
			catch(Exception $e){
				throw $e;
			}
			return $row;
		}
		
		public function readRecord($params){
			$row = NULL;
			$stmt = "SELECT NAME, FULLNAME, EMAIL FROM USER WHERE ID = :id";
			try{
				$row = $this->dbc->getRows($stmt, array( "id" => $params["id"] ));
			}
			catch(Exception $e){
				throw $e;
			}
			finally{
			}
			return $row;
		}
		
		public function updateRecord($params){
			$rowsAffected = 0;
			$stmt = "UPDATE USER SET FULLNAME = :fullname, NAME = :name, EMAIL = :email, PASSWORD = :password WHERE ID = :id";
			try{
				$this->dbc->beginTransaction();
				$rowsAffected = $this->dbc->execute($stmt, array(
					"id" => $params["id"],
					"fullname" => $params["fullname"],
					"name" => $params["name"],
					"email" => $params["email"],
					"password" => $this->encrypt($params["password"])
				));
				$this->dbc->endTransaction();
			}
			catch(Exception $e){
				$this->dbc->cancelTransaction();
				throw $e;
			}
			finally{
			}
			return $rowsAffected;
		}
	
	}
	
?>