<?php

	namespace WDOAPI\SGBD;

	use \Datetime;

	Class IntraDayDAO extends MySQL {

		public $debug;
		public $conn;

		public function __construct( $debug = false ){

			$this->debug = $debug;
			parent::__construct();

		}

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
					
					$this->execQuery( $sql );

				}

			}

			return [
				'cod' => 200
			];


		}

		public function listIntaDayDataDays( $pastDays, $dateTimestamp="" ){

			if( $dateTimestamp == "" ){
				$dateTimestamp = Date('Y-m-d');
			}
			
			$date = new DateTime( $dateTimestamp );
			$date->modify('-' . $pastDays . ' day');

			$beginDate = $date->format('Y-m-d');

			$conn = $this->getConnect();

			$query = "SELECT * FROM intraday WHERE date >= '" . $beginDate . "' ORDER BY date ASC";
			$data = mysqli_query( $conn, $query );

			$arr = [];
			while($row = mysqli_fetch_array($data)){
				$arr[] = $row;
			}

			return $arr;

		}

	}

?>