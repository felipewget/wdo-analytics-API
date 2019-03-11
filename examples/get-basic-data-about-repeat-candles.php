<?php
	
	/**
	 *	Recubera dados basicos de operacoes baseado em numero de candles
	 *	que se repetiram consecutivamente ( candles de alta ou baixa)
	 *
	 *	File: get-basic-data-about-repeat-candles.php
	 *
	 *	@var \WDOAPI\WDOAPI		$wdo 				Carrega a classe da API
	 *	@var date<yyyy-mm-dd>	$startDate 			Data que comeca de contar os candles
	 *	@var date<yyyy-mm-dd>	$endDate 			Data que termina de contar os candles
	 *	@var string<hh:mm:ss>	$startHour 			Data que comeca de contar os candles
	 *	@var string<hh:mm:ss>	$endHour 			Data que comeca de contar os candles
	 *	@var int				$nCandlesRepetidos 	Numero de tipos candles repetivos em sequencia
	 *	@var array				$sgdbArrCandles 	Recupero os candles ja processados entre um intervalo de data
	 *	@var array				$retorno 			Recupera dos dados basicos verificando o numero de candles repetidos
	 */

	// Autoload dos arquivos de dependencia
	include('../src/WDOAPI/autoload.php');

	$wdo 				= new \WDOAPI\WDOAPI();

	$startDate			= '2017-08-01';
	$endDate			= '2017-09-01';
	$nCandlesRepetidos 	= 3;
	$startHour 			= '09:00:00';
	$endHour 			= '17:00:00';


	$sgdbArrCandles 	= $wdo->listIntradayData( $startDate, $endDate );
	$retorno 			= $wdo->checkBasicDataAboutTiposDeCandlesRepetidos( $sgdbArrCandles, $nCandlesRepetidos, $startHour, $endHour );

	echo '<pre>';
		print_r( $retorno );
	echo '</pre>';

?>