<?php

	namespace WDOAPI;

	use \Datetime;
	use \WDOAPI\CURL\Advfn;
	use \WDOAPI\Files\HistoricalData;
	use \WDOAPI\SGBD\HistoricalDataDAO;
	
	Class WDOAPI {

		private $debug;

		private $sgbd;

		private $paperMounth = [
			1  => 'WDOG',
			2  => 'WDOH',
			3  => 'WDOJ',
			4  => 'WDOK',
			5  => 'WDOM',
			6  => 'WDON',
			7  => 'WDOQ',
			8  => 'WDOU',
			9  => 'WDOV',
			10 => 'WDOX',
			11 => 'WDOZ',
			12 => 'WDOF',
		];

		public function __construct( $debug = false )
		{
			
			$this->debug = $debug;

		}

		public function updateHistoricalData( $dirCSV )
		{

			$HistoricalData = new HistoricalData();
			$HistoricalDataDAO = new HistoricalDataDAO();

			$data = $HistoricalData->uploadFileCsv( $dirCSV );
			$HistoricalDataDAO->insertDataCSV( $data );

		}

		public function updateData( $mount ){

			$dvfn = new Advfn();

			for( $i = 0; $i <= $mount; $i++ ){

				$date = new DateTime();

				if( $i > 0 ){
					$date->modify('-' . $i . ' month');
				}

				$yearContract = $date->format('Y');
				$monthContract = $date->format('m');

				$date = $yearContract . "-" . $monthContract;
				$contract = $this->paperMounth[ (int)$monthContract ] . $yearContract ;
				$firstDayInMonth = date("Y-m-01", strtotime($date));
				$lastDayInMonth = date("Y-m-t", strtotime($date));

				// $rates = $dvfn->getRates( $contract, $firstDayInMonth, $lastDayInMonth );

				// echo '<pre>';
				// print_r($rates);

				// die();
				
				if( $this->debug ){

					echo 'Primeiro dia do Mes : '. $firstDayInMonth .' - Ultimo dia do Mes : '. $lastDayInMonth; 
					echo '<br />';
					echo $monthContract . '-' . $yearContract .' | ' . $this->paperMounth[ (int)$monthContract ] . $yearContract . '<hr />';
				}

			}

		}

	}

?>