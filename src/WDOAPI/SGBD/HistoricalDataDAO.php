<?php

	namespace WDOAPI\SGBD;

	Class HistoricalDataDAO extends MySQL {

		public $debug;
		public $conn;

		public function __construct( $debug = false ){

			$this->debug = $debug;
			parent::__construct();

		}

		public function insertDataCSV( $data ){

			foreach( $data as $arr ){

				$conn = $this->getConnect();

				$query = " SELECT * FROM historical_data WHERE date='". addslashes( $arr['date']) ."'";
				$data = mysqli_query( $conn, $query );   

				$tem = 0;
				while($row = mysqli_fetch_array($data)){
					$tem = 1;
				}

				if( $tem == 0 ){
				
					$sql = "";
					$sql .= "INSERT INTO historical_data (`date`, `close`, `open`, `max`, `min`, `type`, `dif_points`, `var`, `var_in_max`, `var_in_min`, `day_week`, `volume`) ";
					$sql .= "VALUES('". addslashes( $arr['date']) ."', '". addslashes( $arr['closed']) ."', '". addslashes( $arr['opened']) ."', '". addslashes( $arr['max']) ."', '". addslashes( $arr['min']) ."', '". addslashes( $arr['type']) ."', '". addslashes( $arr['var_dif_points']) ."', '". addslashes( $arr['var']) ."', '". addslashes( $arr['var_in_max']) ."', '". addslashes( $arr['var_in_min']) ."', '". addslashes( $arr['day_week']) ."', '". $arr['volume'] ."');";
					
					$this->execQuery( $sql );

				}

			}

			return [
				'cod' => 200
			];


		}

		public function listHistoricalDataDays( $pastDays, $dateTimestamp="" ){

			if( $dateTimestamp != "" ){
				$dateTimestamp = ' WHERE date="' . $dateTimestamp . '" ';
			}

			$conn = $this->getConnect();

			$query = "SELECT * FROM historical_data " . $dateTimestamp . " ORDER BY date DESC LIMIT " . $pastDays;
			$data = mysqli_query( $conn, $query );

			$arr = [];
			while($row = mysqli_fetch_array($data)){
				$arr[] = $row;
			}

			$arr = array_reverse($arr);

			return $arr;

		}

	}

?>