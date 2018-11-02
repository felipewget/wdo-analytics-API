<?php

	namespace WDOAPI;

	use \Datetime;
	use \WDOAPI\Files\HistoricalData;
	use \WDOAPI\SGBD\HistoricalDataDAO;
	use \WDOAPI\DataInterface\HistoricalDataInterface;
	
	Class WDOAPI {

		private $debug;

		public function __construct( $debug = false )
		{
			$this->debug = $debug;
		}

		/* Historical Data */

		public function updateHistoricalData( $dirCSV )
		{

			set_time_limit( 0 );

			$HistoricalData = new HistoricalData();
			$HistoricalDataDAO = new HistoricalDataDAO();

			$data = $HistoricalData->uploadFileCsv( $dirCSV );
			$response = $HistoricalDataDAO->insertDataCSV( $data );

			return $response;

		}

		public function countDaysByOsc( $pastDays = 30 , $dateTimestamp = "" ){

			$HistoricalDataDAO = new HistoricalDataDAO();
			$HistoricalDataInterface = new HistoricalDataInterface();

			$data = $HistoricalDataDAO->countDaysByOsc( $pastDays );
			$dataInterface = $HistoricalDataInterface->showDataByOscVar( $data );

			return $dataInterface;

		}

		public function countDaysByOscByPoints( $pastDays = 30 , $dateTimestamp = "" ){

			$HistoricalDataDAO = new HistoricalDataDAO();
			$HistoricalDataInterface = new HistoricalDataInterface();

			$data = $HistoricalDataDAO->countDaysByOsc( $pastDays );
			$dataInterface = $HistoricalDataInterface->showDataByOscPoints( $data );

			return $dataInterface;

		}

		public function countTypesRepeatByPeriodDay( $pastDays = 30 , $dateTimestamp = "" ){

			$HistoricalDataDAO = new HistoricalDataDAO();
			$HistoricalDataInterface = new HistoricalDataInterface();

			$data = $HistoricalDataDAO->countDaysByOsc( $pastDays );
			$dataInterface = $HistoricalDataInterface->showDataByTypesRepeat( $data );

			return $dataInterface;

		}


	}

?>