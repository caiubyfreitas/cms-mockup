<?php

	require_once("../glb/db.php");

	class Prospect{
	
		private $dbc;

		public function __construct($dbc){
			$this->dbc = $dbc;
		}
		
		public function __destruct(){
		}
		
		public function countRecords(){
			$records = 0;
			$stmt = "SELECT COUNT(0) FROM PROSPECT";
			try{
				$records = $this->dbc->countRecords($stmt);
			}
			catch(Exception $e){
				throw $e;
			}		
			finally{
			}
			return $records;
		}

		public function getAllRecords($startAt){
			$records = 0;
			$rows = array();
			$stmt = "SELECT ID, NAME, EMAIL FROM PROSPECT ORDER BY 1 DESC LIMIT 10 OFFSET " . ($startAt);
			try{		
				$rows = $this->dbc->getRows($stmt, array());
			}
			catch(Exception $e){
				throw $e;
			}		
			finally{
			}
			return $rows;
		}
		
		public function remove($params){
			$rowsAffected = 0;
			$stmt = "DELETE FROM PROSPECT WHERE ID = :id";
			try{
				$this->dbc->beginTransaction();
				$rowsAffected = $this->dbc->execute($stmt, array("id" => $params["id"]));
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
		
		public function findById($params){
			$row = NULL;
			$stmt = "SELECT ID, NAME, EMAIL FROM PROSPECT WHERE ID = :id";
			try{
				$row = $this->dbc->getRows($stmt, array("id" => $params["id"]));
			}
			catch(Exception $e){
				throw $e;
			}
			finally{
			}
			return $row;
		}
		
	
	}
	
?>