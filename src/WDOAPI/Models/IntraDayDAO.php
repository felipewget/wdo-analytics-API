<?php

	namespace WDOAPI\Models;

	use \WDOAPI\Bootstrap\MySQL;
	use \Datetime;

	/**
	 * 	Classe representa a tatbela INTRADAY, e possui acoes pra criadas para essa tabela
	 *	@package 	WDOAPI\Models;
	 *	@author 	Fe Oliveira<felipe.wget@gmail.com>
	 *	@version 	1.0.0
	 *	@copyright 	Felipe Rodrigues Oliveira | 2019
	 */
	Class IntraDayDAO extends MySQL {

		public $debug;
		public $conn;
		public $table = "intraday";

		/**
		 *	Construtor da tabela
		 *	- Identifica se tera debug para ver o que esta acontecendo ou nao
		 * 	- Instancia contrutor da classe extend
		 *
		 *	@param bool $debug Se tera ou nao o debug
		 */
		public function __construct( $debug = false ){

			$this->debug = $debug;
			parent::__construct();

		}

		/**
		 *	Insere dados de uma linha ja procesada de CSV do arquivo exportado o MT4|MT5 no banco de dados
		 *
		 *	@param array $data Dados para inserir na tabela
		 *	@return array
		 */
		public function insertDataCSV( $data ){

			foreach( $data as $arr ){

				$conn = $this->getConnect();

				$query = " SELECT * FROM intraday WHERE date='". addslashes( $arr['date']) ."'";
				$data = mysqli_query( $conn, $query );   

				$tem = 0;
				while($row = mysqli_fetch_array($data)){
					$tem = 1;
				}

				if( $tem == 0 ){
				
					$sql = "";
					$sql .= "INSERT INTO intraday (`date`, `close`, `open`, `max`, `min`, `type`, `dif_points`, `var`, `var_in_max`, `var_in_min`, `day_week`, `volume`) ";
					$sql .= "VALUES('". addslashes( $arr['date']) ."', '". addslashes( $arr['closed']) ."', '". addslashes( $arr['opened']) ."', '". addslashes( $arr['max']) ."', '". addslashes( $arr['min']) ."', '". addslashes( $arr['type']) ."', '". addslashes( $arr['var_dif_points']) ."', '". addslashes( $arr['var']) ."', '". addslashes( $arr['var_in_max']) ."', '". addslashes( $arr['var_in_min']) ."', '". addslashes( $arr['day_week']) ."', '". $arr['volume'] ."');";
					
					$this->exec( $sql );

				}

			}

			return [
				'cod' => 200
			];


		}

	}

?>