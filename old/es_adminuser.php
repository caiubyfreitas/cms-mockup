<?php

	require_once ("../glb/user.php");
	
	use Globals\entities\User as User;
	use function Globals\helpers\debug_to_console;
		
	class AdminUser extends User {

		/*
		Custom Attributes
		*/
		private $email; // email, must be unique
		private $pwd; // password for secured access
		private $fullName;
		private $picture;
		
		/*
		* Setters & Getters
		*/
		public function setFullName($string){
			$this->fullName = $string;
		}
		
		public function getFullName(){
			return $this->fullName;
		}
		
		public function setEmail($string){
			$this->email = $string;
		}
		
		public function getEmail(){
			return $this->email;
		}
		
		public function setPicture($string){
			$this->picture = $string;
		}
		
		public function getPicture(){
			return $this->picture;
		}
		
		public function setPassword($string){
			$this->pwd = crypt($string, "essencial");
		}
		
		public function getPassword(){
			return $this->pwd;
		}
		
		/*
		* Base class constructor
		*/
		public function __construct(){
			parent::__construct();
		}
		
		/*
		* Base class destructor
		*/
		public function __destruct(){
		}
		
		public function add(){
			$stmt = "INSERT INTO USER (ID, NAME, FULLNAME, EMAIL, PASSWORD) VALUES (NULL, :name, :fullName, :email, :password)";
			try{
				$this->dbc->beginTransaction();
				$this->dbc->execute($stmt, array("name" => $this->getName(), "fullName" => $this->getFullName(), "email" => $this->getEmail(), "password" => $this->getPassword()));
				$this->dbc->endTransaction();
			}
			catch(Exception $e){
				$this->dbc->cancelTransaction();
				throw $e;
			}
			finally{
			}
		}
		
		public function remove($id){
			$stmt = "DELETE FROM USER WHERE ID = :id";
			try{
				$this->dbc->beginTransaction();
				$this->dbc->execute($stmt, array("id" => $id));
				$this->dbc->endTransaction();
			}
			catch(Exception $e){
				$this->dbc->cancelTransaction();
				throw $e;
			}			
		}
		
		public function findById($id){
			$stmt = "SELECT ID, NAME, FULLNAME, EMAIL, PASSWORD, PICTURE FROM USER WHERE ID = :id";
			try{
				$rows = $this->dbc->getRows($stmt, array("id" => $id));
				if (!empty($rows["ID"])){
					$this->setID($rows["ID"]);
					$this->setName($rows["NAME"]);
					$this->setFullName($rows["FULLNAME"]);
					$this->setEmail($rows["EMAIL"]);
					$this->setPassword($rows["PASSWORD"]);
					$this->setPicture($rows["PICTURE"]);
				}
			}
			catch(Exception $e){
				throw $e;
			}			
		}
		
		public function exists(){
			$rows = array();
			$valid = false;
			$stmt = "SELECT ID, NAME, FULLNAME, EMAIL, PICTURE FROM USER WHERE NAME = :name AND PASSWORD = :password";
			try{
				$rows = $this->dbc->getRows($stmt, array("name" => $this->getName(), "password" => $this->getPassword()));
				$valid = (count($rows) > 0) ? true : false;
				if ($valid){
					$this->setID($rows[0]["ID"]);
					$this->setName($rows[0]["NAME"]);
					$this->setFullName($rows[0]["FULLNAME"]);
					$this->setEmail($rows[0]["EMAIL"]);
					$this->setPicture($rows[0]["PICTURE"]);
				}
			}
			catch(Exception $e){
				throw $e;
			}
			return $valid;
		}
		
		public function update($id){
			$stmt = "UPDATE USER SET NAME = :name, FULLNAME = :fullName, EMAIL = :email, PASSWORD = :password WHERE ID = :id";
			try{
				$this->dbc->beginTransaction();
				$this->dbc->execute($stmt, array("id" => $id, "name" => $this->getName(), "fullName" => $this->getFullName(), "email" => $this->getEmail(), "password" => $this->getPassword()));
				$this->dbc->endTransaction();
			}
			catch(Exception $e){
				$this->dbc->cancelTransaction();
				throw $e;
			}
			finally{
			}
		}
		
		public function getAllRecords()
		{
			$rows = array();
			$stmt = "SELECT ID, NAME, FULLNAME, EMAIL, PICTURE FROM USER ORDER BY 1 DESC";
			try{
				$rows = $this->dbc->getRows($stmt, array());
				return $rows;
			}
			catch(Exception $e){
				throw $e;
			}		
			finally{
				$this->dbc->close();
			}
		}
				
	}
	
?>