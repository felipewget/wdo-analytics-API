<?php
	
	/**
	 * @TODO FAZER 
	 *	Verifica um cenario especifico com uma configuracao de setup de opercoes
	 *
	 *	File: check-cenarie-month-to-month.php
	 *
	 *	@var \WDOAPI\WDOAPI		$wdo 					Carrega a classe da API
	 *	@var date<yyyy-mm-dd>	$startDate 				Data que comeca de contar os candles
	 *	@var date<yyyy-mm-dd>	$endDate 				Data que termina de contar os candles
	 *	@var array				$sgdbArrCandles 		Recupero os candles ja processados entre um intervalo de data
	 *	@var array 				$retorno				Retorno das opcoes de config. de neurorios que mais deram resultados
	 *	@var array 				$configNeurons			Configuracao de neuronios ativos e desativados
	 *	@var array 				$officeHour 			Horario que comeca e termina as opecoes no dia, ex: vou operar das 9 as 12:30
	 *	@var array 				$configOperations 		Config de operacao prefixada
	 *	@var bool 				$longRequest			Carrega dependencias para permitir que requisicoes longas sem time limit
	 *
	 *	@todo E UMA IA, pode chegar a verificar algumas MILHOES DE POSSIBILIDADES, ENTAO O RESULTADO NAO VAI FICAR PRONTO DO DIA PRA NOITE
	 *		  DEPENDENDO DA CONFIGURACAO, recomendo rodar em um PC|Server bom
	 *	@todo Aprimoramento constante, talvez haja mais neuronios prontos, sendo assim, mais configuracoes de neuronios
	 */

	// Autoload dos arquivos de dependencia
	include('../src/WDOAPI/autoload.php');

	$count = 0;

	function printTela( $retorno )
	{

		echo 'Mes: ' . $retorno["cenario"]["between_data"]["started_at"] .'<br />';
		echo 'Resultado em pontos: ' . $retorno['resumo']['resultado_pontos'] .' ( ' . $retorno['resumo']['count_operacoes'] . ' operacoes) ' . '<br />';
		echo 'Maximo de perda: ' . $retorno['resumo']['risk']['max_loss_in_point'];
		echo '<hr />';
	}

	$wdo 					= new \WDOAPI\WDOAPI( $longRequest = true );

	$configNeurons			= [
		'candle_osc'			=> [
			'active'		=> true,
			'type'			=> 'min',
			'osc' 			=> 0.08, 
		],
	 	'nivel_osc'				=> [
			'active'		=> false,
			'osc' 			=> 0.2, 
		],
		'candles_repetidos'		=> [
			'active'		=> false,
			'n_candles' 	=> 4,
		],
		'tendencias_repetidas'	=> [
			'active'		=> false, //true,
			'n_days' 		=> 2,
		],
		'gap_abertura'			=> [
			'active'		=> true,
			'type'			=> 'max',
			'osc' 			=> 0.3, 
		],
	];

	$officeHour = [
			'startAt'	=> '09:00:00',
			'finishAt'	=> '17:00:00'
	];

	$configOperations = [
			'stop' => [
				'gain'	=> '20', // ou 0.5%
				'loss'	=> '15',
			],
			'range_candle' => [
				'min'	=> 0,
				'max'	=> 1000,
			],
			'prevention_of_price_back' => [
				'active' 		=> true,
				'min_candle' 	=> 5,
				'after_points' 	=> 6,
				'get_out_at' 	=> 4,
			],
			'pointsInEmoluments' => '0.5'
	];

	$startDate				= '2017-01-01';
	$endDate				= '2017-02-01';
	$sgdbArrCandles = $wdo->listIntradayData( $startDate, $endDate );
	$retorno = $wdo->checkCenario( $sgdbArrCandles, $configNeurons, $officeHour, $configOperations );
	printTela( $retorno );
	$count = $count + $retorno['resumo']['resultado_pontos'];

	$startDate				= '2017-02-01';
	$endDate				= '2017-03-01';
	$sgdbArrCandles = $wdo->listIntradayData( $startDate, $endDate );
	$retorno = $wdo->checkCenario( $sgdbArrCandles, $configNeurons, $officeHour, $configOperations );
	printTela( $retorno );
	$count = $count + $retorno['resumo']['resultado_pontos'];

	$startDate				= '2017-03-01';
	$endDate				= '2017-04-01';
	$sgdbArrCandles = $wdo->listIntradayData( $startDate, $endDate );
	$retorno = $wdo->checkCenario( $sgdbArrCandles, $configNeurons, $officeHour, $configOperations );
	printTela( $retorno );
	$count = $count + $retorno['resumo']['resultado_pontos'];

	$startDate				= '2017-04-01';
	$endDate				= '2017-05-01';
	$sgdbArrCandles = $wdo->listIntradayData( $startDate, $endDate );
	$retorno = $wdo->checkCenario( $sgdbArrCandles, $configNeurons, $officeHour, $configOperations );
	printTela( $retorno );
	$count = $count + $retorno['resumo']['resultado_pontos'];

	$startDate				= '2017-05-01';
	$endDate				= '2017-06-01';
	$sgdbArrCandles = $wdo->listIntradayData( $startDate, $endDate );
	$retorno = $wdo->checkCenario( $sgdbArrCandles, $configNeurons, $officeHour, $configOperations );
	printTela( $retorno );
	$count = $count + $retorno['resumo']['resultado_pontos'];

	$startDate				= '2017-06-01';
	$endDate				= '2017-07-01';
	$sgdbArrCandles = $wdo->listIntradayData( $startDate, $endDate );
	$retorno = $wdo->checkCenario( $sgdbArrCandles, $configNeurons, $officeHour, $configOperations );
	printTela( $retorno );
	$count = $count + $retorno['resumo']['resultado_pontos'];

	$startDate				= '2017-07-01';
	$endDate				= '2017-08-01';
	$sgdbArrCandles = $wdo->listIntradayData( $startDate, $endDate );
	$retorno = $wdo->checkCenario( $sgdbArrCandles, $configNeurons, $officeHour, $configOperations );
	printTela( $retorno );
	$count = $count + $retorno['resumo']['resultado_pontos'];

	$startDate				= '2017-08-01';
	$endDate				= '2017-09-01';
	$sgdbArrCandles = $wdo->listIntradayData( $startDate, $endDate );
	$retorno = $wdo->checkCenario( $sgdbArrCandles, $configNeurons, $officeHour, $configOperations );
	printTela( $retorno );
	$count = $count + $retorno['resumo']['resultado_pontos'];

	$startDate				= '2017-09-01';
	$endDate				= '2017-10-01';
	$sgdbArrCandles = $wdo->listIntradayData( $startDate, $endDate );
	$retorno = $wdo->checkCenario( $sgdbArrCandles, $configNeurons, $officeHour, $configOperations );
	printTela( $retorno );
	$count = $count + $retorno['resumo']['resultado_pontos'];

	$startDate				= '2017-10-01';
	$endDate				= '2017-11-01';
	$sgdbArrCandles = $wdo->listIntradayData( $startDate, $endDate );
	$retorno = $wdo->checkCenario( $sgdbArrCandles, $configNeurons, $officeHour, $configOperations );
	printTela( $retorno );
	$count = $count + $retorno['resumo']['resultado_pontos'];

	$startDate				= '2017-11-01';
	$endDate				= '2017-12-01';
	$sgdbArrCandles = $wdo->listIntradayData( $startDate, $endDate );
	$retorno = $wdo->checkCenario( $sgdbArrCandles, $configNeurons, $officeHour, $configOperations );
	printTela( $retorno );
	$count = $count + $retorno['resumo']['resultado_pontos'];

	$startDate				= '2017-12-01';
	$endDate				= '2018-01-01';
	$sgdbArrCandles = $wdo->listIntradayData( $startDate, $endDate );
	$retorno = $wdo->checkCenario( $sgdbArrCandles, $configNeurons, $officeHour, $configOperations );
	printTela( $retorno );
	$count = $count + $retorno['resumo']['resultado_pontos'];

	$startDate				= '2018-01-01';
	$endDate				= '2018-02-01';
	$sgdbArrCandles = $wdo->listIntradayData( $startDate, $endDate );
	$retorno = $wdo->checkCenario( $sgdbArrCandles, $configNeurons, $officeHour, $configOperations );
	printTela( $retorno );
	$count = $count + $retorno['resumo']['resultado_pontos'];

	$startDate				= '2018-03-01';
	$endDate				= '2018-04-01';
	$sgdbArrCandles = $wdo->listIntradayData( $startDate, $endDate );
	$retorno = $wdo->checkCenario( $sgdbArrCandles, $configNeurons, $officeHour, $configOperations );
	printTela( $retorno );
	$count = $count + $retorno['resumo']['resultado_pontos'];

	$startDate				= '2018-04-01';
	$endDate				= '2018-05-01';
	$sgdbArrCandles = $wdo->listIntradayData( $startDate, $endDate );
	$retorno = $wdo->checkCenario( $sgdbArrCandles, $configNeurons, $officeHour, $configOperations );
	printTela( $retorno );
	$count = $count + $retorno['resumo']['resultado_pontos'];

	$startDate				= '2018-05-01';
	$endDate				= '2018-06-01';
	$sgdbArrCandles = $wdo->listIntradayData( $startDate, $endDate );
	$retorno = $wdo->checkCenario( $sgdbArrCandles, $configNeurons, $officeHour, $configOperations );
	printTela( $retorno );
	$count = $count + $retorno['resumo']['resultado_pontos'];

	$startDate				= '2018-06-01';
	$endDate				= '2018-07-01';
	$sgdbArrCandles = $wdo->listIntradayData( $startDate, $endDate );
	$retorno = $wdo->checkCenario( $sgdbArrCandles, $configNeurons, $officeHour, $configOperations );
	printTela( $retorno );
	$count = $count + $retorno['resumo']['resultado_pontos'];

	$startDate				= '2018-07-01';
	$endDate				= '2018-08-01';
	$sgdbArrCandles = $wdo->listIntradayData( $startDate, $endDate );
	$retorno = $wdo->checkCenario( $sgdbArrCandles, $configNeurons, $officeHour, $configOperations );
	printTela( $retorno );
	$count = $count + $retorno['resumo']['resultado_pontos'];

	$startDate				= '2018-08-01';
	$endDate				= '2018-09-01';
	$sgdbArrCandles = $wdo->listIntradayData( $startDate, $endDate );
	$retorno = $wdo->checkCenario( $sgdbArrCandles, $configNeurons, $officeHour, $configOperations );
	printTela( $retorno );
	$count = $count + $retorno['resumo']['resultado_pontos'];

	$startDate				= '2018-09-01';
	$endDate				= '2018-10-01';
	$sgdbArrCandles = $wdo->listIntradayData( $startDate, $endDate );
	$retorno = $wdo->checkCenario( $sgdbArrCandles, $configNeurons, $officeHour, $configOperations );
	printTela( $retorno );
	$count = $count + $retorno['resumo']['resultado_pontos'];

	$startDate				= '2018-10-01';
	$endDate				= '2018-11-01';
	$sgdbArrCandles = $wdo->listIntradayData( $startDate, $endDate );
	$retorno = $wdo->checkCenario( $sgdbArrCandles, $configNeurons, $officeHour, $configOperations );
	printTela( $retorno );
	$count = $count + $retorno['resumo']['resultado_pontos'];

	$startDate				= '2018-11-01';
	$endDate				= '2018-12-01';
	$sgdbArrCandles = $wdo->listIntradayData( $startDate, $endDate );
	$retorno = $wdo->checkCenario( $sgdbArrCandles, $configNeurons, $officeHour, $configOperations );
	printTela( $retorno );
	$count = $count + $retorno['resumo']['resultado_pontos'];


	$startDate				= '2018-12-01';
	$endDate				= '2019-01-01';
	$sgdbArrCandles = $wdo->listIntradayData( $startDate, $endDate );
	$retorno = $wdo->checkCenario( $sgdbArrCandles, $configNeurons, $officeHour, $configOperations );
	printTela( $retorno );
	$count = $count + $retorno['resumo']['resultado_pontos'];
	

	echo '<hr /><hr />';
	echo 'Total: ' . $count . ' Pontos ( R$ ' . $count * 10 . ' por contrato ) ' ;
	// criar moelo de operacoes que sai no preco apos num x de candles percorridos e esta em gain

?>