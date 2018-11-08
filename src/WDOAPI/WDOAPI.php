<?php

	namespace WDOAPI;

	use \Datetime;

	use \WDOAPI\Files\HistoricalData;
	use \WDOAPI\Files\IntraDay;

	use \WDOAPI\SGBD\IntraDayDAO;
	use \WDOAPI\SGBD\HistoricalDataDAO;

	use \WDOAPI\DataInterface\HistoricalDataInterface;
	use \WDOAPI\DataInterface\IntraDayInterface;

	use \WDOAPI\Operations\PullBack;
	use \WDOAPI\Operations\BackTest;
	
	Class WDOAPI {

		private $debug;

		public function __construct( $debug = false )
		{
			$this->debug = $debug;
		}

		// ---------------- //
		// HISTORICAL DATA  //
		// ---------------- //

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

			$data = $HistoricalDataDAO->listHistoricalDataDays( $pastDays );
			$dataInterface = $HistoricalDataInterface->showDataByOscVar( $data );

			return $dataInterface;

		}

		public function countDaysByOscPerMaxAndMin( $pastDays = 30 , $dateTimestamp = "" ){

			$HistoricalDataDAO = new HistoricalDataDAO();
			$HistoricalDataInterface = new HistoricalDataInterface();

			$data = $HistoricalDataDAO->listHistoricalDataDays( $pastDays );
			$dataInterface = $HistoricalDataInterface->showDataByOscVarMinAndMaxOfDay( $data );

			return $dataInterface;

		}

		public function countDaysByOscByPoints( $pastDays = 30 , $dateTimestamp = "" ){

			$HistoricalDataDAO = new HistoricalDataDAO();
			$HistoricalDataInterface = new HistoricalDataInterface();

			$data = $HistoricalDataDAO->listHistoricalDataDays( $pastDays );
			$dataInterface = $HistoricalDataInterface->showDataByOscPoints( $data );

			return $dataInterface;

		}

		public function countTypesRepeatByPeriodDay( $pastDays = 30 , $dateTimestamp = "" ){

			$HistoricalDataDAO = new HistoricalDataDAO();
			$HistoricalDataInterface = new HistoricalDataInterface();

			$data = $HistoricalDataDAO->listHistoricalDataDays( $pastDays );
			$dataInterface = $HistoricalDataInterface->showDataByTypesRepeat( $data );

			return $dataInterface;

		}

		// -------------- //
		// INTRADAY DATA  //
		// -------------- //

		// Horarios de candles que mais retornam ao preco apos um minimo de X candles
		// principais candles que tem um pullback apos alguns periodo
		// Retracao
		// Se o preco estiver a favor da retracao "retraction", considerar
		public function mainCandlesOfDayThatHaveAPullbackAfterSomePeriod( $pastDays = 30 , $dateTimestamp = "", $minimunOfNumberOfCandles = 3, $maximunOfNumberOfCandles=500, $minOsc = 0, $minimumPoints=0 )
		{

			$IntraDayDAO = new IntraDayDAO();
			$PullBack = new PullBack();

			// Group, a cada 30 minutos e agrupa os pontos - Fazer
			$data = $IntraDayDAO->listIntaDayDataDays( $pastDays );
			$ret = $PullBack->testRetraction( $data, $minimunOfNumberOfCandles, $maximunOfNumberOfCandles, $minOsc, $minimumPoints );
			return $ret;

		}

		public function mainCandlesOfDayThatHavePullbackPerOsc( $pastDays = 30 , $dateTimestamp = "", $minimunOfNumberOfCandles = 3, $maximunOfNumberOfCandles=500, $minimumPoints=0, $validarPelaSombra = 0 )
		{



			$IntraDayDAO = new IntraDayDAO();
			$PullBack = new PullBack();

			// Group, a cada 30 minutos e agrupa os pontos - Fazer
			$data = $IntraDayDAO->listIntaDayDataDays( $pastDays );
			$ret = $PullBack->testRetractionByOsc( $data, $minimunOfNumberOfCandles, $maximunOfNumberOfCandles, $minimumPoints, $validarPelaSombra );
			return $ret;

		}

		public function updateIntradayData( $dirCSV )
		{

			set_time_limit( 0 );
			ini_set('memory_limit', '-1');

			$IntraDay = new IntraDay();
			$IntraDayDAO = new IntraDayDAO();

			$data = $IntraDay->uploadFileCsv( $dirCSV );
			$response = $IntraDayDAO->insertDataCSV( $data );

			return $response;

		}

		public function listPeriodDaysOsc( $pastDays = 30 , $dateTimestamp = "" ){

			// GET DATA	
			// $data;
			// $response = $IntraDayDAO->

		}


		// quais periodos do dia e qual osc estava
		// quais periodos do dia ele estava a cima ou a abaixo da abertura
		// listar graficos por dia

		// ---- //
		// NEWS //
		// ---- //

		public function updateEconomicCalendar( $dirCSV ){}
		public function listNewsByPeriod( $pastDays = 30 , $dateTimestamp = "", $levelImportance= null ){}
		// Noticias que mais surgiram efeitos no grafico ( $minutostempoApos = 5|10|15 )
									// Por pais tambem
									// Por horario do dia

		// ---------------- //
		// MANUAL BACKTEST  //
		// ---------------- //

		// $options = [
		// 	'after_period_tendence_days' => 4,
		// 	'operation_in' => [
		// 		'type' => 'percentage',
		// 		'value' => '2',
		// 		'hour' => [
		// 			'start' => '09:00',
		// 			'finish' => '15:00',
		// 		]
		// 	],
		// 	'stop_loss' => [
		// 		'type' => 'percentage',
		// 		'value' => '1.5'
		// 	],
		// 	'stop_gain' => [
		// 		'type' => 'percentage',
		// 		'value' => '1'
		// 	],
		// ];

		public function manualBacktest( $pastDays = 30 , $options, $dateTimestamp = "" ){

			$IntraDayDAO = new IntraDayDAO();
			$BackTest = new BackTest();

			// // Group, a cada 30 minutos e agrupa os pontos - Fazer
			$data = $IntraDayDAO->listIntaDayDataDays( $pastDays );
			$BackTest->backTestRetraction( $data );
			// var_dump($data);
			die();

			// return $PullBack->testRetraction( $data, $minimunOfNumberOfCandles, $maximunOfNumberOfCandles, $minOsc );


		}

		// ----------------- //
		// IA SUPERVISIONADO //
		// ----------------- //


		// ----------------- //
		// IA AUTOMATIZADA //
		// ----------------- //

	}

?>