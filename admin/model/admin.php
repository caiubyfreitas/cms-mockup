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
			$valid = false;
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
	
	}
	
?>