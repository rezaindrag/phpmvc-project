<?php

/**
 * PDO Database Class
 *
 * Connect to database
 * Create prepared statements
 * Bind values
 * Return rows and results
 */
Class Database {
	private $host = DB_HOST;
	private $user = DB_USER;
	private $pass = DB_PASS;
	private $dbname = DB_NAME;
	
	// db handler
	private $dbh;
	// statement
	private $stmt;
	private $error;

	public function __construct() {
		$dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
		$options = array(
			PDO::ATTR_PERSISTENT => true, // ?
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION // error mode
		);

		try {
			$this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
		} catch(PDOException $e) {
			$this->error = $e->getMessage();
			echo $this->error;
		}
	}

	// Prepare statement with query
	public function query($sql) {
		$this->stmt = $this->dbh->prepare($sql);
	}

	// Bind values
	public function bind($params, $value, $type = null) {
		// if $type is null
		if (!is_null($type)) {
			switch (true) {
				// if $value is integer
				case is_int($value):
					// set attribute for type
					$type = PDO::PARAM_INT;
					break;

				// if $value is boolean
				case is_bool($value):
					$type = PDO::PARAM_BOOL;
					break;

				// if $value is null
				case is_null($value):
					$type = PDO::PARAM_NULL;
					break;
				
				// if $value is string
				default:
					$type = PDO::PARAM_STR;
			}
		}

		$this->stmt->bindValue($params, $value, $type);
	}

	// Execute the prepared statement
	public function execute() {
		return $this->stmt->execute();
	}

	// Get result as object
	public function results() {
		$this->execute();
		return $this->stmt->fetchAll(PDO::FETCH_OBJ);
	}

	// Get single result as object
	public function result() {
		$this->execute();
		return $this->stmt->fetch(PDO::FETCH_OBJ);
	}

	// Get row count
	public function rowCount() {
		return $this->stmt->rowCount();
	}
}