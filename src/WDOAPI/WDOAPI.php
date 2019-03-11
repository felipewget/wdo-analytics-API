<?php

	namespace WDOAPI;

	use \Datetime;
	use \Exception;

	use \WDOAPI\Models\HistoricalDataDAO;

	use \WDOAPI\Services\Migrates\IntraDayMigrate;
	use \WDOAPI\Services\Migrates\HistoricalDataMigrate;
	use \WDOAPI\Services\BackTest\BackTestOperations;
	use \WDOAPI\Services\Train\Train;

	use \WDOAPI\Services\GraphicAnalysisNeurons\NivelOsc;
	use \WDOAPI\Services\GraphicAnalysisNeurons\CandleOsc;
	use \WDOAPI\Services\GraphicAnalysisNeurons\TiposDeCandlesRepetidos;
	use \WDOAPI\Services\GraphicAnalysisNeurons\TiposDeTendenciaRepetidas;
	use \WDOAPI\Services\GraphicAnalysisNeurons\GapAberturaOsc;

	/**
	 *	Classe principal que contem todos os metodos da API
	 *	@package 	WDOAPI
	 *	@author 	Fe Oliveira<felipe.wget@gmail.com>
	 *	@version 	1.0.0
	 *	@copyright 	Felipe Rodrigues Oliveira | 2019
	 */
	Class WDOAPI {


		/**
		 *	Carrega dependencias para execucao dos metodos
		 *
		 *	@param bool $longRequest Identifica se a requisicao e longa. E um booleano, se setado 
		 *							 como "true", remove o limitador de tempo da requisicao
		 *
		 */
		public function __construct( bool $longRequest = false )
		{

			// Se for declarado como requisicao que demora para ter uma resposta, remove o limitador de tempo 
			// da requisicao
			if( $longRequest ){
				set_time_limit( 0 );
			}

		}


		/**
		 *	Atualiza ou Reseta e re-insere dados na tabela "intraday" de um arquivo de dados do grafico csv do Metatrader
		 *
		 *	@param 	string<path> $dir 		Diretorio onde esta o arquivo CSV exportado do MetaTrader
		 *	@param 	bool 		 $truncate 	Se verdadeito, remove todos os registros da tabela antes de inserir os dados
		 *	@return bool
		 *	@todo 	Dados testados foram os candles em M5
		 */
		public function updateIntraDayData( $dir , $truncate = false )
		{
			return ( new IntraDayMigrate() )->migrateTable( $dir, $truncate );
		}


		/**
		 *	Atualiza ou Reseta e re-insere dados na tabela "historical_data" de um arquivo de dados do grafico csv do Metatrader
		 *
		 *	@param 	string<path> $dir 		Diretorio onde esta o arquivo CSV exportado do MetaTrader
		 *	@param 	bool 		 $truncate 	Se verdadeito, remove todos os registros da tabela antes de inserir os dados
		 *	@return bool
		 *	@todo 	Dados testados foram os candles em Daily
		 */
		public function updateHistoricalData( $dir , $truncate = false )
		{
			return ( new HistoricalDataMigrate() )->migrateTable( $dir, $truncate );
		}



		/**
		 *	Verifica um cenario(setup de operacoes) fazendo operacoes e mostra o resultado
		 *
		 *	@param array<candles> $sgbdCandles	Candles ja filtrados entre data de inicio e data final
		 *	@param array 		  $neurons 		Armazena os neuronios ativos e a configuracao dos mesmos para ver quando entrar em uma operacao
		 *	@param array 		  $officeHour 	Horario e inicio das operacoes, por exemplo, as operacoes serao feitas apenas entre as 10 as 14 horas
		 *	@param array 		  $operations 	Armazena dados de configuracao das operacoes, por exemplo: stopgain e stoplog
		 *	@description Exemplo de configuracao:
		 *
		 * 	$neurons = [
		 *		'candle_osc'			=> [
		 *			'active'	=> true,
		 *			'type'		=> 'max', // max|min
		 *			'osc'		=> 0.05,
		 *		],
		 *		'nivel_osc'				=> [
		 *			'active'	=> true,
		 *			'osc'		=> 0.5,
		 *		],
		 *		'candles_repetidos'		=> [
		 *			'active'	=> false,
		 *			'n_candles'	=> 2,
		 *		],
		 *		'tendencias_repetidas'	=> [
		 *			'active'	=> false,
		 *			'n_days'	=> 2,
		 *		],
		 *	];
		 *
		 *	$officeHour = [
		 *		'startAt'	=> '09:00:00',
		 *		'finishAt'	=> '12:20:00'
		 *	];
		 *
		 *	$operations = [
		 *			'stop' => [
		 *				'gain'	=> '10.5',
		 *				'loss'	=> '20', //'loss'	=> '10.5',
		 *			],
		 *			'range_candle' => [
		 *				'min'	=> 5,
		 *				'max'	=> 100,
		 *			],
		 *			'pointsInEmoluments' => '0.5'
		 *	];
		 *
		 *	@return array
		 */
		public function checkCenario( $sgbdCandles, $neurons, $officeHour, $operations )
		{
			return ( new BackTestOperations() )->checkCenario( $sgbdCandles, $neurons, $officeHour, $operations );
		}


		/**
		 *	Lista registros de candles entre a data de inicio e a data final
		 *
		 *	@param date<Y-m-d> $startDate Data de inicio
		 *	@param date<Y-m-d> $endDate   Data de final
		 *	@return array
		 */
		public function listIntraDayData( $startDate, $endDate )
		{

			/**
			 *	@var \WDOAPI\Models\HistoricalDataDAO $modelHistoricalDataDAO Armazena a model HistoricalDataDAO
			 *	@var array 							  $response 			  Armazena os candles e retorna o resultado do metodo
			 */

			$response;

			$modelHistoricalDataDAO = new HistoricalDataDAO();
			$response = $modelHistoricalDataDAO->listIntradayData( $startDate, $endDate );

			return $response;

		}


		/**
		 *	Treina multiplos cenarios e tras as melhores opcoes de acordo com as opcoes selecionadas
		 *	- Faz combinacoes de Neuronios
		 *	- Faz combinacoes de Tipos de Operacoes
		 *
		 *	@param array<candles> $sgbdCandles	  			Candles ja filtrados entre data de inicio e data final
		 *	@param array 		  $configNeurons  			Armazena os neuronios ativos para gerar possiveis rotas de processamento
		 *	@param array 		  $officeHour 	  			Horario e inicio das operacoes, por exemplo, as operacoes serao feitas 
		 *													apenas entre as 10 as 14 horas
		 *	@param array 		  $registersnumberInRank 	Ao final, mostra as melhores possibilidades, o numero de top resultados 
		 *													e definido por este parametro
		 *	@todo 	ESSE METODO E A IA, NAO DA PRA TODAR EM QUALQUER PC
		 *	@return array
		 */
		public function train( $sgbdCandles, $configNeurons, $officeHour, $registersnumberInRank )
		{
			return ( new Train() )->train( $sgbdCandles, $configNeurons, $officeHour, $registersnumberInRank );
		}


		/**
		 *	Treina multiplos cenarios e tras as melhores opcoes de acordo com as opcoes selecionadas
		 *	- Faz combinacoes de Neuronios
		 *
		 *	@param array<candles> $sgbdCandles	  			Candles ja filtrados entre data de inicio e data final
		 *	@param array 		  $configNeurons  			Armazena os neuronios ativos para gerar possiveis rotas de processamento
		 *	@param array 		  $officeHour 	  			Horario e inicio das operacoes, por exemplo, as operacoes serao feitas 
		 *													apenas entre as 10 as 14 horas
		 *	@param array 		  $registersnumberInRank 	Ao final, mostra as melhores possibilidades, o numero de top resultados 
		 *													e definido por este parametro
		 *	@todo 	ESSE METODO E A IA, NAO DA PRA TODAR EM QUALQUER PC
		 *	@return array
		 */
		public function trainNeurons( $sgbdCandles, $configNeurons, $officeHour, $registersnumberInRank )
		{
			return ( new Train() )->trainNeurons( $sgbdCandles, $configNeurons, $officeHour, $registersnumberInRank );
		}

		
		/**
		 *	Recupera dados de quantidade de operacoes, quais operacoes e datas de operacoes por
		 *	Nivel de OSC em relaxao a abertura do dia
		 *
		 *	@param 	array<candles> $sgdbArrCandles	Candles ja filtrados entre data de inicio e data final
		 *	@param 	float 		   $osc 			Osc minima como 1.0 de osc em relaxao a abertura para fazer uma operacao
		 *	@param 	string<hh:mm>  $startHour 		Hora inicial do em que comeca a verificar opercoes, ex: 09:00
		 *	@param 	string<hh:mm>  $endHour	 		Hora final do em que termina as operacoes do dia, ex: 15:00
		 *	@return array
		 */
		public function checkBasicDataAboutNivelOsc( $sgdbArrCandles, $osc, $startHour, $endHour )
		{
			return ( new NivelOsc() )->check( $sgdbArrCandles, $osc, $startHour, $endHour );
		}


		/**
		 *	Recupera dados de quantidade de operacoes, quais operacoes e datas de operacoes por
		 *	Nivel de OSC em relaxao ao proprio candle, ex: o candle teve uma osc de 0.5 em relaxao a abertura
		 *	do proprio candle
		 *
		 *	@param 	array<candles> $sgdbArrCandles	Candles ja filtrados entre data de inicio e data final
		 *	@param 	float 		   $osc 			Osc minima|maxima como 1.0 de osc em relaxao a abertura do proprio candle
		 *	@param 	string<hh:mm>  $startHour 		Hora inicial do em que comeca a verificar opercoes, ex: 09:00
		 *	@param 	string<hh:mm>  $endHour	 		Hora final do em que termina as operacoes do dia, ex: 15:00
		 *	@param 	string 		   type 			Valores "min" ou "max", minimo ou maximo de tal osc para ser valido
		 *	@return array
		 */
		public function checkBasicDataAboutCandleOsc( $sgdbArrCandles, $osc, $type, $startHour, $endHour )
		{
			return ( new CandleOsc() )->check( $sgdbArrCandles, $osc, $type, $startHour, $endHour );
		}


		/**
		 *	Recupera dados de quantidade de operacoes, quais operacoes e datas de operacoes por
		 *	numero de X candles de alta|baixa repetidas
		 *
		 *	@param 	array<candles> $sgdbArrCandles		Candles ja filtrados entre data de inicio e data final
		 *	@param 	int 		   $nCandlesRepetidos 	Numero de candles repetidos para ser valido
		 *	@param 	string<hh:mm>  $startHour	 		Hora inicial do em que comeca a verificar opercoes, ex: 09:00
		 *	@param 	string<hh:mm>  $endHour	 			Hora final do em que termina as operacoes do dia, ex: 15:00
		 *	@return array
		 */
		public function checkBasicDataAboutTiposDeCandlesRepetidos( $sgdbArrCandles, $nCandlesRepetidos, $startHour, $endHour )
		{
			return ( new TiposDeCandlesRepetidos() )->check( $sgdbArrCandles, $nCandlesRepetidos, $startHour, $endHour );
		}


		/**
		 *	Recupera dados de quantidade de operacoes, quais operacoes e datas de operacoes por
		 *	numero de X tendencias de alta|baixa repetidas
		 *
		 *	@param 	array<candles> $sgdbArrCandles			Candles ja filtrados entre data de inicio e data final
		 *	@param 	int 		   $nTendenciaDiaRepetidos 	Numero de dias com determinada tendencia repetida
		 *	@param 	string<hh:mm>  $startHour	 			Hora inicial do em que comeca a verificar opercoes, ex: 09:00
		 *	@param 	string<hh:mm>  $endHour	 				Hora final do em que termina as operacoes do dia, ex: 15:00
		 *	@return array
		 */
		public function checkBasicDataAboutTiposDeTendenciaRepetidas( $sgdbArrCandles, $nTendenciaDiaRepetidos, $startHour, $endHour )
		{
			return ( new TiposDeTendenciaRepetidas() )->check( $sgdbArrCandles, $nTendenciaDiaRepetidos, $startHour, $endHour );
		}


		/**
		 *	Recubera dados basicos de dias com uma % maxima ou minimo de GAP de abertura de mercado
		 *
		 *	@param 	array<candles> 	$sgdbArrCandles		Candles ja filtrados entre data de inicio e data final
		 *	@param 	string<min|max>	$type 				Minimo|maximo de % no GAP de abertura do mercado
		 *	@param 	float			$osc 				OSC minima em relaxao ao GAP de abertura
		 */
		public function checkBasicDataAboutGapAberturaOsc( $sgdbArrCandles, $osc, $type )
		{
			return ( new GapAberturaOsc() )->check( $sgdbArrCandles, $osc, $type );
		}

	}

?>