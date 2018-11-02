<?php

	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	
	include('../src/WDOAPI/autoload.php');

	$WDOAPI = new WDOAPI\WDOAPI( true );

	// Upload Investing Historical CSV
	// $WDOAPI->updateHistoricalData( 'samples/usd_brl_Dados_historicos.csv' );	

	// Dados para grafico de osc | Contador de Nivel das Oscilacoes por Niveis
	// $data = $WDOAPI->countDaysByOsc( 90 );

	// Dados para grafico de osc | Contador de Nivel dos Pontos por Niveis
	// $data = $WDOAPI->countDaysByOscByPoints( 300 );

	// Dados para grafico de osc | Contador de Nivel dos Pontos por Niveis
	// $data = $WDOAPI->countDaysByOscByPoints( 300 );

	// Dados para grafico de dias repetidos de grafico de maixa, nulo ou alta | Contador de tipos por low, high ou null
	$data = $WDOAPI->countTypesRepeatByPeriodDay( 90 );

	// combinar numero de dias repetidos com osc de pontos do dia anterior por exemplo e ver a media de em que "osc" quando entrar numa operacao

	echo '<pre>';
	print_r( $data );

?>