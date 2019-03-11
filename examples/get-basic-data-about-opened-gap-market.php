<?php
	
	/**
	 *	Recubera dados basicos de dias com uma % maxima ou minimo de GAP de abertura de mercado
	 *
	 *	File: get-basic-data-about-opened-gap-market.php
	 *
	 *	@var \WDOAPI\WDOAPI		$wdo 				Carrega a classe da API
	 *	@var date<yyyy-mm-dd>	$startDate 			Data que comeca de contar os candles
	 *	@var date<yyyy-mm-dd>	$endDate 			Data que termina de contar os candles
	 *	@var string<min|max>	$type 				Minimo|maximo de % no GAP de abertura do mercado
	 *	@var float				$osc 				OSC minima em relaxao ao GAP de abertura
	 *	@var array				$sgdbArrCandles 	Recupero os candles ja processados entre um intervalo de data
	 *	@var array				$retorno 			Recupera dos dados basicos de Niveis de OSC no proprio candle
	 */

	// Autoload dos arquivos de dependencia
	include('../src/WDOAPI/autoload.php');

	$wdo 			= new \WDOAPI\WDOAPI();
	$startDate		= '2017-08-01';
	$endDate		= '2017-12-01';
	$osc 			= '0.2'; // 0.2% de oscilacao por exemplo
	$type			= "min";

	$sgdbArrCandles = $wdo->listIntradayData( $startDate, $endDate );
	$retorno 		= $wdo->checkBasicDataAboutGapAberturaOsc( $sgdbArrCandles, $osc, $type );

	echo '<pre>';
		print_r( $retorno );
	echo '</pre>';

?>