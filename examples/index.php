<?php

	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	
	include('../src/WDOAPI/autoload.php');

	$WDOAPI = new WDOAPI\WDOAPI( true );

	// Upload Investing Historical CSV
	// $WDOAPI->updateHistoricalData( 'samples/usd_brl_Dados_historicos.csv' );

	// Upload Investing Historical CSV
	// $WDOAPI->updateHistoricalData( 'samples/usd_brl_Dados_historicos.csv' );	

	// Dados para grafico de osc | Contador de Nivel das Oscilacoes por Niveis
	// $data = $WDOAPI->countDaysByOsc( 18 );

	// Dados para grafico de osc | Contador de Nivel das Oscilacoes por Niveis
	// $data = $WDOAPI->countDaysByOscByPoints( 300 );

	echo '<pre>';
	print_r( $data );

?>