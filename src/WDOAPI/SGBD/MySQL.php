<?php

	namespace WDOAPI\SGBD;

	Class MySQL extends Settings {

		public $debug;
		public $conn;

		public function __construct( $debug = false ){

			$this->debug = $debug;
			$this->connect();

		}

		private function connect(){

			$this->conn = @mysqli_connect( $this->mysqlHostname , $this->mysqlUsername, $this->mysqlPassword, $this->mysqlDb );

			if (!$this->conn) {
			    echo "Error: " . mysqli_connect_error();
				die();
			}

		}

		public function getConnect(){

			return $this->conn;

		}

		public function execQuery( $sql ){

			// Execute SQL
			if(mysqli_query( $this->conn , $sql )){
			    // echo "Records inserted successfully.";
			    return [
			    	'cod' => 200,
			    ];
			    
			} else{
			    echo "ERROR: Could not able to execute $sql. " . mysqli_error($this->conn);
			    die();
			}

		}

	}

?>