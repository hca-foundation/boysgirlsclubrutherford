<?php

	// Error display
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

//////////////////////
// Class for handling DB Connections
//////////////////////
class pdo_dblib_mssql {
	private $db;
	private $cTransID;
	private $childTrans = array();

	public function __construct() {

		$GLOBALS['current_protocol'] = $GLOBALS['protocol'];
		$this->hostname = $GLOBALS['db_hostname'];
		$this->dbname = $GLOBALS['db_name'];
		$this->username = $GLOBALS['db_user'];
		$this->port = $GLOBALS['db_port'];
		$this->pwd = $GLOBALS['db_password'];
		
		// Get the domain to use as a variable
		if($_SERVER['SERVER_NAME'] == $GLOBALS['prod_domain']) {
			// Prod
			$GLOBALS['current_domain'] = $GLOBALS['prod_domain'];
		} else if($_SERVER['SERVER_NAME'] == $GLOBALS['qa_domain']) {
			// QA
			$GLOBALS['current_domain'] = $GLOBALS['qa_domain'];
		} else {
			// Dev (default)
			$GLOBALS['current_domain'] = $GLOBALS['dev_domain'];
		}
		$this->connect();
	}

	public function beginTransaction() {
		$cAlphanum = "AaBbCc0Dd1EeF2fG3gH4hI5iJ6jK7kLlM8mN9nOoPpQqRrSsTtUuVvWwXxYyZz";
		$this->cTransID = "T".substr(str_shuffle($cAlphanum), 0, 7);
		array_unshift($this->childTrans, $this->cTransID);
		$stmt = $this->db->prepare("BEGIN TRAN [$this->cTransID];");
		return $stmt->execute();
	}

	public function rollBack() {
		while(count($this->childTrans) > 0) {
			$cTmp = array_shift($this->childTrans);
			$stmt = $this->db->prepare("ROLLBACK TRAN [$cTmp];");
			$stmt->execute();
		}
		return $stmt;
	}

	public function commit() {
		while(count($this->childTrans) > 0){
			$cTmp = array_shift($this->childTrans);
			$stmt = $this->db->prepare("COMMIT TRAN [$cTmp];");
			$stmt->execute();
		}
		return  $stmt;
	}

	public function close() {
		$this->db = null;
	}
	
	public function connect() {
		try {
			$this->db = new PDO ($this->getConnectionString(), $this->username, $this->pwd);
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			echo "Failed to get DB handle: " . $e->getMessage() . "\n";
		}
	}

	public function getConnectionString() {
		$driver = $GLOBALS['db_driver'];
		$connectionString = '';

		// TODO: add support for additional db drivers?
		switch ($driver) {
			case 'mysql':
				$connectionString = "mysql:host=$this->hostname;dbname=$this->dbname;port=$this->port";
				break;
			default: // defaults to MS SQL Server
				$connectionString = "sqlsrv:Server=$this->hostname,$this->port;Database=$this->dbname";
				break;
		}

		return $connectionString;
	}
	
	public function executeStatement($query, $values) {
		$stmt = $this->db->prepare($query);
		if(sizeOf($values) == 0) {
			$stmt->execute();
		} else {
			$stmt->execute($values);
		}
		if (strpos($query, 'INSERT') !== false) {
			$stmt = $this->db->lastInsertId();
		}
		return $stmt;
	}
}
?>