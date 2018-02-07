<?php
	namespace Globals\db;
	
	/******************************************************************************************************************
	* DBConnection class
	* January 1st, 2018
	* By Caiuby Freitas
	*
	* Base class to handle a database connection
	* Instruction for use:
	* This class should not be instantiated. It's purpose it to provide a common set of functions 
	* to connect to any database supported via PDO, as follows:
	* CUBRID, MS SQL Server, Firebird, IBM, Informix, MySQL, MS SQL Server, Oracle, ODBC and DB2, PostgreSQL, SQLite, 4D
	*/
	class DBConnection{
		
		protected $dbc; // database connection handler
		protected $dsn; // data source name
		protected $user; // database user name
		protected $password; // database user password
		
		/*
		* Base class Constructor
		*/	
		protected function __construct(){
			$this->dbc = NULL;
			$this->dsn = "";
			$file = parse_ini_file("config.ini");
			$this->dsn = "mysql:host=" . $file["host"] . ";dbname=" . $file["db"] . ";charset=utf8mb4";
			$this->user = $file["user"];
			$this->password = $file["pwd"];
		}
		
		/*
		* Base class destructor
		*/	
		protected function __destruct(){
			$this->close();
		}
		
		/*
		* Retrieves database connection configuration
		*
		* @return data used to create a PDO connection string
		*/	
		public function getConnectionString(){
			return $this->dsn . ", username: " . $this->user . ", password: " . $this->password;
		}
		
		/*
		* Opens a connection to the database
		*
		* @return throw exception customized error message
		*/	
		protected function open(){
			if ($this->dbc === NULL){
				if (!empty($this->dsn)){
					try{
						$this->dbc = new \PDO($this->dsn, $this->user, $this->password, array(\PDO::ATTR_PERSISTENT => true, \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC, \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"));
						$this->dbc->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION); //turn on feedback by exception
					}
					catch(PDOException $e){
						throw new Exception("at line " . __LINE__ . ": " . $e->getMessage());
					}
				}
			}
		}
		
		/*
		* Creates a transaction context for current connection
		*/
		protected function beginTransaction(){
			if ($this->dbc !== NULL){
				$this->dbc->beginTransaction();
			}
		}

		/*
		* Ends the current transaction context
		*/
		protected function endTransaction(){
			if ($this->dbc !== NULL){
				$this->dbc->commit();
			}
		}
		
		/*
		* Cancel the current transaction context
		*/
		protected function cancelTransaction(){
			if ($this->dbc !== NULL){
				$this->dbc->rollBack();
			}
		}
		
		/*
		* Runs a INSERT, UPDATE and DELETE commands
		*
		* @returns number of records affected
		*/	
		protected function execute($stmt, array $data){
			$rowsAffected = 0;
			if ($this->dbc !== NULL){
				try{
					$cmd = $this->dbc->prepare($stmt);
					$cmd->execute($data);
					$rowsAffected = $cmd->rowCount();
				}
				catch (PDOException $e){
					echo "at line " . __LINE__ . ": " . $e->getMessage();
				}
				finally{
					$cmd = NULL;
				}
			}
			return $rowsAffected;
		}
		
		/*
		* Runs a SELECT query
		*
		* @returns array with all matching records
		*/	
		protected function getRows($stmt, array $data){
			$rows = array();
			if ($this->dbc !== NULL){
				try{
					$cmd = $this->dbc->prepare($stmt);
					$cmd->execute($data);
					$rows = $cmd->fetchAll();
					$rowsAffected = $cmd->rowCount();
				}
				catch (PDOException $e){
					echo "at line " . __LINE__ . ": " . $e->getMessage();
				}
				catch (Exception $e){
					throw $e;
				}
				finally{
					$cmd = NULL;
				}
			}
			return $rows;
		}

		protected function countRecords($stmt){
			$records = 0;
			if ($this->dbc !== NULL){
				try{			
					$records = $this->dbc->query($stmt)->fetchColumn();
				}
				catch (Exception $e){
					throw $e;
				}
				finally{
				}
			}
			return $records;
		}

		
		/*
		* Closes the current database connection
		*/	
		protected function close(){
			if ($this->dbc !== NULL){
				$this->dbc = NULL;
			}
		}
		
	}

	/******************************************************************************************************************
	* MySQLDBConnection class
	* January 1st, 2018
	* By Caiuby Freitas
	* 
	* Derived class to handle connections to mySQL using PDO
	*/
	class MySQLDBConnection extends DBConnection{

		/*
		* Class constructor
		*/	
		public function __construct(){ 
			parent::__construct();
		}
		
		/*
		* Opens a database connection
		*
		* @returns exception fired
		*/	
		public function open(){
			try{
				parent::open();
			}
			catch(Exception $e){
				throw $e;
			}
		}
				
		/*
		* Runs a INSERT, UPDATE and DELETE commands
		*
		* @returns number of records affected
		*/	
		public function execute($stmt, array $data){
			return parent::execute($stmt, $data);
		}

		/*
		* Runs a SELECT query
		*
		* @returns array with all matching records
		*/		
		public function getRows($stmt, array $data){
			return parent::getRows($stmt, $data);
		}
		
		/*
		* Creates a transaction context for current connection
		*/		
		public function beginTransaction(){
			parent::beginTransaction();			
		}

		/*
		* Ends the current transaction context
		*/		
		public function endTransaction(){
			parent::endTransaction();
		}
		
		/*
		* Cancel the current transaction context
		*/		
		public function cancelTransaction(){
			parent::cancelTransaction();
		}
		
		/*
		* Closes current database connection
		*/	
		public function close(){
			parent::close();
		}
		
		public function countRecords($stmt){
			return parent::countRecords($stmt);
		}
		
		/*
		* Destructor class
		*/	
		public function __destruct(){
			parent::__destruct();
		}
		
	}
	
?>