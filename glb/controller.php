<?php

	class Controller
	{
		protected $dbc = NULL;
		protected $model = NULL;
		protected $action;
		protected $params;
		protected $dataSet = array();		

		protected function __construct(){
			$this->dataSet["RECORDS"] = 0;
			$this->dataSet["ROWS"] = array();
			$this->dataSet["MESSAGE"] = "";
		}
		
		protected function __destruct(){
			$this->dataSet = array();
			$this->model = NULL;
		}		
		
		protected function connect(){
			$this->dbc = new Globals\db\MySQLDBConnection();
			$this->dbc->open();
		}

		protected function disconnect(){
			$this->dbc->close();
		}
		
		protected function call($action = "", $params){
			$this->action = $action;
			$this->params = $params;
			if (method_exists($this, $action)){
				$this->$action($params);
			}
			return $this->dataSet;
		}
		
		public function setResult($records = 0, $rows = array(), $currentPage = 1, $message = ""){
			$this->dataSet["RECORDS"] = $records;
			$this->dataSet["ROWS"] = $rows;	
			$this->dataSet["CURRPAGE"] = $currentPage;
			$this->dataSet["MESSAGE"] = $message;
		}

	}
	
?>