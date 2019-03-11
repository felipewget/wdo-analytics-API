<?php
	
	/**
	 *	Verifica um cenario especifico com uma configuracao de setup de opercoes
	 *
	 *	File: check-cenarie.php
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

	$wdo 					= new \WDOAPI\WDOAPI( $longRequest = true );

	$startDate				= '2017-10-01';
	$endDate				= '2017-11-01';

	$configNeurons			= [
		'candle_osc'			=> [
			'active'		=> true,
			'type'			=> 'max',
			'osc' 			=> 0.1, 
		],
	 	'nivel_osc'				=> [
			'active'		=> true,
			'osc' 			=> 0.1, 
		],
		'candles_repetidos'		=> [
			'active'		=> true,
			'n_candles' 	=> 4,
		],
		'tendencias_repetidas'	=> [
			'active'		=> false, //true,
			'n_days' 		=> 2,
		],
		'gap_abertura'			=> [
			'active'		=> true,
			'type'			=> 'max',
			'osc' 			=> 0.19, 
		],
	];

	$officeHour = [
			'startAt'	=> '09:00:00',
			'finishAt'	=> '12:30:00'
	];

	$configOperations = [
			'stop' => [
				'gain'	=> '20', // ou 0.5%
				'loss'	=> '20',
			],
			'range_candle' => [
				'min'	=> 0,
				'max'	=> 1000,
			],
			'pointsInEmoluments' => '0.5'
	];

	$sgdbArrCandles = $wdo->listIntradayData( $startDate, $endDate );

	$retorno = $wdo->checkCenario( $sgdbArrCandles, $configNeurons, $officeHour, $configOperations );

	echo '<pre>';
		print_r( $retorno );
	echo '</pre>';

?>