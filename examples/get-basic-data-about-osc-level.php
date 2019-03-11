<?php
	
	/**
	 *	Recubera dados basicos de operacoes baseado em niveis de osc em
	 *	relacao a abertura do mercado e printa na tela o retorno
	 *
	 *	File: get-basic-data-about-osc-level.php
	 *
	 *	@var \WDOAPI\WDOAPI		$wdo 				Carrega a classe da API
	 *	@var date<yyyy-mm-dd>	$startDate 			Data que comeca de contar os candles
	 *	@var date<yyyy-mm-dd>	$endDate 			Data que termina de contar os candles
	 *	@var string<hh:mm:ss>	$startHour 			Data que comeca de contar os candles
	 *	@var string<hh:mm:ss>	$endHour 			Data que comeca de contar os candles
	 *	@var float				$osc 				OSC minima em relaxao a abertura para contar como uma operacao
	 *	@var array				$sgdbArrCandles 	Recupero os candles ja processados entre um intervalo de data
	 *	@var array				$retorno 			Recupera dos dados basicos de Niveis de OSC
	 */

	// Autoload dos arquivos de dependencia
	include('../src/WDOAPI/autoload.php');

	$wdo 			= new \WDOAPI\WDOAPI();

	$startDate		= '2017-08-01';
	$endDate		= '2017-09-01';
	$osc 			= 0.8; // 0.5% de oscilacao por exemplo
	$startHour 		= '09:00:00';
	$endHour 		= '17:00:00';

	$sgdbArrCandles = $wdo->listIntradayData( $startDate, $endDate );
	$retorno 		= $wdo->checkBasicDataAboutNivelOsc( $sgdbArrCandles, $osc, $startHour, $endHour );

	echo '<pre>';
		print_r( $retorno );
	echo '</pre>';

?>