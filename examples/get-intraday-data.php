<?php
	
	/**
	 *	Recubera registros de candles intraday entre datas
	 *
	 *	File: get-intraday-data.php
	 *
	 *	@var \WDOAPI\WDOAPI		$wdo 					Carrega a classe da API
	 *	@var date<yyyy-mm-dd>	$startDate 				Data que comeca de contar os candles
	 *	@var date<yyyy-mm-dd>	$endDate 				Data que termina de contar os candles
	 *	@var array				$sgdbArrCandles 		Recupero os candles ja processados entre um intervalo de data
	 */

	// Autoload dos arquivos de dependencia
	include('../src/WDOAPI/autoload.php');

	$wdo 					= new \WDOAPI\WDOAPI();

	$startDate				= '2017-08-01';
	$endDate				= '2017-09-01';

	$sgdbArrCandles = $wdo->listIntradayData( $startDate, $endDate );

	echo '<pre>';
		print_r( $sgdbArrCandles );
	echo '</pre>';

?>