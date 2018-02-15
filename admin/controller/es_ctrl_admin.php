<?php

	require_once("../glb/controller.php");
	require_once("model/admin.php");
	
	class AdminController extends Controller{
		
		public function __construct(){
			parent::__construct();
		}
		
		public function __destruct(){
			parent::__destruct();
		}
				
		public function call($action, $params){
			return parent::call($action, $params);
		}
		
		public function validate(){
			$this->connect();
			$this->model = new Admin($this->dbc);
			try{
				$row = $this->model->validate($this->params);
				if (isset($row[0]["ID"])){
					if (version_compare(phpversion(), '5.4.0', '<')) {
						if(session_id() == ''){
							session_start();
						}
					}
					else{
						if (session_status() == PHP_SESSION_NONE){
							session_start();
						}
					}					
					$_SESSION["USER_ID"] = $row[0]["ID"];
					$_SESSION["FULLNAME"] = $row[0]["FULLNAME"];
					$_SESSION["PICTURE"] = $row[0]["PICTURE"];
					$this->setResult(1, $row, 0, "Registro encontrado.");
				}
				else{
					throw new Exception("Credenciais inválidas.");
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
		
		public function findById(){
			$this->connect();
			$this->model = new Admin($this->dbc);
			try{
				$row = $this->model->findById($this->params);
				$this->setResult(1, $row, 0, $this->params);
			}
			catch(Exception $e){
				$this->setResult(0, array(), 0, $e->getMessage());
			}
			finally{
				$this->model = NULL;
				$this->disconnect();
			}
		}
		
		public function update(){
			$rowsAffected = 0;
			$this->connect();
			$this->model = new Admin($this->dbc);
			try{
				$rowsAffected = $this->model->update($this->params);
				$this->setResult($rowsAffected, array(), 0, "Registro atualizado.");
			}
			catch(Exception $e){
				$this->setResult(0, array(), 0, $e->getMessage());
			}
			finally{
				$this->model = NULL;
				$this->disconnect();
			}
		}
	}

?>