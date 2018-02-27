<?php

	namespace Globals\entities;
	
	require_once("helpers.php");
	use function Globals\helpers\cleanup_string;
	
	abstract class User{

		protected $dbc;
	
		/*
		General Attributes
		*/
		private $id; // primary key
		private $name; // user name for unique identification
		
		/*
		* Setters & Getters
		*/
		public function setID($id){
			$this->id = $id;
		}
		
		public function getID(){
			return $this->id;
		}
		
		public function setName($name){
			$this->name = cleanup_string($name);
		}
		
		public function getName(){
			return $this->name;
		}	
		
		public function setDBC(&$dbc){
			$this->dbc = $dbc;
		}
		
		/*
		* Sets entities attributes
		*/
		protected function __construct(){
		}
		
		/*
		* Base class destructor
		*/
		protected function __destruct(){
		}
		
		abstract protected function add();
		
		abstract protected function remove($id);
		
		abstract protected function findById($id);
		
		abstract protected function update($id);
		
	}
?>