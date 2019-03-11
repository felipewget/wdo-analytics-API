<?php

	namespace WDOAPI\Bootstrap;

	use \WDOAPI\Config\Settings;
	use Exception;

	/**
	 *	Contem metodos do MySQL
	 *	@package 	WDOAPI\Bootstrap
	 *	@author 	Fe Oliveira<felipe.wget@gmail.com>
	 *	@version 	1.0.0
	 *	@copyright 	Felipe Rodrigues Oliveira | 2019
	 */
	Class MySQL extends Settings {


		/**
		 *	@var bool 				$debug	Se for true, mostra querys que estao acontecendo
		 *	@var mysql_connection 	$conn	Armazena conexao com banco de dados
		 */

		public $debug;
		public $conn;


		/**
		 *	Define se tera debug e conecta ao SGBD
		 *	@param bool $debug Se for true, mostra querys que estao acontecendo
		 */
		public function __construct( $debug = false )
		{

			$this->debug = $debug;
			$this->connect();

		}


		/**
		 *	Recupera variavel $conn, que armazena a conexao com o SGBD
		 *	@return mysql_connection
		 */
		public function getConnect()
		{

			return $this->conn;

		}


		/**
		 *	Executa MySql
		 *	@param 	string<Query> $sql Query que sera executada no MySQL
		 *	@return bool $response Retorna true se a query for executada
		 */
		public function exec( $sql )
		{


			/**
			 *	@var string $sql		Query que sera executada
			 *	@var bool 	$response	Se a query for executada, retorna true
			 */

			$response;

			try {

				if( mysqli_query( $this->conn , $sql ) ) {

					$response = true;

				} else {

					throw new Exception( mysqli_error($this->conn) );

				}

				return $response;

			} catch( Exception $e ) {

				throw new Exception( $e->getMessage() . " | Query: " . $sql );

			}

		}


		/**
		 *	Reseta os dados de uma tabela
		 *
		 *	@return bool
		 */
		public function truncate()
		{

			$table 	= addslashes( $this->table );

			$sql = "TRUNCATE TABLE {$table};";

			return $this->exec( $sql );

		}


		/**
		 *	Obtem um registro pelo ID
		 *	@param 	array	$param Array de uma coluna com key e valor [ 'coluna' => valor ]
		 *	@return array<Colunas Tabela>|false
		 */
		public function one( $param )
		{

			try {

				$response = false;

				$table 	= addslashes( $this->table );
				$collum = addslashes( array_keys( $param )[0] );
				$value 	= addslashes( $param[ $collum ] );

				$query = "SELECT * FROM {$table} WHERE {$collum}='{$value}' LIMIT 1";
				$data = mysqli_query( $this->conn, $query );

				while( $row = mysqli_fetch_array($data) ){
					$response = (object)$row;
				}

				return $response;

			} catch ( Exception $e ) {

				echo $e->getMessage();

			}

		}


		/**
		 *	Lista registros
		 *
		 *	@return array
		 */
		public function list( $query )
		{

			try {

				$response = [];

				$data = mysqli_query( $this->conn, $query );

				while( $row = mysqli_fetch_array($data) ){
					$response[] = (object)$row;
				}

				return $response;

			} catch ( Exception $e ) {

				echo $e->getMessage();

			}

		}


		/**
		 *	Insere um Registro
		 *
		 *	@param object $obj Objeto com as colunas da tabela
		 * 	@return true|Exception
		 */
		public function save( $obj )
		{

			$arrCollum = [];
			$arrValues = [];

			foreach( $obj as $collum => $value ){

				$arrCollum[] = '`' . addslashes( $collum ) . '`';

				if( $value === null ) {
					$arrValues[] = 'NULL';
				} else {
					$arrValues[] = "'" . addslashes($value) . "'";
				}

			}

			$sql  = "INSERT INTO {$this->table} (" . implode( ',', $arrCollum ) . ") ";
			$sql .= "VALUES(". implode( ',', $arrValues ) .");";

			return $this->exec( $sql );

		}


		/**
		 *	Altera um Registro
		 *
		 *	@return bool
		 */
		public function update( $sql )
		{

			return $this->exec( $sql );

		}


		/**
		 *	Lista registros intraday por ordem de candles intraday 
		 *
		 *	@param $startTimestamp Date('Y-m-d')
		 *	@param $finishTimestamp Date('Y-m-d')
		 *	@return array
		 */
		public function listIntradayData( $startTimestamp, $finishTimestamp )
		{

			// Check if timstamp is date
			
			$query = "SELECT * FROM intraday WHERE date >= '" . $startTimestamp . "' AND date <= '" . $finishTimestamp . "' ORDER BY date ASC";
			return $this->list( $query );

		}


		/**
		 *	Metodo de conexao ao banco de dados, armazena conexao com SGBD
		 *	na variavel da classe "$conn"
		 */
		private function connect()
		{

			try {

				$this->conn = @mysqli_connect( $this->mysqlHostname , $this->mysqlUsername, $this->mysqlPassword, $this->mysqlDb );

				if (!$this->conn) {
					throw new Exception( mysqli_connect_error() );
				}

			} catch ( Exception $e ) {

				echo $e->getMessage();

			}

		}

	}

?>