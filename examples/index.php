<?php

	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	
	include('../src/WDOAPI/autoload.php');

	$WDOAPI = new WDOAPI\WDOAPI( true );

	// MUDANDO PARA LER ARQUIVOS DE EXPORTACAO DO MT5



	// HISTORICAL DATE

	// Upload WDO Data CSV ( Daily )
	// $WDOAPI->updateHistoricalData( 'samples/WDO$Daily.csv' );	

	// Dados para grafico de osc | Contador de Nivel das Oscilacoes por Niveis
	// $data = $WDOAPI->countDaysByOsc( 90 );

	// Dados para grafico de osc | Contador de Nivel dos Pontos por Niveis
	// $data = $WDOAPI->countDaysByOscByPoints( 90 );

	// Dados para grafico de osc | Contador de Nivel dos Pontos por Niveis
	// $data = $WDOAPI->countDaysByOscByPoints( 300 );

	// Dados para grafico de dias repetidos de grafico de maixa, nulo ou alta | Contador de tipos por low, high ou null
	// $data = $WDOAPI->countTypesRepeatByPeriodDay( 90 );


	// INTRADAY

	// Upload WDO Data Intraday ( M5 )
	// $data = $WDOAPI->updateIntradayData( 'samples/WDO$M5.csv' );

	// Ver pullback candle-a-candle... e ver se nao tem pullback... faz uma pontuacao
	// $data = $WDOAPI->mainCandlesOfDayThatHaveAPullbackAfterSomePeriod( 90, "", 2, 700, 1 );

	// BACKTEST 
	$data = $WDOAPI->manualBacktest( $pastDays = 30 , $options = [] );

	// combinar numero de dias repetidos com osc de pontos do dia anterior por exemplo e ver a media de em que "osc" quando entrar numa operacao
	echo '<pre>';
	print_r( $data );

?>