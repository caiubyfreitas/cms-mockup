<?php

	require_once("../glb/controller.php");
	require_once("model/prospect.php");
	
	class ProspectController extends Controller{

		const MAX_PER_PAGE = 10;
		
		public function __construct(){
			parent::__construct();
		}
		
		public function __destruct(){
			parent::__destruct();
		}
				
		public function call($action, $params){
			return parent::call($action, $params);
		}
		
		public function getAllRecords($page = 1){
			$totalRecords = 0;
			$this->connect();
			$this->model = new Prospect($this->dbc);
			try{
				$totalRecords = $this->model->countRecords();
				if ($page > ceil($totalRecords / ProspectController::MAX_PER_PAGE) && $page > 1)
					$page--;
				$startAt = ( ($page - 1) * ProspectController::MAX_PER_PAGE);
				$rows = $this->model->getAllRecords($startAt);
				if (count($rows) === 0){
					$this->setResult(0, array(), 0, "Não há registros disponíveis.");
				}
				else{
					$this->setResult($totalRecords, $rows, $page, "");
				}
			}
			catch(Exception $e){
				$this->setResult(0, array(), 0, $e->getMessage());
			}
			finally{
				$this->model = NULL;
				$this->disconnect();
			}
		}
		
		public function remove(){
			$rowsAffected = 0;
			$this->connect();
			$this->model = new Prospect($this->dbc);
			try{
				$rowsAffected = $this->model->remove($this->params);
				$this->setResult($rowsAffected, array(), 0, "Registro removido.");
			}
			catch(Exception $e){
				$this->setResult(0, array(), $e->getMessage());
			}
			finally{
				$this->model = NULL;
				$this->disconnect();
			}
		}
		
		public function findById(){
			$row = NULL;
			$this->connect();
			$this->model = new Prospect($this->dbc);
			try{
				$row = $this->model->findById($this->params);
				$this->setResult(1, $row, "Registro encontrado.");
			}
			catch(Exception $e){
				$this->setResult(0, array(), $e->getMessage());
			}
			finally{
				$this->model = NULL;
				$this->disconnect();
			}			
		}
		
		
	}

?>